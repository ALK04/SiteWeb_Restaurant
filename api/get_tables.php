<?php

/*ini_set('display_errors', 1);
error_reporting(E_ALL);

// Test rapide
echo json_encode(["test" => "ok"]);
exit;*/

require_once '../class/Database.php';
require_once '../class/Tables.php';

$tables = Tables::getAllTables();
$tableArray = array_map(function($t) {
    return $t->toArray();
}, $tables);

header('Content-Type: application/json');
echo json_encode($tableArray);
