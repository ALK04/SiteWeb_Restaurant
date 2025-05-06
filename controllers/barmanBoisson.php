<?php
require_once('views/layouts/nav.inc.php');
include('views/modales/reservationModal.php');

$response = file_get_contents("http://localhost/Projet_S4/api/boissons_ticket_api.php");
$boisson = json_decode($response, true);

/*if (isset($_GET['success'])) {
    echo "<p style='color: green;'>Ticket terminé avec succès !</p>";
}
if (isset($_GET['error'])) {
    echo "<p style='color: red;'>Erreur lors de la mise à jour du ticket.</p>";
}*/

require_once('views/barmanBoisson.php');
