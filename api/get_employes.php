<?php
require_once '../class/Employes.php';
header('Content-Type: application/json');

$employes = Employes::getAllEmployes();

$result = array_map(function($p) {
    return $p->toArray();
}, $employes);

echo json_encode($result);
