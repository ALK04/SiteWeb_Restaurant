<?php
require_once '../class/Employes.php';

$id = $_POST['ID_SERVEUR'] ?? null;
$nom = $_POST['NOM_COMPLET'] ?? null;
$secteurs = $_POST['SECTEURS'] ?? null;

if ($id && $nom && $secteurs) {
    $result = Employes::updateEmploye($id, $nom, $secteurs);

    if ($result) {
        echo json_encode(["success" => true, "message" => "Employé mis à jour avec succès"]);
    } else {
        echo json_encode(["success" => false, "message" => "Échec de la mise à jour"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Données incomplètes"]);
}
?>
