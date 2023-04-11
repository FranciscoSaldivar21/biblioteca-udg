<?php
//Comprobar el inicio de sesion
session_start();

//Guardar auth para ver si se autentico antes o no
$auth = $_SESSION['auth'];
$codigo = $_SESSION['codigo'];
//Comprueba que no sea true, sino redirecciona
if (!$auth) {
    header('Location: login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>

<body>
    <header class="header">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a class="logoPrincipal" title="Inicio" href="/">
                    <img src="/imagenes/logoUDGbarra.png" alt="logotipo de universidad">
                </a>

                <div>
                    <nav class="navegacion">
                        <div class="elementoMenu">
                            <a title=" Catalogo " href="index.php"><img src="/imagenes/catalogo.png"></a>
                            <p>Catalogo</p>
                        </div>
                        <div class="elementoMenu">
                            <a title=" Historial de préstamos " href="prestamos.php"><img src="/imagenes/history.png"></a>
                            <p>Prestamos</p>
                        </div>
                        <div class="elementoMenu">
                            <a title=" Sanciones " href="sancionesUsuario.php"><img src="/imagenes/failed.png"></a>
                            <p>Sanciones</p>
                        </div>
                        <div class="elementoMenu">
                            <a title=" Mi perfil " class="image" href="miPerfil.php?codigo=<?php echo $_SESSION['codigo']; ?>"><img src="/imagenes/user.png"></a>
                            <p>Mi perfil</p>
                        </div>
                        <div class="elementoMenu">
                            <a id="boton-carrito" class="carrito" title="Cesta" href="#"><img src="/imagenes/bookstore.png" alt="cesta de compras"></a>
                            <p>Cesta</p>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <h1 class="no-margin">Bienvenido <?php echo $_SESSION['nombre']; ?></h1>
    </header>
    <?php include 'carrito.php'; ?>