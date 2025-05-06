<?php
include ('views/layouts/nav_cuisinier.php');

$response = file_get_contents("http://localhost/Projet_S4/api/cuisinier_ticket.php");
$tickets = json_decode($response, true);

include ('views/cuisinier/cuisinierAccueil.php');