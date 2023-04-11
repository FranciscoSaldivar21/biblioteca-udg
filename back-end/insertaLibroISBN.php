<?php
require 'conexion.php';
$payload = file_get_contents('php://input');
$isbn = json_decode($payload);
$isbn = intval($isbn);

$db = conectarDB();
$query = "INSERT INTO librosisbn(isbn) VALUES (${isbn})";
$result = mysqli_query($db, $query);

if($result){
    echo true;
}else{
    echo false;
}
return;
