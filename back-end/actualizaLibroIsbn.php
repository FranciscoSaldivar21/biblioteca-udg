<?php
    require 'conexion.php';

    $db = conectarDB();
    $id = intval($_GET['idLibro']);
    $pasillo = $_GET['pasillo'];
    $estante = $_GET['estante'];
    $estado = intval($_GET['estado']);

    if($estado == 2){
        $estado = 0;
    }

    $query = "UPDATE librosisbn SET pasillo = '${pasillo}', estante = '${estante}', estado = ${estado} WHERE id = ${id}";
    $result = mysqli_query($db, $query);

    if ($result) {
        //Colocar aquí redirección a libros ISBN
        header("Location: /");
    } else {
        echo "Error";
    }
