<?php
include 'header.php';
include 'back-end/conexion.php';
$db = conectarDB();


$isbn = intval($_GET['isbn']);

$query = "SELECT * FROM libro WHERE isbn = ${isbn}";
$result = mysqli_query($db, $query);

while ($row = mysqli_fetch_array($result)) {
    $nombre = $row['nombre'];
    $autores = $row['autores'];
    $editorial = $row['editorial'];
    $edicion = $row['edicion'];
    $imagen = $row['imagen'];
}
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("formulario").addEventListener('submit', validarFormulario);
    });

    function validarFormulario(evento) {
        evento.preventDefault();
        var titulo = document.getElementById('nombre').value;
        var autores = document.getElementById('autores').value;
        var edicion = document.getElementById('edicion').value;
        var editorial = document.getElementById('editorial').value;
        //var imagen = document.getElementById('imagen').value;

        if (titulo == '' || autores == '' || edicion == '' || editorial == '') {
            document.getElementById("alerta").style.display = "block";
            document.getElementById("alerta").innerText = "Llene todos los campos";
            setTimeout(function() {
                document.getElementById("alerta").style.display = "none";
            }, 5000);
        } else {
            this.submit();
        }
    }
</script>

<body>
    <div class="contenedor">
        <p class="alerta" id="alerta" style="display: none; color:red;"></p>
    </div>
    <form method="post" enctype="multipart/form-data" id="formulario" class="contenedor formulario usuario" action="back-end/actualizaLibro.php">
        <label for="isbn">ISBN </label><input value="<?php echo $isbn; ?>" name="isbn" id="isbn" type="text" readonly>
        <label for="nombre">Titulo </label><input value="<?php echo $nombre; ?>" name="nombre" id="nombre" type="text" placeholder="Titulo">
        <label for="autores">Autores </label><input value="<?php echo $autores; ?>" name="autores" id="autores" type="text" placeholder="Autores">
        <label for="editorial">Editorial </label><input value="<?php echo $editorial; ?>" name="editorial" id="editorial" type="text" placeholder="Editorial">
        <label for="edicion ">Edición </label><input value="<?php echo $edicion; ?>" name="edicion" id="edicion" type="number" placeholder="Edición">
        <label for="imagen">Agrega portada </label>
        <input id="imagen" type="file" name="imagen" accept="image/*">
        <input type="submit" class="boton verde" id="guardar" value="Guardar">
    </form>
    <div class="contenedor ingresar">
        <a href="libro.php?isbn=<?php echo $isbn; ?>" class="boton azul">Regresar</a>
    </div>
    <?php
    include 'footer.php';
    ?>