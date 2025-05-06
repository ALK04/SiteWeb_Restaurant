<?php

class Statut_Table
{
    private $statut_table;

    public function __construct($statut_table)
    {
        $this->statut_table = $statut_table;
    }

    public function getStatut_Table()
    {
        return $this->statut_table;
    }
}
