<?php
    require 'conexion.php';
    $isbn = $_POST['isbn'];

    $db = conectarDB();
    $query = "SELECT * FROM libro WHERE isbn = ${'isbn'}";
    $result = mysqli_query($db, $query);

    if($result->num_rows != 0){
        return true;
    }else{
        return false;
    }