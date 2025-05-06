<?php
require_once 'Database.php';

class Plats{
    private $ID_plat;
    private $nom_plat;
    private $sur_la_carte;
    private $prix;
    private $type_plat;
    private $contient_sauce;
    private $contient_cuisson;

    /**
     * @param $ID_plat
     * @param $nom_plat
     * @param $sur_la_carte
     * @param $prix
     * @param $type_plat
     * @param $contient_sauce
     * @param $contient_cuisson
     */
    public function __construct($ID_plat, $nom_plat, $sur_la_carte, $prix, $type_plat, $contient_sauce, $contient_cuisson)
    {
        $this->ID_plat = $ID_plat;
        $this->nom_plat = $nom_plat;
        $this->sur_la_carte = $sur_la_carte;
        $this->prix = $prix;
        $this->type_plat = $type_plat;
        $this->contient_cuisson = $contient_cuisson;
        $this->contient_sauce = $contient_sauce;
    }

    /**
     * @return mixed
     */
    public function getIDPlat()
    {
        return $this->ID_plat;
    }

    /**
     * @return mixed
     */
    public function getNomPlat()
    {
        return $this->nom_plat;
    }

    /**
     * @return mixed
     */
    public function getSurLaCarte()
    {
        return $this->sur_la_carte;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @return Type_plat
     */
    public function getTypePlat()
    {
        return $this->type_plat;
    }

    /**
     * @return mixed
     */
    public function getContientSauce()
    {
        return $this->contient_sauce;
    }

    /**
     * @return mixed
     */
    public function getContientCuisson()
    {
        return $this->contient_cuisson;
    }



    public function toArray()
    {
        return [
          'ID_PLAT' => $this->getIDPlat(),
            'NOM_PLAT' => $this->getNomPlat(),
            'PRIX' => $this->getPrix(),
            'TYPE_PLAT' => $this->getTypePlat(),
            'CONTIENT_SAUCE' => $this->getContientSauce(),
            'CONTIENT_CUISSON' => $this->getContientCuisson()
        ];
    }

    public static function getAllPlats($type)
    {

        $db = new Database();
        $query = "SELECT p.ID_PLAT, p.NOM_PLAT, p.PRIX, tp.TYPE_PLAT, p.CONTIENT_SAUCE, p.CONTIENT_CUISSON
          FROM PLAT p
          JOIN TYPE_PLATS tp ON p.ID_TYPE_PLATS = tp.ID_TYPE_PLATS
          WHERE p.SUR_LA_CARTE = TRUE AND tp.TYPE_PLAT = '$type'";
        $conn = $db->getConnection();
        $stmt = $db->requete($query);

        $plats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $plats[] = new Plats($row['ID_PLAT'], $row['NOM_PLAT'], true, $row['PRIX'], $row['TYPE_PLAT'], $row['CONTIENT_SAUCE'], $row['CONTIENT_CUISSON']);
        }

        return $plats;
    }
    public static function getPlatById($id) {
        $db = new Database();
        $query = "SELECT p.ID_PLAT, p.NOM_PLAT, p.PRIX, tp.TYPE_PLAT, p.CONTIENT_SAUCE, p.CONTIENT_CUISSON
              FROM PLAT p
              JOIN TYPE_PLATS tp ON p.ID_TYPE_PLATS = tp.ID_TYPE_PLATS
              WHERE p.ID_PLAT = '$id'";

        $conn = $db->getConnection();
        $stmt = $db->requete($query);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return new Plats($row['ID_PLAT'], $row['NOM_PLAT'], true, $row['PRIX'], $row['TYPE_PLAT'], $row['CONTIENT_SAUCE'], $row['CONTIENT_CUISSON']);
    }

    public static function updatePlat($id, $nom, $prix, $type, $contient_sauce, $contient_cuisson) {
        $db = new Database();
        $conn = $db->getConnection();
        $query = "UPDATE PLAT SET NOM_PLAT = '$nom', PRIX = '$prix', ID_TYPE_PLATS = (
                      SELECT ID_TYPE_PLATS FROM TYPE_PLATS WHERE TYPE_PLAT = '$type'
                  ), CONTIENT_SAUCE = $contient_sauce, CONTIENT_CUISSON = $contient_cuisson WHERE ID_PLAT = '$id'";
        return $db->requete($query);

    }

    public static function createPlat($nom, $prix, $type, $contient_sauce, $contient_cuisson) {
        $db = new Database();
        $conn = $db->getConnection();
        $query = "INSERT INTO plat (NOM_PLAT, PRIX, ID_TYPE_PLATS, CONTIENT_SAUCE, CONTIENT_CUISSON) VALUES ('$nom', '$prix', (
                      SELECT ID_TYPE_PLATS FROM TYPE_PLATS WHERE TYPE_PLAT = '$type'
                  ), $contient_sauce, $contient_cuisson)";
        return $db->requete($query);
    }

    public static function updateSurLaCarte($id) {
        $db = new Database();
        $conn = $db->getConnection();
        $query = "UPDATE PLAT SET SUR_LA_CARTE = 0 WHERE ID_PLAT = '$id'";

        return $db->requete($query);
    }

}