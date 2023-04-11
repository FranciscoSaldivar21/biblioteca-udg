<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/build/css/app.css">
    <title>Registro</title>
</head>

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
        }else{
            console.log(this);
            this.submit();
        }
    }
</script>

<body>
    <div class="barra">
        <img src="imagenes/logoUDGbarra.png">
        <img class="cucei" src="imagenes/cucei.png">
    </div>
    <h1>Registro de usuario</h1>
    <div class="contenedor">
        <p class="alerta" id="alerta" style="display: none; color:red;"></p>
    </div>
    <form type='POST' id="formulario" class="contenedor formulario usuario" action="back-end/registroUsuario.php">
        <label for="codigo">Código </label><input name="codigo" id="codigo" type="text" maxlength="9" placeholder="Codigo">
        <label for="correo">Correo </label><input name="correo" id="correo" type="email" placeholder="Tu correo">
        <label for="nombre">Nombre</label><input name="nombre" id="nombre" type="text" placeholder="Tu nombre completo">
        <label for="nip">NIP </label><input name="nip" id="nip" type="password" placeholder="NIP">
        <input type="submit" class="boton verde" id="entrar" value="Registrarme">
    </form>
    <div class="contenedor ingresar">
        <a href="/" class="boton azul">Ingresar</a>
    </div>
    <?php
    include 'footer.php';
    ?>