<?php
    include 'conexion.php';
    $db = conectarDB();
    session_start();
    $codigo = intval($_SESSION['codigo']);
    $fecha = date("d-m-Y");
    $fecha = date("d-m-Y", strtotime($fecha . "+ 1 day")); 
    $fechaDev = date("d-m-Y", strtotime($fecha . "+ 8 days")); 

    $query = "INSERT INTO prestamo (idUsuario, fecha, estado, fechaDevolucion) VALUES ($codigo, '$fecha', 0, '$fechaDev')";
    $result = mysqli_query($db, $query);

    $query = "SELECT id FROM prestamo ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($db, $query);

    $payload = file_get_contents('php://input');
    $carrito = json_decode($payload);

    $idLibro = 0;
    $id = 0;

    while ($row = mysqli_fetch_array($result)) {
        $id = intval($row['id']);
    }

    foreach ($carrito as $row) {
        $idLibro = intval($row->id);
        $query = "INSERT INTO detalleprestamo(idPrestamo, idLibro) VALUES ($id, $idLibro)";
        $result = mysqli_query($db, $query);
        $query = "UPDATE librosisbn SET estado = 0 WHERE id = $idLibro";
        $result = mysqli_query($db, $query);
    }

    echo $id;
