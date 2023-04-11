<?php
require 'conexion.php';

//Sacar busqueda
$payload = file_get_contents('php://input');
$buscar = json_decode($payload);
$id = intval($buscar);

$query = "SELECT * FROM librosisbn INNER JOIN libro ON librosisbn.isbn = libro.isbn WHERE id = ${id}";

$db = conectarDB();
$result = mysqli_query($db, $query);

$data = array();
$array = [];

if ($result) {
    while ($row = mysqli_fetch_array($result))
        $array[] = $row;
    $json = json_encode($array);

    if(empty($array))
        echo false;
    else
        echo $json;
} else {
    echo false;
}