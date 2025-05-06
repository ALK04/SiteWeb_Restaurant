<!DOCTYPE html>
<html>
<head>
    <title><?= $modeAjout ? 'Ajouter' : 'Modifier' ?> un plat</title>
</head>
<link rel="stylesheet" href="css/admin_modifierCarte.css">
<body>

<form id="updateForm">
    <input type="hidden" name="ID_PLAT" value="<?= htmlspecialchars($plat['ID_PLAT']) ?>">

    <div class="element">
        <label>Nom du plat</label>
        <input type="text" name="NOM_PLAT" value="<?= htmlspecialchars($plat['NOM_PLAT']) ?>">
    </div>

    <div class="element">
        <label>Prix</label>
        <input type="number" step="0.01" name="PRIX" value="<?= htmlspecialchars($plat['PRIX']) ?>">
    </div>

    <div class="element">
        <label>Type</label>
        <select name="TYPE_PLAT">
            <option value="Entree" <?= $plat['TYPE_PLAT'] === 'Entree' ? 'selected' : '' ?>>Entrée</option>
            <option value="Plat" <?= $plat['TYPE_PLAT'] === 'Plat' ? 'selected' : '' ?>>Plat</option>
            <option value="Dessert" <?= $plat['TYPE_PLAT'] === 'Dessert' ? 'selected' : '' ?>>Dessert</option>
            <option value="Boisson" <?= $plat['TYPE_PLAT'] === 'Boisson' ? 'selected' : '' ?>>Boisson</option>
        </select>
    </div>


    <div class="element">
        <label>
            <input type="checkbox" name="CONTIENT_SAUCE" value="1" <?= !empty($plat['CONTIENT_SAUCE']) ? 'checked' : '' ?>>
            Contient une sauce
        </label>
    </div>

    <div class="element">
        <label>
            <input type="checkbox" name="CONTIENT_CUISSON" value="1" <?= !empty($plat['CONTIENT_CUISSON']) ? 'checked' : '' ?>>
            Nécessite une cuisson
        </label>
    </div>

    <button type="submit"><?= $modeAjout ? 'Ajouter' : 'Enregistrer' ?></button>
</form>

<script>
        const modeAjout = <?= $modeAjout ? 'true' : 'false' ?>;

        document.getElementById('updateForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        if (!formData.has('CONTIENT_SAUCE')) {
        formData.append('CONTIENT_SAUCE', 0);
    }
        if (!formData.has('CONTIENT_CUISSON')) {
        formData.append('CONTIENT_CUISSON', 0);
    }

        const apiUrl = modeAjout
        ? 'http://localhost/Projet_S4/api/create_plat.php'
        : 'http://localhost/Projet_S4/api/update_plat.php';

        const response = await fetch(apiUrl, {
        method: 'POST',
        body: formData
    });

        const result = await response.json();
        if (result.success) {
        alert('Plat ' + (modeAjout ? 'ajouté' : 'mis à jour') + ' !');
        const typePlat = formData.get('TYPE_PLAT') || 'Plat';
        window.location.href = 'index.php?page=parametre&type=' + encodeURIComponent(typePlat);
    } else {
        alert('Erreur : ' + result.message);
    }
    });
</script>

</script>


</body>
</html>