<?php
include 'header.php';
include 'back-end/conexion.php';
$db = conectarDB();


$id = intval($_GET['id']);

$query = "SELECT * FROM tiposancion WHERE id = ${id}";
$result = mysqli_query($db, $query);


while ($row = mysqli_fetch_array($result)) {
    $descripcion = $row['descripcion'];
    $costo = $row['costo'];
}
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("formulario").addEventListener('submit', validarFormulario);
    });

    function validarFormulario(evento) {
        evento.preventDefault();
        var descripcion = document.getElementById('descripcion').value;
        var costo = document.getElementById('costo').value;

        if (descripcion == '' || costo == '') {
            document.getElementById("alerta").style.display = "block";
            document.getElementById("alerta").innerText = "Llene todos los campos";
            setTimeout(function() {
                document.getElementById("alerta").style.display = "none";
            }, 5000);
        } else {
            console.log("Entré");
            this.submit();
        }
    }
</script>

<body>
    <div class="contenedor">
        <p class="alerta" id="alerta" style="display: none; color:red;"></p>
    </div>
    <form type='POST' id="formulario" class="contenedor formulario usuario" action="back-end/actualizaTipoSancion.php">
        <label for="id">ID </label><input value="<?php echo $id; ?>" name="id" id="id" type="text" readonly>
        <label for="descripcion">Descripcion</label><input value="<?php echo $descripcion; ?>" name="descripcion" id="descripcion" type="text" placeholder="Descripcion de sanción">
        <label for="costo">Costo </label><input value="<?php echo $costo; ?>" name="costo" id="costo" type="number" placeholder="Costo">
        <input type="submit" class="boton verde" id="guardar" value="Guardar">
    </form>
    <div class="contenedor ingresar">
        <a href="sanciones.php" class="boton azul">Regresar</a>
    </div>
    <?php
    include 'footer.php';
    ?>