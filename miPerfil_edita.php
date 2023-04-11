<?php
    include 'header.php';
    include 'back-end/conexion.php';
    $db = conectarDB();


    $codigo = intval($_SESSION['codigo']);

    $query = "SELECT * FROM usuarios WHERE codigo = ${codigo}";
    $result = mysqli_query($db, $query);


    while ($row = mysqli_fetch_array($result)) {
        $nombre = $row['nombre'];
        $correo = $row['correo'];
        $nip = $row['password'];
    }
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("formulario").addEventListener('submit', validarFormulario);
    });

    function validarFormulario(evento) {
        evento.preventDefault();
        var codigo = document.getElementById('codigo').value;
        var nip = document.getElementById('nip').value;
        var correo = document.getElementById('correo').value;
        var nombre = document.getElementById('nombre').value;

        if (correo == '' || nip == '' || correo == '' || nombre == '') {
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
    <form type='POST' id="formulario" class="contenedor formulario usuario" action="back-end/actualizaPerfil.php">
        <label for="codigo">Código </label><input value="<?php echo $codigo; ?>" name="codigo" id="codigo" type="text" maxlength="9" placeholder="Codigo" readonly>
        <label for="correo">Correo </label><input value="<?php echo $correo; ?>" name="correo" id="correo" type="email" placeholder="Tu correo">
        <label for="nombre">Nombre</label><input value="<?php echo $nombre; ?>" name="nombre" id="nombre" type="text" placeholder="Tu nombre completo">
        <label for="nip">NIP </label><input value="<?php echo $nip; ?>" name="nip" id="nip" type="password" placeholder="NIP">
        <input type="submit" class="boton verde" id="guardar" value="Guardar">
    </form>
    <div class="contenedor ingresar">
        <a href="miPerfil.php?codigo=<?php echo $_SESSION['codigo']; ?>" class="boton azul">Regresar</a>
    </div>
<?php
    include 'footer.php';
?>