<?php
require 'conexion.php';

$db = conectarDB();
$payload = file_get_contents('php://input');
$idSancion = json_decode($payload);

$query = "SELECT costo FROM tiposancion WHERE id = ${idSancion}";
$result = mysqli_query($db, $query);
$costo = 0;

while ($row = mysqli_fetch_array($result)) {
    $costo = intval($row['costo']);
    break;
}

echo $costo;
