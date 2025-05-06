<?php
require_once '../class/Commande.php';

header('Content-Type: application/json');

$commandes = Commande::getToutesCommandesActives();

echo json_encode($commandes);
