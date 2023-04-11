<?php
require 'conexion.php';


$payload = file_get_contents('php://input');
$buscar = json_decode($payload);
$codigo = intval($buscar);

$db = conectarDB();
$query = "SELECT idLibro FROM detalleprestamo WHERE idPrestamo = ${codigo}";
$result = mysqli_query($db, $query);
$data = array();

if ($result) {
    while ($row = mysqli_fetch_array($result))
        $array[] = $row["idLibro"];
    $json = json_encode($array);
    echo $json;
} else {
    echo false;
}
