<?php
require_once '../class/Employes.php';
header('Content-Type: application/json');

$nom = $_POST['NOM_COMPLET'] ?? null;
$secteurs = $_POST['SECTEURS'] ?? null;

if ($nom && $secteurs) {
    $success = Employes::createEmploye($nom, $secteurs);

    if ($success) {
        echo json_encode(["success" => true, "message" => "Employé ajouté avec succès"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'ajout de l'employé"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Données incomplètes"]);
}