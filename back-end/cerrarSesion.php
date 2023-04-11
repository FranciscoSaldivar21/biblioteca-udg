<?php 
    //Inicia la sesion para acceder a la superglobal de SESSION
    session_start();

    //Se vacea el arreglo de SESSION para eliminar los datos de la sesion
    $_SESSION = [];

    //Se redirecciona a index
    header('Location: /');
