<?php
require 'conexion.php';

$db = conectarDB();
$isbn = intval($_POST['isbn']);
$nombre = $_POST['nombre'];
$edicion = intval($_POST['edicion']);
$editorial = $_POST['editorial'];
$autores = $_POST['autores'];
$imagen = $_FILES['imagen'];


if($imagen['tmp_name'] == ''){
    $query = "UPDATE libro SET nombre = '${nombre}', autores = '${autores}', editorial = '${editorial}', edicion = ${edicion} WHERE isbn = ${isbn}";
    $result = mysqli_query($db, $query);
}else{
    //Subida de archivos
    $rutaImagen = '../imagenesServer/';

    //Validar que exista la carpeta sino la crea
    if (!is_dir($rutaImagen)) {
        mkdir($rutaImagen);
    }

    //Generar un nombre unico
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    //Subir la imagen al servidor
    move_uploaded_file($imagen['tmp_name'], $rutaImagen . $nombreImagen);
    $query = "UPDATE libro SET nombre = '${nombre}', autores = '${autores}', editorial = '${editorial}', edicion = ${edicion}, imagen = '${nombreImagen}' WHERE isbn = ${isbn}";
    $result = mysqli_query($db, $query);
}

if ($result) {
    //Colocar aquí redirección a libros ISBN
    header("Location: /");
} else {
    echo "Error";
}
