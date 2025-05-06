<?php
require_once '../class/Database.php';

class Employes {
    private $id;
    private $prenom;
    private $id_secteur;

    /**
     * @param $id
     * @param $prenom
     */
    public function __construct($id, $prenom, $id_secteur)
    {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->id_secteur = $id_secteur;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
    /**
     * @return mixed
     */
    public function getIdSecteur()
    {
        return $this->id_secteur;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function toArray()
    {
        return [
            'ID_SERVEUR' => $this->getId(),
            'NOM_COMPLET' => $this->getPrenom(),
            'ID_SECTEUR' => $this->getIdSecteur()
        ];
    }

    public static function getAllEmployes() {
        $db = new Database();
        $query = "SELECT 
    serveur.ID_SERVEUR, 
    serveur.NOM_COMPLET, 
    GROUP_CONCAT(relier.ID_SECTEUR) AS SECTEURS
FROM serveur
JOIN relier ON relier.ID_SERVEUR = serveur.ID_SERVEUR
WHERE serveur.EMPLOYE_ACTIF = 1
GROUP BY serveur.ID_SERVEUR, serveur.NOM_COMPLET
";
        $conn = $db->getConnection();
        $stmt = $db->requete($query);

        $employes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $secteurs = explode(',', $row['SECTEURS']);
            $employes[] = new Employes($row['ID_SERVEUR'], $row['NOM_COMPLET'], $secteurs);
        }

        return $employes;
    }

    public static function deleteEmployeById($id)
    {
        $db = new Database();
        $query = "UPDATE serveur SET EMPLOYE_ACTIF = 0 WHERE ID_SERVEUR = '$id'";
        $conn = $db->getConnection();
        return $db->requete($query);
    }

    public static function getEmployeById($id)
    {
        $db = new Database();
        $query = "SELECT  
    serveur.ID_SERVEUR, 
    serveur.NOM_COMPLET, 
    GROUP_CONCAT(relier.ID_SECTEUR ORDER BY relier.ID_SECTEUR) AS SECTEURS
FROM serveur
JOIN relier ON relier.ID_SERVEUR = serveur.ID_SERVEUR
WHERE serveur.ID_SERVEUR = '$id'
  AND relier.TEMPS = (
      SELECT MAX(r2.TEMPS)
      FROM relier r2
      WHERE r2.ID_SERVEUR = serveur.ID_SERVEUR
  )
GROUP BY serveur.ID_SERVEUR, serveur.NOM_COMPLET;
";
        $conn = $db->getConnection();
        $stmt = $db->requete($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $secteurs = explode(',', $row['SECTEURS']);
        return new Employes($row['ID_SERVEUR'], $row['NOM_COMPLET'], $secteurs);
    }

    public static function updateEmploye($id, $nom, $secteurs)
    {
        $db = new Database();
        $conn = $db->getConnection();
        $query = "UPDATE serveur SET NOM_COMPLET = '$nom' WHERE ID_SERVEUR = '$id'";
        $db->requete($query);

        $stmt = $conn->prepare("INSERT INTO relier (ID_SECTEUR, ID_SERVEUR, TEMPS) VALUES (:id_secteur, :id_serveur, CURRENT_DATE)");
        foreach ($secteurs as $secteurId) {
            $stmt->execute([
                'id_secteur' => $secteurId,
                'id_serveur' => $id
            ]);
        }
    return true;
    }

    public static function createEmploye($nomComplet, $secteurs)
    {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $query = "INSERT INTO serveur (NOM_COMPLET, EMPLOYE_ACTIF) VALUES (:nom, 1)";
            $stmt = $conn->prepare($query);
            $stmt->execute(['nom' => $nomComplet]);

            $idServeur = $conn->lastInsertId();

            $queryRelier = "INSERT INTO relier (ID_SECTEUR, ID_SERVEUR, TEMPS) VALUES (:id_secteur, :id_serveur, CURRENT_DATE)";
            $stmtRelier = $conn->prepare($queryRelier);

            foreach ($secteurs as $idSecteur) {
                $stmtRelier->execute([
                    'id_secteur' => $idSecteur,
                    'id_serveur' => $idServeur
                ]);
            }

            return true;
        } catch (PDOException $e) {
            error_log('Erreur création employé : ' . $e->getMessage());
            return false;
        }
    }
}