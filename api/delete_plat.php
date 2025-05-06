<?php

require_once '../class/Plats.php';
header('Content-Type: application/json');

$id = $_GET['id'];


if (Plats::updateSurLaCarte($id)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Échec de la suppression"]);
}
