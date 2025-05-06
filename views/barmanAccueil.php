<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Boissons</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/nav.css?v=6">
    <link rel="stylesheet" href="css/barmanAccueil.css?v=6">
    <link rel="stylesheet" href="css/Modale_Barman.css?v=3">
</head>

<body class="container">
<?php
if ($tables && is_array($tables)) {
    echo "<div class='zones-container'>";

    foreach ($zones as $zoneName => $ids) {
        echo "<div class='zone'><h2>$zoneName</h2>";
        echo "<div class='zone-buttons'>";

        $tablesInZone = array_filter($tables, function($table) use ($ids) {
            return in_array($table['ID_TABLES'], $ids);
        });
        $tablesInZone = array_values($tablesInZone); // réindexe l'array
        $total = count($tablesInZone);

        for ($i = 0; $i < $total; $i++) {
            $table = $tablesInZone[$i];
            $id = $table['ID_TABLES'];
            $statut = $table['statut_table'];

            // Si c'est le dernier ET qu'il est seul dans sa ligne
            if ($i === $total - 1 && $total % 2 !== 0) {
                echo "<div class='button-center'>";
                echo "<button class='table-btn' data-statut='$statut' data-id='$id'>Table $id</button>";
                echo "</div>";
            } else {
                // Nouvelle ligne tous les 2 boutons
                if ($i % 2 === 0) echo "<div class='button-row'>";

                echo "<button class='table-btn' data-statut='$statut' data-id='$id'>Table $id</button>";

                if ($i % 2 === 1) echo "</div>";
            }
        }

        echo "</div>"; // .zone-buttons
        echo "</div>"; // .zone
    }

    echo "</div>"; // .zones-container
} else {
    echo "Erreur lors du chargement des tables.";
}
?>
</body>


