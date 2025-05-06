<?php
require_once '../class/Database.php';
require_once '../class/Tables.php';
require_once '../class/Commande.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_table'])) {
    $idTable = intval($_POST['id_table']);

    $tableOk = Tables::setTableANettoyer($idTable);
    $commandeOk = Commande::setCommandePayee($idTable);

    if ($tableOk && $commandeOk) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Problème lors de la mise à jour.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Requête invalide.'
    ]);
}
