<?php
    require 'conexion.php';
    $nombre = $_GET['nombre'];
    $codigo = intval($_GET['codigo']);
    $correo = $_GET['correo'];
    $nip = $_GET['nip'];

    echo $nombre;
    echo $codigo;
    echo $correo;
    echo $nip;

    $db = conectarDB();
    $query = "INSERT INTO usuarios(codigo,nombre,correo,password,rol) VALUES(${codigo},'${nombre}','${correo}','${nip}',0)";
    $result = mysqli_query($db, $query);

    session_start();
    //Llenar el arreglo de la sesion
    $_SESSION['codigo'] = $codigo;
    $_SESSION['correo'] = $correo;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['rol'] = 0;
    $_SESSION['auth'] = true;
    header("Location: /index.php");
    //return;
