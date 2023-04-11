<?php
require 'conexion.php';
session_start();
$rol = intval($_SESSION['rol']);
$idUser = intval($_SESSION['codigo']);

$db = conectarDB();


//Si es admin muestra todo
if ($rol == 1)
    $query = "SELECT * FROM sanciones INNER JOIN usuarios ON sanciones.idUsuario = usuarios.codigo LIMIT 5";
//Sino solo sus prestamos
else if ($rol == 0)
    $query = "SELECT * FROM sanciones INNER JOIN usuarios ON sanciones.idUsuario = usuarios.codigo WHERE idUsuario = $idUser";

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
