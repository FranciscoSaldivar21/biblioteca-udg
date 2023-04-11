<?php
require 'conexion.php';

$db = conectarDB();
$query = "SELECT id FROM prestamo ORDER BY id DESC LIMIT 1";
$result = mysqli_query($db, $query);
$id = 0;

while ($row = mysqli_fetch_array($result)) {
    $id = intval($row['id']);
    break;
}

echo $id;
