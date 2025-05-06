<!--controllers/barmanAccueil.php-->

<?php

require_once 'class/Database.php';
require_once 'class/Tables.php';
require_once 'class/Reservation.php';



$reservations = Reservation::getReservationsDuJour();

$ids = array_map(function($r) {
    return $r['ID_TABLES'];
}, $reservations);


// 1. On récupère les statuts actuels des tables via ta méthode ou API
$statutsActuels = Tables::getStatutsActuels();

$idsTablesAChanger = [];

foreach ($ids as $idTable) {
    if (isset($statutsActuels[$idTable]) && $statutsActuels[$idTable] === 'Disponible') {
        $idsTablesAChanger[] = $idTable;
    }
}

// 2. On ne met à jour que les tables vraiment disponibles
if (!empty($idsTablesAChanger)) {
    Tables::setTablesReservees($idsTablesAChanger);
}

$responseBoissons = file_get_contents("http://localhost/Projet_S4/api/boissons_ticket_api.php");
$boissons = json_decode($responseBoissons, true);

// Boisson a preparer ?
$hasBoissons = !empty($boissons);

include('views/layouts/nav.inc.php');
include('views/modales/reservationModal.php');
include('views/modales/commandeModal.php');

$response = file_get_contents("http://localhost/Projet_S4/api/get_tables.php");
$tables = json_decode($response, true);

$zones = [
    "Secteur 1" => range(1, 5),
    "Secteur 2" => range(6, 10),
    "Secteur 3" => range(11, 15),
    "Secteur 4" => range(16, 20),
];


include('views/barmanAccueil.php');

