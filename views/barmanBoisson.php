<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Boissons</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/nav.css?v=4">
    <link rel="stylesheet" href="css/boissons.css?v=1">
    <link rel="stylesheet" href="css/Modale_Barman.css?v=4">
</head>

<body>

<div class="boisson-container">
    <?php foreach ($boisson as $ticketId => $items): ?>
        <div class="boisson-carte">
            <div class="boisson-header">
                Table n°<?= htmlspecialchars($items['id_table']) ?>
            </div>

            <div class="boisson-contenu">
                <?php foreach ($items as $key => $plat): ?>
                    <?php if ($key === 'id_table') continue; ?>
                    <p>x1 <?= htmlspecialchars($plat['NOM_PLAT']) ?></p>
                <?php endforeach; ?>
            </div>

            <div class="boisson-footer">
                <form method="post" action="controllers/terminer_boisson.php">
                    <input type="hidden" name="id_table" value="<?= htmlspecialchars($items['id_table'])?>">
                    <input type="hidden" name="ticket_id" value="<?= htmlspecialchars($ticketId) ?>">
                    <button type="submit">Terminé</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
