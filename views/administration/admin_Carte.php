<DOCTYPE html>
<html>
<head>
    <title>Carte</title>
</head>
<body>
<link rel="stylesheet" href="css/admin_carte.css">
<?php foreach ($items as $item): ?>
    <div class="dish-item">
        <?php if (($type ?? '') === 'Employes'): ?>
            <span><?= htmlspecialchars($item['NOM_COMPLET']) ?></span>
            <a href="?page=modifier_employe&id=<?= $item['ID_SERVEUR'] ?>"><button class="edit">Modifier</button></a>
            <button class="delete" data-id="<?= $item['ID_SERVEUR'] ?>" data-type="employe">Supprimer</button>
        <?php else: ?>
            <span>
                <?= htmlspecialchars($item['NOM_PLAT']) ?>
                - <?= number_format($item['PRIX'], 2, ',', ' ') ?> €
            </span>
            <a href="?page=modifier_carte&id=<?= $item['ID_PLAT'] ?>"><button class="edit">Modifier</button></a>
            <button class="delete" data-id="<?= $item['ID_PLAT'] ?>" data-type="plat">Supprimer</button>
        <?php endif; ?>
    </div>
<?php endforeach; ?>


<a href="?page=<?= $type === 'Employes' ? 'modifier_employe' : 'modifier_carte' ?>">

<button class="add">Ajouter</button>
</a>


<div id="confirmModal" class="modal">
    <div class="modal-content">
        <h2>Êtes-vous sûr de vouloir supprimer cet élément ?</h2>
        <button id="confirmYes">Oui</button>
        <button id="confirmNo">Non</button>
    </div>
</div>

<script>
    document.querySelectorAll('.delete').forEach(button => {
        button.addEventListener('click', (e) => {
            const itemId = e.target.dataset.id;
            const type = e.target.dataset.type; // 'plat' ou 'employe'
            document.getElementById('confirmModal').style.display = 'flex';

            document.getElementById('confirmYes').onclick = async function() {
                const url = type === 'plat'
                    ? `http://localhost/Projet_S4/api/delete_plat.php?id=${itemId}`
                    : `http://localhost/Projet_S4/api/delete_employe.php?id=${itemId}`;

                const response = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                });

                const result = await response.json();
                if (result.success) {
                    alert(`${type === 'plat' ? 'Plat' : 'Employé'} supprimé avec succès !`);
                    window.location.reload();
                } else {
                    alert('Erreur : ' + result.message);
                }
                document.getElementById('confirmModal').style.display = 'none';
            };

            document.getElementById('confirmNo').onclick = function() {
                document.getElementById('confirmModal').style.display = 'none';
            };
        });
    });
</script>