<script>
    let commandesData = [];
    let toutesLesReservations = [];
    let reservationId = null; // ← Important ! pas touché

    let reservationsJour = [];
    let tablesStatus = [];

    Promise.all([
        fetch('http://localhost/Projet_S4/api/get_reservations.php').then(res => res.json()),
        fetch('http://localhost/Projet_S4/api/get_tables.php').then(res => res.json())
    ]).then(([reservations, tables]) => {
        reservationsJour = reservations;
        tablesStatus = tables;

        // On crée un Set des ID des tables "Disponible"
        const tablesDisponibles = new Set(
            tables.filter(t => t.statut_table === "Disponible").map(t => t.ID_TABLES)
        );

        // On filtre les réservations qui concernent des tables disponibles
        const reservationsFiltrees = reservationsJour.filter(r => tablesDisponibles.has(parseInt(r.id_tables)));

        afficherReservationsDisponibles(reservationsFiltrees);
    });

    // Charger les commandes actives
    fetch('http://localhost/Projet_S4/api/get_commandes_actives.php')
        .then(res => res.json())
        .then(data => {
            commandesData = data;
        });

    // Charger toutes les réservations du jour
    fetch('http://localhost/Projet_S4/api/get_reservations.php')
        .then(res => res.json())
        .then(data => {
            toutesLesReservations = data;
        });

    // Sélection des boutons de table
    let boutons = document.querySelectorAll('.table-btn');

    boutons.forEach(function(bouton) {
        let statut = bouton.dataset.statut;
        let idTable = bouton.dataset.id;

        // Si la table est occupée
        if (statut === 'Occupee') {
            bouton.addEventListener('click', function() {
                let commandes = commandesData.filter(function(cmd) {
                    return cmd.ID_TABLES == idTable;
                });
                afficherModaleCommande(commandes, idTable);
            });
        }

        // Si la table est réservée
        if (statut === 'Reservee') {
            bouton.addEventListener('click', function() {
                const reservationsTable = toutesLesReservations.filter(r => r.id_tables == idTable);
                afficherModaleReservee(reservationsTable, idTable);
            });
        }
    });

    function afficherModaleCommande(commandes, numeroTable) {
        let modal = document.getElementById('commandeModal');
        let details = document.getElementById('commandeDetails');
        let tableSpan = document.getElementById('tableNum');

        tableSpan.textContent = numeroTable;
        details.innerHTML = "";

        if (commandes.length > 0) {
            let html = "<ul>";
            let total = 0; // ← on initialise le total

            commandes.forEach(function(cmd) {
                html += "<li>" + cmd.NOM_PLAT + " - " + cmd.PRIX + "€</li>";
                total += parseFloat(cmd.PRIX); //  additionné chaque prix
            });

            html += "</ul>";

            html += "<div class='total-commande'>Total : " + total.toFixed(2) + "€</div>"; // ← on affiche le total

            details.innerHTML = html;
        } else {
            details.textContent = "Aucune commande trouvée pour cette table.";
        }

        modal.style.display = "flex";
    }


    function afficherModaleReservee(reservations, tableId) {
        const modal = document.getElementById('reserveeModal');
        const nomInput = document.getElementById('resNom');
        const telInput = document.getElementById('resTel');
        const dateInput = document.getElementById('resDate');
        const horaireInput = document.getElementById('resHoraire');
        const nbInput = document.getElementById('resNb');
        const autresContainer = document.getElementById('autresReservations');

        let current = 0;

        function remplirFormulaire(index) {
            const r = reservations[index];
            reservationId = r.id_reservation; // mise à jour de la variable globale
            nomInput.value = r.nom_client;
            telInput.value = r.TELEPHONE;
            dateInput.value = r.date_reservation;
            horaireInput.value = r.horaire;
            nbInput.value = r.NOMBRE_PERSONNE;
        }

        if (reservations.length > 0) {
            remplirFormulaire(current);

            autresContainer.innerHTML = '';
            reservations.forEach((res, index) => {
                const btn = document.createElement('button');
                btn.textContent = `Nom : ${res.nom_client}\nHoraire : ${res.horaire}`;
                btn.className = "other-reservation-card"; // NOTRE CLASSE CSS PROPRE
                btn.onclick = () => {
                    current = index;
                    remplirFormulaire(current);
                };
                autresContainer.appendChild(btn);
            });

            modal.style.display = "flex";
        } else {
            alert("Aucune réservation trouvée pour cette table.");
        }
    }


    // Bouton “OK” : mise à jour réservation
    document.getElementById('reservationForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append('action', 'update');
        formData.append('id', reservationId);
        formData.append('nom', document.getElementById('resNom').value);
        formData.append('tel', document.getElementById('resTel').value);
        formData.append('date', document.getElementById('resDate').value);
        formData.append('horaire', document.getElementById('resHoraire').value);
        formData.append('nb', document.getElementById('resNb').value);

        fetch('http://localhost/Projet_S4/controllers/traitement_reservation.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                console.log("Réponse serveur :", data);
                if (data.success) {
                    alert("Réservation mise à jour !");
                    location.reload();
                } else {
                    alert("Erreur lors de la mise à jour.");
                }
            })
            .catch(err => {
                console.error("Erreur JSON :", err);
                alert("Une erreur est survenue.");
            });
    });

    // Bouton "Supprimer"
    document.getElementById('supprimerBtn').addEventListener('click', function() {
        if (confirm("Tu es sûr de vouloir supprimer cette réservation ?")) {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', reservationId);

            fetch('http://localhost/Projet_S4/controllers/traitement_reservation.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Réservation supprimée.");
                        location.reload();
                    } else {
                        alert("Erreur lors de la suppression.");
                    }
                })
                .catch(err => {
                    console.error("Erreur JSON :", err);
                    alert("Une erreur est survenue.");
                });
        }
    });

    // Bouton "Payer"
    document.getElementById('payerBtn').addEventListener('click', function () {
        const tableId = document.getElementById('tableNum').textContent;

        const formData = new FormData();
        formData.append('id_table', tableId);

        fetch('http://localhost/Projet_S4/controllers/traitement_commande_payee.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Commande payée !");
                    location.reload();
                } else {
                    alert("Erreur : " + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert("Erreur lors du traitement.");
            });
    });


    // Fermeture des modales
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('commandeModal').style.display = 'none';
    });

    document.getElementById('closeReserveeModal').addEventListener('click', function() {
        document.getElementById('reserveeModal').style.display = 'none';
    });

    window.addEventListener('click', function(e) {
        let commandeModal = document.getElementById('commandeModal');
        let reserveeModal = document.getElementById('reserveeModal');

        if (e.target === commandeModal) {
            commandeModal.style.display = 'none';
        }
        if (e.target === reserveeModal) {
            reserveeModal.style.display = 'none';
        }
    });
</script>





