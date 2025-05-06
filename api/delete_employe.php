<?php
require_once '../class/Employes.php';
header('Content-Type: application/json');

$id = $_GET['id'];

if (Employes::deleteEmployeById($id)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Échec de la suppression"]);
}
