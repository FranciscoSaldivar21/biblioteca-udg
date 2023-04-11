<?php
require 'conexion.php';

$db = conectarDB();
$id = intval($_GET['id']);
$fecha = $_GET['fecha'];

$query = "UPDATE prestamo SET fechaDevolucion = '${fecha}', postpuesto = 1 WHERE id = ${id}";
$result = mysqli_query($db, $query);

if ($result) {
    header("Location: ../prestamo.php?id=" . $id);
} else {
    echo "Error";
}
