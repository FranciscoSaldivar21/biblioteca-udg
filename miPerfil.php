<?php
include 'header.php';
?>

<?php
$codigo = $_GET['codigo'];

require 'back-end/conexion.php';

$db = conectarDB();
$query = "SELECT * FROM usuarios WHERE codigo = {$codigo}";
$result = mysqli_query($db, $query);

while ($row = mysqli_fetch_array($result)) {
    $nombre = $row['nombre'];
    $correo = $row['correo'];
    $rol = $row['rol'];
}
?>

<body>
    <div class="contenedor">
        <div class="datosPerfil">
            <p><span>Codigo: </span><?php echo $codigo; ?></p>
            <p><span>Nombre: </span><?php echo $nombre; ?></p>
            <p><span>Correo: </span><?php echo $correo; ?></p>
            <p><span>Tipo de usuario: </span><?php echo $rol = 0 ? "Academico" : "Administrativo"; ?></p>
        </div>
        <div class="perfil">
            <a href="miPerfil_edita.php"><img src="imagenes/editar.png">Editar perfil</a>
            <a href="back-end/cerrarSesion.php"><img src="imagenes/cerrar-sesion.png">Cerrar sesión</a>
        </div>
    </div>
</body>

<?php
include 'footer.php';
?>