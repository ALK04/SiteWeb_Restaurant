<?php
$id = $_GET['id'] ?? null;

$modeAjout = ($id === null);

if (!$modeAjout) {
    $response = file_get_contents("http://localhost/Projet_S4/api/get_plat_by_id.php?id=$id");
    $plat = json_decode($response, true);

    if (!$plat) {
        die("Erreur de récupération du plat.");
    }
} else {

    $plat = [
        'ID_PLAT' => '',
        'NOM_PLAT' => '',
        'PRIX' => '',
        'TYPE_PLAT' => ''
    ];
}
include ("views/administration/nav_inc.php");
include("views/administration/admin_ModifierCarte.php");
