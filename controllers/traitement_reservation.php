<?php


header('Content-Type: application/json'); // ← Dis au navigateur que tu retournes du JSON
error_reporting(E_ALL); // ← Active tous les messages d'erreur
ini_set('display_errors', 1); // ← Affiche les erreurs (utile pour le dev)

require_once '../class/Reservation.php';

$response = ['success' => false]; // Valeur par défaut

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'update') {
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $tel = $_POST['tel'];
        $date = $_POST['date'];
        $horaire = $_POST['horaire'];
        $nb = $_POST['nb'];

        $success = Reservation::updateReservation($id, $nom, $tel, $date, $horaire, $nb);
        $response['success'] = $success;
    }

/*    if ($action === 'delete') {
        $id = $_POST['id'];
        $success = Reservation::deleteReservation($id);
        $response['success'] = $success;
    }*/

/*    if ($_POST['action'] === 'delete') {
        $id = $_POST['id'];

        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT id_tables FROM reservation WHERE id_reservation = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_table = $result ? $result['id_tables'] : null;

        $success = Reservation::deleteReservation($id);

        if ($success && $id_table) {
            Reservation::updateStatutTable($id_table, 1);
        }

        echo json_encode(['success' => $success]);
        exit;
    }*/

    if ($_POST['action'] === 'delete') {
        $success = Reservation::deleteReservationEtLibereTable($_POST['id']);
        echo json_encode(['success' => $success]);
        exit;
    }
}

echo json_encode($response);

