<?php
require 'conexion.php';
session_start();


//Sacar busqueda
$payload = file_get_contents('php://input');
$buscar = json_decode($payload);
$codigo = intval($buscar);

$query = "SELECT idUsuario FROM prestamo WHERE id = ${codigo} AND sancionado = 0";

$db = conectarDB();
$result = mysqli_query($db, $query);

$nombre = '';

if ($result) {
    while ($row = mysqli_fetch_array($result))
        $nombre = $row['idUsuario'];
    echo $nombre;
} else {
    echo false;
}
