<?php
include('header.php');
require 'back-end/conexion.php';

$isbn = $_GET['isbn'];
$ruta = 'imagenesServer/';

$db = conectarDB();
$query = "SELECT id FROM libro INNER JOIN librosisbn ON libro.isbn = librosisbn.isbn WHERE libro.isbn = ${'isbn'} AND estado = 1";;
$result = mysqli_query($db, $query);
$existencia = $result->num_rows;
$query = "SELECT * FROM libro INNER JOIN librosisbn ON libro.isbn = librosisbn.isbn WHERE libro.isbn = ${'isbn'}";
$result = mysqli_query($db, $query);
?>

<body>
    <div class="contenedor">
        <div class="contenedor-libro">
            <?php while ($row = mysqli_fetch_array($result)) : ?>
                <div class="imagen-libro">
                    <img src="<?php echo $ruta . $row['imagen']; ?>">
                </div>
                <div class="contenido-libro">
                    <p><span>ISBN: </span><?php echo $row['isbn']; ?></p>
                    <p><span>Titulo: </span><?php echo $row['nombre']; ?></p>
                    <p><span>Autores: </span><?php echo $row['autores']; ?></p>
                    <p><span>Editorial: </span><?php echo $row['editorial']; ?></p>
                    <p><span>Edición: </span><?php echo $row['edicion']; ?></p>
                    <p><span>Existencia: </span> <?php echo $existencia ?></p>
                    <p class="<?php echo $existencia >= 1 ? 'disponible' : 'no-disponible'; ?>">
                        <span>Estado: </span><?php echo $existencia >= 1 ? 'Disponible' : 'No disponible'; ?>
                    </p>
                    <div class="opciones">
                        <?php if ($_SESSION['rol'] == 1) : ?>
                            <a title="Editar libro" href="editarLibroIsbn.php?isbn=<?php echo $row['isbn']; ?>" class="boton azul">Editar libros</a>
                            <a title="Editar libro" href="editarLibro.php?isbn=<?php echo $row['isbn']; ?>" class="boton azul">Editar información</a>
                            <a title="Libro ISBN" href="librosIsbn.php?isbn=<?php echo $row['isbn']; ?>" class="boton azul">Ver libros por ISBN</a>
                        <?php endif; ?>
                        <a onclick="agregarCarrito('<?php echo $row['nombre']; ?>', '<?php echo $row['isbn']; ?>', '<?php echo $row['estado']; ?>', '<?php echo $row['imagen']; ?>', '<?php echo $ruta; ?>', '<?php echo $idLibro; ?>')" title="Agregar al carrito" href="#" class="boton verde">Añadir a la cesta</a>
                        <a title="Regresar a catalogo" href="/" class="boton rojo">Regresar</a>
                    </div>
                </div>
            <?php
                break;
            endwhile;
            ?>
        </div>
    </div>
</body>


<?php include('footer.php'); ?>