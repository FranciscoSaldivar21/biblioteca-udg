<?php
require 'conexion.php';

$payload = file_get_contents('php://input');
$buscar = json_decode($payload);
$id = intval($buscar);

$db = conectarDB();
$query = "SELECT pasillo, estante, estado FROM librosisbn WHERE id = ${id}";
$result = mysqli_query($db, $query);
$data = array();

if ($result) {
    while ($row = mysqli_fetch_array($result))
        $array[] = $row;
    $json = json_encode($array);
    echo $json;
} else {
    return false;
}
