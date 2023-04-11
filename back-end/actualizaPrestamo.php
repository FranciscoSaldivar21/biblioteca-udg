<?php
    require 'conexion.php';

    $db = conectarDB();
    $id = intval($_GET['id']);
    $estado = intval($_GET['estado']);

    $query = "UPDATE prestamo SET estado = ${estado} WHERE id = ${id}";
    $result = mysqli_query($db, $query);

    //Volver a poner libros como disponibles
    if($estado == 3){
        $query = "SELECT idLibro FROM detallePrestamo WHERE idPrestamo = ${id}";
        $result = mysqli_query($db, $query);

        while ($row = mysqli_fetch_array($result)){
            $idLibro = $row['idLibro'];
            $query = "UPDATE librosisbn SET estado = 1 WHERE id = ${idLibro}";
            mysqli_query($db, $query);
        }
    }

    if ($result) {
        header("Location: ../prestamo.php?id=".$id);
    } else {
        echo "Error";
    }
