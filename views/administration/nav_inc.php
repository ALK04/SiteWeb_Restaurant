<link rel="stylesheet" href="css/admin_nav_inc.css">
<nav class="navbar">
    <a><button onclick="history.back()" class="back-btn">←</button></a>
    <div class="nav-buttons">
        <a href="?page=parametre&type=Entree"><button class="<?= ($_GET['type'] ?? 'Plats') === 'Entree' ? 'active' : '' ?>">ENTRÉES</button></a>
        <a href="?page=parametre&type=Plat"><button class="<?= ($_GET['type'] ?? 'Plats') === 'Plat' ? 'active' : '' ?>">PLATS</button></a>
        <a href="?page=parametre&type=Dessert"><button class="<?= ($_GET['type'] ?? 'Plats') === 'Dessert' ? 'active' : '' ?>">DESSERTS</button></a>
        <a href="?page=parametre&type=Boisson"><button class="<?= ($_GET['type'] ?? 'Plats') === 'Boisson' ? 'active' : '' ?>">BOISSONS</button></a>
        <a href="?page=parametre&type=Employes"><button class="<?= ($_GET['type'] ?? 'Plats') === 'Employes' ? 'active' : '' ?>">EMPLOYÉS</button></a>
    </div>
</nav>
