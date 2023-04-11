<?php
    include 'header.php';
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
            console.log(this);
            this.submit();
        }
    }
</script>

<body>
    <h1>Registro de tipo de sanción</h1>
    <div class="contenedor">
        <p class="alerta" id="alerta" style="display: none; color:red;"></p>
    </div>
    <form type='POST' id="formulario" class="contenedor formulario" action="back-end/registroTipoSancion.php">
        <label for="descripcion">Descripcion </label><input name="descripcion" id="descripcion" type="text" placeholder="Descripcion">
        <label for="costo">Costo </label><input name="costo" id="costo" type="number" placeholder="Costo">
        <input type="submit" class="boton verde" id="entrar" value="Guardar">
    </form>
    <div class="contenedor ingresar">
        <a href="sanciones.php" class="boton rojo">Regresar</a>
    </div>
    <?php
    include 'footer.php';
    ?>