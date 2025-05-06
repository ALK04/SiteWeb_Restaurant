<!--nav.inc.php-->
<link rel="stylesheet" href="css/reservation.css">

<div class="navbar">
    <a href="index.php">Accueil</a>
</div>

<div class="side-navbar">
    <a href="index.php?page=barmanAccueil">Gestion des tables</a>
    <a href="#" onclick="openModal()">Ajouter une réservation</a>
    <a href="index.php?page=boisson" class="nav-link <?php if (!empty($hasBoissons)) echo 'clignotant'; ?>">Boisson</a>
    <a href="index.php?page=parametre" class="settings-link">⚙️</a>
</div>

