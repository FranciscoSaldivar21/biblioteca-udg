<?php
require 'conexion.php';
require '../header.php';

$codigo = intval($_SESSION['codigo']);

$db = conectarDB();
$query = "SELECT * FROM usuarios WHERE codigo = ${codigo}";
$result = mysqli_query($db, $query);

$data = array();

if ($result) {
    while ($row = mysqli_fetch_array($result))
        $data[] = $row;
    $json = json_encode($data);
    echo $json;
} else {
    return '';
}