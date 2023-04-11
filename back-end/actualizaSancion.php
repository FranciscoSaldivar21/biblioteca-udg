<?php
require 'conexion.php';

$db = conectarDB();
$id = intval($_GET['id']);

$query = "UPDATE sanciones SET estado = 1 WHERE id = ${id}";
$result = mysqli_query($db, $query);

//Volver a poner libros como disponibles
    $query = "SELECT idLibro FROM detallesancion WHERE idSancion = ${id}";
    $result = mysqli_query($db, $query);

    while ($row = mysqli_fetch_array($result)) {
        $idLibro = $row['idLibro'];
        $query = "UPDATE librosisbn SET estado = 1 WHERE id = ${idLibro}";
        mysqli_query($db, $query);
    }

if ($result) {
    header("Location: ../sancionUsuario.php?id=" . $id);
} else {
    echo "Error";
}
