<?php

require_once '../class/BoissonTicket.php';

$boissons = BoissonTicket::getBoissonsParTicket();

header('Content-Type: application/json');
echo json_encode($boissons);
