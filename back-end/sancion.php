<?php
require 'conexion.php';
session_start();
$user = intval($_SESSION['codigo']);

$db = conectarDB();
$query = "SELECT * FROM sanciones WHERE idUsuario = ${user} AND estado = 0";
$result = mysqli_query($db, $query);

if ($result->num_rows > 0) {
    echo true;
} else {
    echo false;
}