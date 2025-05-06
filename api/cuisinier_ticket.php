<?php
require_once '../class/CuisinierTicket.php';

$plats = CuisinierTicket::getTicketExceptBoisson();

header('Content-Type: application/json');
echo json_encode($plats);