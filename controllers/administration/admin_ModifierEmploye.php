<?php
$id = $_GET['id'] ?? null;
$modeAjout = ($id === null);
$listeSecteurs = [
    1 => 'Secteur 1',
    2 => 'Secteur 2',
    3 => 'Secteur 3',
    4 => 'Secteur 4'
];

if (!$modeAjout) {
    $response = file_get_contents("http://localhost/Projet_S4/api/get_employe_by_id.php?id=$id");
    $data = json_decode($response, true);
    $nomComplet = $data['NOM_COMPLET'];
    $secteursAttribues = $data['ID_SECTEUR'];
    if (!$data) {
        die("Erreur de récupération de l'employé.");
    }
} else {
    $nomComplet = '';
    $secteursAttribues = [];
}





include ("views/administration/nav_inc.php");
include ('views/administration/admin_ModifierEmploye.php');