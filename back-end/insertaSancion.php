<?php
include 'conexion.php';
$db = conectarDB();
session_start();
$codigo = intval($_GET['codigo']);
$prestamo = intval($_GET['prestamo']);
$fecha = date("d-m-Y");

$query = "INSERT INTO sanciones (idUsuario, fecha, estado, idPrestamo) VALUES ($codigo, '$fecha', 0, $prestamo)";
$result = mysqli_query($db, $query);

$query = "UPDATE prestamo SET sancionado = 1 WHERE id = $prestamo";
$result = mysqli_query($db, $query);

$query = "SELECT id FROM sanciones ORDER BY id DESC LIMIT 1";
$result = mysqli_query($db, $query);

$payload = file_get_contents('php://input');
$libros = json_decode($payload);

$idLibro = 0;
$id = 0;

while ($row = mysqli_fetch_array($result)) {
    $id = intval($row['id']);
    break;
}

foreach ($libros as $row) {
    $idLibro = intval($row->idLibro);
    $idTipo = intval($row->idTipoSancion);
    $costo = intval($row->costo);
    $query = "INSERT INTO detallesancion(idSancion, idLibro, idTipoSancion, costo) VALUES ($id, $idLibro, $idTipo, $costo)";
    $result = mysqli_query($db, $query);
    $query = "UPDATE librosisbn SET estado = 0 WHERE id = $idLibro";
    $result = mysqli_query($db, $query);
}

echo $id;
