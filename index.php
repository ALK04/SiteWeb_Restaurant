<!-- index.php -->
<!DOCTYPE html>
<html lang="fr">
<body>
<?php

$page = isset($_GET['page']) ? $_GET['page'] : 'Accueil';

switch ($page) {
    case 'Accueil':
        require_once('controllers/Accueil.php');
        break;
    case 'barmanAccueil':
        require_once('controllers/barmanAccueil.php');
        break;
    case 'Cuisinier':
        require_once('controllers/cuisinierAccueil.php');
        break;
    case 'boisson':
        require_once('controllers/barmanBoisson.php');
        break;
    case 'parametre':
        require_once('controllers/administration/admin_Carte.php');
        break;
    case 'modifier_carte':
        require_once ('controllers/administration/admin_ModifierCarte.php');
        break;
    case 'modifier_employe':
        require_once ('controllers/administration/admin_ModifierEmploye.php');
        break;
    default:
        echo "<h1>ERROR 404</h1>";
        break;
}
?>
</body>
</html>
