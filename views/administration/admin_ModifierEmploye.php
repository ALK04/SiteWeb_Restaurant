<!DOCTYPE html>
<html>
<head>
	<title><?= $modeAjout ? 'Ajouter' : 'Modifier' ?> un employé</title>
	<link rel="stylesheet" href="css/admin_ModifierCarte.css">
</head>
<body>

<form id="updateEmployeForm">
	<input type="hidden" name="ID_SERVEUR" value="<?= htmlspecialchars($id ?? '') ?>">

	<div class="element">
		<label>Nom complet</label>
		<input type="text" name="NOM_COMPLET" value="<?= htmlspecialchars($nomComplet) ?>">
	</div>

	<div class="element">
		<label>Secteurs attribués :</label>
        <?php foreach ($listeSecteurs as $idSecteur => $nomSecteur): ?>
			<div>
				<input type="checkbox"
					   name="SECTEURS[]"
					   value="<?= $idSecteur ?>"
                    <?= in_array($idSecteur, $secteursAttribues) ? 'checked' : '' ?>>
                <?= htmlspecialchars($nomSecteur) ?>
			</div>
        <?php endforeach; ?>
	</div>

	<button type="submit"><?= $modeAjout ? 'Ajouter' : 'Enregistrer' ?></button>
</form>

<script>
    const modeAjout = <?= $modeAjout ? 'true' : 'false' ?>;

    document.getElementById('updateEmployeForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        const apiUrl = modeAjout
            ? 'http://localhost/Projet_S4/api/create_employe.php'
            : 'http://localhost/Projet_S4/api/update_employe.php';

        const response = await fetch(apiUrl, {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        if (result.success) {
            alert('Employé ' + (modeAjout ? 'ajouté' : 'mis à jour') + ' !');
            window.location.href = '?page=parametre';
        } else {
            alert('Erreur : ' + result.message);
        }
    });
</script>

</body>
</html>
