<?php

require_once 'Database.php';
require_once 'Statut_Table.php';

class Tables
{
    private $ID_Tables;
    private $statut_table;
    private $ID_Secteur;

    public function __construct($ID_Tables, $statut_table, $ID_Secteur)
    {
        $this->ID_Tables = $ID_Tables;
        $this->statut_table = new Statut_Table($statut_table);
        $this->ID_Secteur = $ID_Secteur;
    }

    public function getID_Table() { return $this->ID_Tables; }

    public function getStatut_table() { return $this->statut_table->getStatut_Table(); }

    public function toArray()
    {
        return [
            'ID_TABLES' => $this->getID_Table(),
            'statut_table' => $this->getStatut_table()
        ];
    }

    public static function getAllTables()
    {
        $db = new Database();
        $conn = $db->getConnection();
        $sql = "SELECT t.ID_TABLES, s.statut_table, t.id_secteur
        FROM tables t
        JOIN statut_Table s ON t.ID_STATUT_TABLE = s.ID_STATUT_TABLE
        ORDER BY t.ID_TABLES ASC";

        $stmt = $db->requete($sql);

        $tables = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tables[] = new Tables($row['ID_TABLES'], $row['statut_table'], $row['id_secteur']);
        }

        return $tables;
    }

    public static function setTablesReservees($listeIdTables) {
        if (empty($listeIdTables)) return;

        $db = new Database();
        $conn = $db->getConnection();

        // On transformation d'un tableau [1, 4, 5] en "(1,4,5)"
        $placeholders = implode(',', array_map('intval', $listeIdTables));

        $sql = "UPDATE tables 
            SET ID_STATUT_TABLE = (
                SELECT ID_STATUT_TABLE FROM statut_table WHERE statut_table = 'Reservee'
            )
            WHERE ID_TABLES IN ($placeholders)";

        $conn->exec($sql);
    }

    public static function setTableANettoyer($idTable)
    {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "
        UPDATE tables 
        SET ID_STATUT_TABLE = (
            SELECT ID_STATUT_TABLE FROM statut_table WHERE statut_table = 'A nettoyer'
        )
        WHERE ID_TABLES = :idTable
    ";

        $stmt = $conn->prepare($sql);
        return $stmt->execute(['idTable' => $idTable]);
    }

    public static function getStatutsActuels() {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "SELECT ID_TABLES, statut_table 
            FROM tables 
            JOIN statut_table ON tables.ID_STATUT_TABLE = statut_table.ID_STATUT_TABLE";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];

        foreach ($rows as $row) {
            $result[$row['ID_TABLES']] = $row['statut_table'];
        }

        return $result;
    }

    public static function setTableDisponible($idTable)
    {
        if (!$idTable) return;

        $db = new Database();
        $conn = $db->getConnection();

        $sql = "UPDATE tables 
            SET ID_STATUT_TABLE = (
                SELECT ID_STATUT_TABLE FROM statut_table WHERE statut_table = 'Disponible'
            )
            WHERE ID_TABLES = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $idTable, PDO::PARAM_INT);
        $stmt->execute();
    }
}