<?php

require_once '../class/Database.php';
require_once '../class/Reservation.php';

header('Content-Type: application/json');

try {
    $reservations = Reservation::getReservationsReserveesDuJour();
    echo json_encode($reservations);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
}
