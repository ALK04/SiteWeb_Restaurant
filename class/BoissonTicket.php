<?php

require_once 'Database.php';
require_once 'Plats.php';

class BoissonTicket
{
    public static function getBoissonsParTicket()
    {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "SELECT TICKET.ID_TICKET,COMMANDE.ID_TABLES AS ID_TABLE, PLAT.ID_PLAT, PLAT.NOM_PLAT, PLAT.PRIX, PLAT.CONTIENT_SAUCE,PLAT.CONTIENT_CUISSON, TYPE_PLATS.TYPE_PLAT
                FROM TICKET
                JOIN COMMANDE ON TICKET.ID_COMMANDE = COMMANDE.ID_COMMANDE
                JOIN ITEM ON TICKET.ID_TICKET = ITEM.ID_TICKET
                JOIN PLAT ON ITEM.ID_PLAT = PLAT.ID_PLAT
                JOIN TYPE_PLATS ON PLAT.ID_TYPE_PLATS = TYPE_PLATS.ID_TYPE_PLATS
                WHERE TYPE_PLATS.ID_TYPE_PLATS = 4  
                  AND TICKET.TICKET_EN_COURS = TRUE
                ORDER BY TICKET.ID_TICKET";

        $stmt = $db->requete($sql);

        $result = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ticketId = $row['ID_TICKET'];
            $idTable = $row['ID_TABLE'];
            $plat = new Plats($row['ID_PLAT'], $row['NOM_PLAT'], true, $row['PRIX'], $row['TYPE_PLAT'],$row['CONTIENT_SAUCE'] ,$row['CONTIENT_CUISSON'] );

            if (!isset($result[$ticketId])) {
                $result[$ticketId] = [
                    'id_table' => $idTable,
                ];
            }

            $result[$ticketId][] = $plat->toArray();
        }

        return $result;
    }

    public static function terminerTicket($id_ticket) {
        $db = new Database();
        $conn = $db->getConnection();
        $sql = "UPDATE Ticket SET ticket_en_cours = FALSE WHERE id_ticket = :id_ticket";
        $stmt = $db->requete($sql, ['id_ticket' => $id_ticket]);

        return $stmt->rowCount() > 0;
    }

}
