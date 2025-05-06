<?php
require_once '../class/CuisinierTicket.php';
require_once '../api/notif_cuisinier.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ticket_id'])) {
    $ticket_id = intval($_POST['ticket_id']);
    $table_id = $_POST['id_table'];

    $result = CuisinierTicket::terminerTicket($ticket_id);

    if ($result) {
        $deviceToken = 'eQ1Rhr5pS86USjUe5cT0JO:APA91bHKGXtQa0n4D6K4uJ37vcOB_PSaQShPwZgKMzwygRhRA74w3Owl932Uvz2kFh863si1KDCPf4kqhlOJOT1pptnieaMuCPdxE_LSPJEKgPy64aALbMs'; // OU récupéré dynamiquement

        $accessToken = getAccessToken();

        sendNotificationToAndroidCuisine($deviceToken, $table_id, $accessToken);

        header("Location: ../index.php?page=Cuisinier");
    } else {
        header("Location: ../index.php?page=Cuisinier");
    }
    exit();
}
