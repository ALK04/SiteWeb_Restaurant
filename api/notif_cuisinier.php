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

function sendNotificationToAndroidCuisine($deviceToken, $table_id, $accessToken) {

    $message = array(
        'message' => array(
            'token' => $deviceToken,
            'notification' => array(
                'title' => 'Plats prêts',
                'body'  => 'Les plats pour la table ' . $table_id . ' sont prêts.',
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