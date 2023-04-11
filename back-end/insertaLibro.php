<?php
    require 'conexion.php';
    $isbn = intval($_POST['isbn']);
    $titulo = $_POST['titulo'];
    $autores = $_POST['autores'];
    $editorial = $_POST['editorial'];
    $edicion = $_POST['edicion'];
    $imagen = $_FILES['imagen'];

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

    $db = conectarDB();
    $query = "SELECT * FROM libro WHERE isbn = ${isbn}";
    $result = mysqli_query($db, $query);

    //Si trajo un registro significa que existe un libro con el mismo ISBN
    if($result->num_rows != 0){
        $query = "INSERT INTO librosisbn(isbn) VALUES (${isbn})";
        $result = mysqli_query($db, $query);
    }else{
        //Se inserta primero en tabla libro para datos generales
        $query = "INSERT INTO libro(isbn,nombre,autores,editorial,edicion,imagen) VALUES (${isbn}, '${titulo}', '${autores}', '${editorial}', '${edicion}','${nombreImagen}')";
        $result = mysqli_query($db, $query);

    //Despues se inserta en tabla librosIsbn para datos especificos
        $query = "INSERT INTO librosisbn(isbn) VALUES (${isbn})";
        $result = mysqli_query($db, $query);
    }
    header("Location: /index.php");
    return;
?>