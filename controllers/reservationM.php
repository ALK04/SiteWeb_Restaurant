<?php

require_once '../class/Reservation.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = Reservation::ajouterReservation(
        $_POST['nom_client'],
        $_POST['telephone'],
        $_POST['date'],
        $_POST['horaire'],
        $_POST['nombre_personne'],
        $_POST['id_table']
    );

    if ($success) {
        header('Location: ../index.php?page=barmanAccueil&success=1');
    } else {
        header('Location: ../index.php?page=barmanAccueil&error=1');
    }
    exit();
}