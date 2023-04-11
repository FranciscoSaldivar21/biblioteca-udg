<?php
require 'conexion.php';

$db = conectarDB();
$query = "SELECT * FROM tiposancion";
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
