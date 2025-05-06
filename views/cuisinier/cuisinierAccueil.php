<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Cuisinier</title>
	<link rel="stylesheet" href="css/cuisinier.css">
</head>
<div class="boisson-container">
    <?php foreach ($tickets as $ticketId => $items): ?>
        <div class="boisson-carte">
            <div class="boisson-header">
                Table n°<?= htmlspecialchars($items['id_table']) ?>
            </div>

            <div class="boisson-contenu">
                <?php foreach ($items['plats'] as $plat): ?>
                    <p>x1 <?= htmlspecialchars($plat['nom_plat']) ?></p>

                    <?php if (!empty($plat['cuisson'])): ?>
                        <p>- Cuisson : <?= htmlspecialchars($plat['cuisson']) ?></p>
                    <?php endif; ?>

                    <?php if (!empty($plat['sauce'])): ?>
                        <p>- Sauce : <?= htmlspecialchars($plat['sauce']) ?></p>
                    <?php endif; ?>

                    <?php if (!empty($plat['commentaire'])): ?>
                        <p>- Commentaire : <?= htmlspecialchars($plat['commentaire']) ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="boisson-footer">
                <form method="post" action="controllers/terminer_ticket_cuisine.php">
                    <input type="hidden" name="id_table" value="<?= htmlspecialchars($items['id_table']) ?>">
                    <input type="hidden" name="ticket_id" value="<?= htmlspecialchars($ticketId) ?>">
                    <button type="submit">Terminé</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
