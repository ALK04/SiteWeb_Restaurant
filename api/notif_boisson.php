<?php
require '../vendor/autoload.php';

use Google\Client;

function getAccessToken() {
    // Crée une instance du client Google API
    $client = new Client();

    // Charge la clé du compte de service
    $client->setAuthConfig('../s4-ajigroup-firebase-adminsdk-fbsvc-a1d70d1c5d.json');

    // Ajoute la portée nécessaire pour Firebase Cloud Messaging
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

    // Récupère le jeton d'accès
    $accessToken = $client->fetchAccessTokenWithAssertion();

    return $accessToken['access_token'];
}
function sendNotificationToAndroidBoisson($deviceToken, $table_id, $accessToken) {

    $message = array(
        'message' => array(
            'token' => $deviceToken,
            'notification' => array(
                'title' => 'Boisson prête',
                'body'  => 'Les boissons pour la table ' . $table_id . ' sont prêtes.',
            ),
        ),
    );

    $headers = array(
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/s4-ajigroup/messages:send');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
    var_dump($message);
    $response = curl_exec($ch);
    var_dump($response);

    if (curl_errno($ch)) {
        echo 'Erreur CURL : ' . curl_error($ch);
    }

    curl_close($ch);

    return $response;
}

// DEBUG
//$deviceToken = 'eQ1Rhr5pS86USjUe5cT0JO:APA91bHKGXtQa0n4D6K4uJ37vcOB_PSaQShPwZgKMzwygRhRA74w3Owl932Uvz2kFh863si1KDCPf4kqhlOJOT1pptnieaMuCPdxE_LSPJEKgPy64aALbMs'; // OU récupéré dynamiquement
//$ticket_id = 3;
//$accessToken = getAccessToken();
//sendNotificationToAndroid($deviceToken, $ticket_id, $accessToken);
