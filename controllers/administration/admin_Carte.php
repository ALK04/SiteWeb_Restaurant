<?php

$type = $_GET['type'] ?? 'Entree';

if ($type=="Employes") {
    $response = file_get_contents("http://localhost/Projet_S4/api/get_employes.php");
} else {
    $response = file_get_contents("http://localhost/Projet_S4/api/get_menu.php?type=" . urlencode($type));
}

if ($response === false) {
    die("Erreur lors de l'appel API.");
}



$items = json_decode($response, true);
include ("views/administration/nav_inc.php");
include("views/administration/admin_Carte.php");