<?php
    require 'conexion.php';

    $db = conectarDB();
    $query = "SELECT * FROM libro INNER JOIN librosisbn ON libro.isbn = librosisbn.isbn ORDER BY libro.isbn DESC";
    $result = mysqli_query($db, $query);
    $data = array();

    if ($result) {
        while ($row = mysqli_fetch_array($result)) 
            $array[] = $row;
        $json = json_encode($array);
        echo $json;
    } else {
        return false; 
    }
