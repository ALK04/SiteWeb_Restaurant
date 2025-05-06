<?php
require_once '../class/Plats.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $plat = Plats::getPlatById($id);

    if ($plat) {
        echo json_encode($plat->toArray());
    }
}
