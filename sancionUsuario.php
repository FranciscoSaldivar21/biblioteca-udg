<?php
include('header.php');
require 'back-end/conexion.php';

$id = $_GET['id'];

$db = conectarDB();
$query = "SELECT * FROM sanciones INNER JOIN usuarios ON idUsuario = usuarios.codigo WHERE sanciones.id = ${'id'}";
$result = mysqli_query($db, $query);

$query = "SELECT * FROM detallesancion INNER JOIN librosisbn ON idLibro = librosisbn.id INNER JOIN libro ON librosisbn.isbn = libro.isbn INNER JOIN tiposancion ON idTipoSancion = tiposancion.id WHERE idSancion = ${id}";
$result2 = mysqli_query($db, $query);
?>

<body>
    <div class="contenedor">
        <div class="contenedor-detalle">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <?php
                $estado = intval($row['estado']);
                if ($estado == 0)
                    $estatus = 'Pendiente';
                else if ($estado == 1)
                    $estatus = 'Pagada';
                ?>
                <div class="contenido-libro">
                    <p><span>ID de sancion: </span><?php echo $row['id']; ?></p>
                    <p><span>Nombre: </span><?php echo $row['nombre']; ?></p>
                    <p><span>Código: </span><?php echo $row['idUsuario']; ?></p>
                    <p><span>Fecha: </span><?php echo $row['fecha']; ?></p>
                    <p><span>ID prestamo: </span><?php echo $row['idPrestamo']; ?></p>

                    <?php if ($_SESSION['rol'] == 1) : ?>
                        <?php if ($estado == 0) : ?>
                            <a href="back-end/actualizaSancion.php?id=<?php echo $row['id']; ?>" class="boton verde" id="recogido">Cambiar estatus a pagado</a>
                        <?php endif; ?>
                        <?php if ($estado == 1) : ?>
                            <p>La sanción ha sido pagada</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php
                break;
            endwhile;
            ?>
        </div>
        <p>Detalle de sancion</p>
        <div class="elementos">
            <?php $total = 0; ?>
            <?php while ($row = mysqli_fetch_assoc($result2)) : ?>
                <div class="elemento-detalle">
                    <?php $total += intval($row['costo']); ?>
                    <div class="imagen-detalle">
                        <img src="imagenesServer/<?php echo $row['imagen']; ?>">
                    </div>
                    <div class="contenido-libro">
                        <p><span>ID: </span><?php echo $row['id']; ?></p>
                        <p><span>ISBN: </span><?php echo $row['isbn']; ?></p>
                        <p><span>Titulo: </span><?php echo $row['nombre']; ?></p>
                        <!--<p><span>ID tipo sanción: </span><?php echo $row['id']; ?></p> -->
                        <p><span>Descripcion de sanción: </span><?php echo $row['descripcion']; ?></p>
                        <p><span>Costo: </span><?php echo $row['costo']; ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="contenedor">
            <p><span>Total a pagar: </span><?php echo $total; ?></p>
        </div>
        <a id="regresar-catalogo" title="Regresar" href="sancionesUsuario.php" class="boton rojo">Regresar</a>
    </div>
</body>



<?php include('footer.php'); ?>