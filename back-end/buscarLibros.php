<?php
require 'conexion.php';

$payload = file_get_contents('php://input');
$buscar = json_decode($payload);

$db = conectarDB();
#$query = "SELECT * FROM libro INNER JOIN librosisbn ON libro.isbn = librosisbn.isbn WHERE nombre = %'$buscar'%";
$query =  "SELECT * FROM libro INNER JOIN librosisbn ON libro.isbn = librosisbn.isbn WHERE libro.nombre LIKE '%" . $buscar . "%' OR libro.autores LIKE '%" . $buscar . "%'OR libro.isbn LIKE '%" . $buscar . "%'";
$result = mysqli_query($db, $query);
$data = array();
$array = [];

if ($result) {
    while ($row = mysqli_fetch_array($result))
        $array[] = $row;
    $json = json_encode($array);
    echo $json;
} else {
    return false;
}
