<?php
    require 'conexion.php';

    $db = conectarDB();
    $id = intval($_GET['id']);
    $descripcion = $_GET['descripcion'];
    $costo = intval($_GET['costo']);

    $query = "UPDATE tiposancion SET descripcion = '${descripcion}', costo = '${costo}' WHERE id = ${id}";
    $result = mysqli_query($db, $query);

    if ($result) {
        header("Location: ../sanciones.php");
    } else {
        echo "Error";
    }
    //header('Location: miPerfil?codigo="${codigo}"');
