<?php
require 'conexion.php';
$payload = file_get_contents('php://input');
$isbn = json_decode($payload);
$isbn = intval($isbn);

$db = conectarDB();
$query = "SELECT * FROM libro WHERE isbn = ${isbn}";
$result = mysqli_query($db, $query);

if ($result->num_rows == 1) {
    echo true;
} else {
    echo false;
}
