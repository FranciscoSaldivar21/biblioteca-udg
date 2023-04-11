<?php
include('header.php');
require 'back-end/conexion.php';

$isbn = intval($_GET['isbn']);

$db = conectarDB();
$query = "SELECT * FROM libro INNER JOIN librosisbn ON libro.isbn = librosisbn.isbn WHERE libro.isbn = ${isbn}";
$result = mysqli_query($db, $query);
?>

<body>
    <div class="contenedor">
        <p>Libros con ISBN: <?php echo $isbn ?></p>
        <div class="elemento-detalle">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <?php
                $estado = 0;
                $clase = '';
                if (intval($row['estado']) == 1) {
                    $estado = 'Disponible';
                    $clase = 'disponible';
                } else {
                    $estado = 'No disponible';
                    $clase = 'no-disponible';
                }
                ?>
                <div class="imagen-detalle">
                    <img src="imagenesServer/<?php echo $row['imagen']; ?>">
                </div>
                <div class="contenido-libro">
                    <p><span>ID: </span><?php echo $row['id']; ?></p>
                    <p><span>Titulo: </span><?php echo $row['nombre']; ?></p>
                    <p><span>Autor: </span><?php echo $row['autores']; ?></p>
                    <p class="<?php echo $clase; ?>"><span>Estado: </span><?php echo $estado; ?></p>
                </div>
            <?php endwhile; ?>
        </div>
        <a id="regresar-catalogo" title="Regresar" href="libro.php?isbn=<?php echo $isbn; ?>" class="boton rojo">Regresar</a>
    </div>
</body>



<?php include('footer.php'); ?>