<?php
require 'conexion.php';
session_start();
$rol = intval($_SESSION['rol']);
$idUser = intval($_SESSION['codigo']);


//Sacar busqueda
$payload = file_get_contents('php://input');
$buscar = json_decode($payload);
$id = intval($buscar);


if ($rol == 1)
    $query = "SELECT * FROM sanciones INNER JOIN usuarios ON sanciones.idUsuario = usuarios.codigo WHERE usuarios.nombre LIKE '%" . $buscar . "%' OR sanciones.id LIKE '" . $id . "%'";
else if ($rol == 0)
    $query = "SELECT * FROM sanciones INNER JOIN usuarios ON sanciones.idUsuario = usuarios.codigo WHERE usuarios.nombre LIKE '%" . $buscar . "%' OR sanciones.id LIKE '%" . $id . "%' AND sanciones.codigo = $idUser";

$db = conectarDB();
$result = mysqli_query($db, $query);

$data = array();
$array = [];

if ($result) {
    while ($row = mysqli_fetch_array($result))
        $array[] = $row;
    $json = json_encode($array);
    echo $json;
} else {
    echo false;
}
