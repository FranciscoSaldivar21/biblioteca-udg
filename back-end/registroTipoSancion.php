<?php
require 'conexion.php';
$descripcion = $_GET['descripcion'];
$costo = intval($_GET['costo']);


$db = conectarDB();
$query = "INSERT INTO tiposancion(descripcion,costo) VALUES('${descripcion}',${costo})";
$result = mysqli_query($db, $query);

if($result){
    header("Location: ../sanciones.php");
}