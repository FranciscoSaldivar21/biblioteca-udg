<?php
require 'conexion.php';
$codigo = $_POST['codigo'];
$nip = $_POST['nip']; 

$db = conectarDB();
$query = "SELECT * FROM usuarios WHERE codigo = ${codigo} AND password = '${nip}'";
$result = mysqli_query($db, $query);

if ($result->num_rows == 1) {
    while ($row = mysqli_fetch_array($result)) {
        $nombre = $row['nombre'];
        $correo = $row['correo'];
        $rol = $row['rol'];
    }
    session_start();
    //Llenar el arreglo de la sesion
    $_SESSION['codigo'] = $codigo;
    $_SESSION['correo'] = $correo;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['rol'] = $rol;
    $_SESSION['auth'] = true;

    echo 1;

} else {

    echo 0;
}
