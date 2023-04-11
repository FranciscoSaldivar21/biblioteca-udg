<?php
    require 'conexion.php';

    $db = conectarDB();
    $codigo = intval($_GET['codigo']);
    $nombre = $_GET['nombre'];
    $correo = $_GET['correo'];
    $nip = $_GET['nip'];

    $query = "UPDATE usuarios SET nombre = '${nombre}', correo = '${correo}', password = '${nip}' WHERE codigo = ${codigo}";
    $result = mysqli_query($db, $query);

    if ($result) {
        header("Location: / ");
    } else {
        echo "Error";
    }
    //header('Location: miPerfil?codigo="${codigo}"');

?>