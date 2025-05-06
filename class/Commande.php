<?php
require_once 'Database.php';

class Commande
{
    public static function getToutesCommandesActives()
    {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "
        SELECT 
            commande.ID_COMMANDE,
            commande.DATE_COMMANDE,
            commande.COMMANDE_PAYEE,
            commande.ID_TABLES,
            tables.ID_SECTEUR,
            item.ID_ITEM,
            plat.NOM_PLAT,
            plat.PRIX
        FROM commande
        JOIN ticket ON commande.ID_COMMANDE = ticket.ID_COMMANDE
        JOIN item ON ticket.ID_TICKET = item.ID_TICKET
        JOIN plat ON item.ID_PLAT = plat.ID_PLAT
        JOIN tables ON commande.ID_TABLES = tables.ID_TABLES
        WHERE commande.COMMANDE_PAYEE = 0
        ORDER BY commande.ID_TABLES, commande.ID_COMMANDE
    ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function setCommandePayee($idTable)
    {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "
        UPDATE commande 
        SET COMMANDE_PAYEE = 1
        WHERE ID_TABLES = :idTable AND COMMANDE_PAYEE = 0
    ";

        $stmt = $conn->prepare($sql);
        return $stmt->execute(['idTable' => $idTable]);
    }



}
