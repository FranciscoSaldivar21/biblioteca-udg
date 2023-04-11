<?php
include('header.php');
require 'back-end/conexion.php';

$id = $_GET['id'];

$db = conectarDB();
$query = "SELECT * FROM prestamo INNER JOIN usuarios ON idUsuario = usuarios.codigo WHERE prestamo.id = ${'id'}";
$result = mysqli_query($db, $query);

$query = "SELECT * FROM detalleprestamo INNER JOIN librosisbn ON idLibro = librosisbn.id INNER JOIN libro ON librosisbn.isbn = libro.isbn WHERE idPrestamo = ${id}";
$result2 = mysqli_query($db, $query);
?>

<body>
    <div class="contenedor">
        <div class="contenedor-detalle">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <?php
                $estado = intval($row['estado']);
                if ($estado == 0)
                    $estatus = 'En espera a ser recogido';
                else if ($estado == 1)
                    $estatus = 'En proceso';
                else if ($estado == 2)
                    $estatus = 'Terminado';
                ?>
                <div class="contenido-libro">
                    <p><span>ID de prestamo: </span><?php echo $row['id']; ?></p>
                    <p><span>Nombre: </span><?php echo $row['nombre']; ?></p>
                    <p><span>Código: </span><?php echo $row['idUsuario']; ?></p>
                    <p><span>Fecha para recoger: </span><?php echo $row['fecha']; ?></p>
                    <p><span>Fecha limite para devolver prestamo: </span><?php echo $row['fechaDevolucion']; ?></p>
                    <p><span>Estado: </span>
                        <?php if ($estado == 0) echo 'Preparando'; ?>
                        <?php if ($estado == 1) echo 'Listo para recoger'; ?>
                        <?php if ($estado == 2) echo 'En proceso'; ?>
                        <?php if ($estado == 3) echo 'Terminado'; ?>
                    </p>

                    <?php if (intval($row['postpuesto']) == 0 && $estado != 3) : ?>
                        <!--Codigo para extraer fecha-->
                        <?php
                        $fecha = DateTime::createFromFormat("d-m-Y", $row['fechaDevolucion']);
                        $fecha = $fecha->format("d-m-Y");
                        $fechaDev = date("d-m-Y", strtotime($fecha . "+ 8 days"));
                        ?>
                        <p>Usted puede postponer la entrega una semana</p>
                        <a class="boton verde" href="back-end/postponerEntrega.php?id=<?php echo $row['id']; ?>&fecha=<?php echo $fechaDev; ?>">Postponer entrega</a>
                    <?php endif; ?>
                    <?php if ($_SESSION['rol'] == 1) : ?>
                        <?php if ($estado == 0) : ?>
                            <a href="back-end/actualizaPrestamo.php?id=<?php echo $row['id']; ?>&estado=1" class="boton azul" id="recogido">Listo para recoger</a>
                        <?php endif; ?>
                        <?php if ($estado == 1) : ?>
                            <a href="back-end/actualizaPrestamo.php?id=<?php echo $row['id']; ?>&estado=2" class="boton verde" id="terminado">Cambiar estatus a recogido</a>
                        <?php endif; ?>
                        <?php if ($estado == 2) : ?>
                            <a href="back-end/actualizaPrestamo.php?id=<?php echo $row['id']; ?>&estado=3" class="boton verde" id="terminado">Cambiar estatus a terminado</a>
                        <?php endif; ?>
                        <?php if ($estado == 3) : ?>
                            <p>El prestamo ha sido devuelto</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php
                break;
            endwhile;
            ?>
        </div>
        <p>Detalle de pedido</p>
        <div class="elemento-detalle">
            <?php while ($row = mysqli_fetch_assoc($result2)) : ?>
                <div class="imagen-detalle">
                    <img src="imagenesServer/<?php echo $row['imagen']; ?>">
                </div>
                <div class="contenido-libro">
                    <p><span>ID: </span><?php echo $row['id']; ?></p>
                    <p><span>ISBN: </span><?php echo $row['isbn']; ?></p>
                    <p><span>Titulo: </span><?php echo $row['nombre']; ?></p>
                    <p><span>Autor: </span><?php echo $row['autores']; ?></p>
                </div>
            <?php endwhile; ?>
        </div>
        <a id="regresar-catalogo" title="Regresar" href="prestamos.php" class="boton rojo">Regresar</a>
    </div>
</body>



<?php include('footer.php'); ?>