<?php
require_once 'Database.php';

class Reservation {
    public static function ajouterReservation($nom_client, $telephone, $date, $horaire, $nb_personnes, $id_table) {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "INSERT INTO reservation (nom_client, telephone, date_reservation, horaire, nombre_personne, id_tables)
                VALUES (:nom_client, :telephone, :date, :horaire, :nombre_personne, :id_tables)";
        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            ':nom_client' => $nom_client,
            ':telephone' => $telephone,
            ':date' => $date,
            ':horaire' => $horaire,
            ':nombre_personne' => $nb_personnes,
            ':id_tables' => $id_table
        ]);
    }

    public static function getReservationsDuJour() {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "SELECT ID_RESERVATION, DATE_RESERVATION, HORAIRE, ID_TABLES
                FROM reservation
                WHERE DATE(DATE_RESERVATION) = CURDATE()";

        $stmt = $db->requete($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getReservationsReserveesDuJour()
    {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "
        SELECT 
            r.id_reservation,
            r.nom_client,
            r.TELEPHONE,
            r.date_reservation,
            r.horaire,
            r.NOMBRE_PERSONNE,
            r.id_tables,
            t.id_secteur
        FROM Reservation r
        JOIN Tables t ON r.id_tables = t.id_tables
        WHERE r.date_reservation = CURRENT_DATE
          AND r.horaire >= CURRENT_TIME

    ";

        $stmt = $db->requete($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateReservation($id, $nom, $tel, $date, $horaire, $personnes) {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "UPDATE reservation 
            SET nom_client = :nom, 
                telephone = :tel, 
                date_reservation = :date, 
                horaire = :horaire, 
                nombre_personne = :personnes 
            WHERE id_reservation = :id";

        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':tel' => $tel,
            ':date' => $date,
            ':horaire' => $horaire,
            ':personnes' => $personnes,
            ':id' => $id
        ]);
    }


    public static function deleteReservation($id) {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "DELETE FROM reservation WHERE id_reservation = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public static function updateStatutTable($id_table, $nouveau_statut) {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "UPDATE Tables SET ID_STATUT_TABLE = :statut WHERE ID_TABLES = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':statut' => $nouveau_statut,
            ':id' => $id_table
        ]);
    }

    public static function getTableIdFromReservation($id_reservation) {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "SELECT id_tables FROM reservation WHERE id_reservation = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id_reservation]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['id_tables'] : null;
    }

    public static function deleteReservationEtLibereTable($id_reservation) {
        $id_table = self::getTableIdFromReservation($id_reservation);
        $success = self::deleteReservation($id_reservation);

        if ($success && $id_table) {
            self::updateStatutTable($id_table, 1);
        }

        return $success;
    }


    /*    fonction pas utilisé en dessous , car j'ai une autre solution */
/*    public static function getReservationsParTable($id_table)
    {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "
        SELECT 
            r.id_reservation,
            r.nom_client,
            r.telephone,
            r.date_reservation,
            r.horaire,
            r.nombre_personne,
            r.id_tables,
            t.id_secteur
        FROM Reservation r
        JOIN Tables t ON r.id_tables = t.id_tables
        WHERE r.date_reservation = CURRENT_DATE
          AND r.horaire >= CURRENT_TIME
          AND t.ID_STATUT_TABLE = 3
          AND r.id_tables = :id_table
        ORDER BY r.horaire ASC
    ";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_table', $id_table, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }*/


}
