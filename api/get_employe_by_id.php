<?php
require_once '../class/Employes.php';
$id = $_GET['id'] ?? null;
if ($id) {
    $employe = Employes::getEmployeById($id);

    if ($employe) {
        echo json_encode($employe->toArray());
    }
}