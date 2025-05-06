<?php

/*
 *
 *  OBSELETE, trop chiant a faire.
require_once '../class/Database.php';
require_once '../class/Reservation.php';

header('Content-Type: application/json');

if (isset($_GET['id_table'])) {
    $id = intval($_GET['id_table']);

    try {
        $reservations = Reservation::getReservationsParTable($id);
        echo json_encode($reservations);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID table manquant']);
}*/
