<?php
    function conectarDB()
    {
        $db = mysqli_connect('localhost', 'root', 'representativo', 'biblioteca');

        if (!$db) {
            echo "Connection failed";
            exit;
        }
        return $db;
    }