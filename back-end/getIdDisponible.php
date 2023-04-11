<?php
require 'conexion.php';

$db = conectarDB();
$payload = file_get_contents('php://input');
$isbn = json_decode($payload);

$query = "SELECT id FROM librosisbn WHERE isbn = ${isbn} AND estado = 1 LIMIT 1";
$result = mysqli_query($db, $query);
$id = 0;

while ($row = mysqli_fetch_array($result)) {
    $id = intval($row['id']);
    break;
}

echo $id;
