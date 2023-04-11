<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/build/css/app.css">
    <title>Biblioteca CUCEI</title>
</head>

<script>
    window.onload = function() {
        element = document.getElementById('entrar');
        element.addEventListener("click", function() {
            codigo = document.getElementById('codigo').value;
            nip = document.getElementById('nip').value;

            if (codigo == '' || nip == '') {
                document.getElementById("alerta").style.display = "block";
                document.getElementById("alerta").innerText = "Llene los campos";
                setTimeout(function() {
                    document.getElementById("alerta").style.display = "none";
                }, 5000);
            } else {
                ajax();
            }
        });
    }

    function ajax() {
        const http = new XMLHttpRequest();
        const url = '/back-end/logIn.php';
        codigo = document.getElementById('codigo').value;
        nip = document.getElementById('nip').value;

        http.onreadystatechange = function() {
            //solicitud exitosa
            if (this.readyState == 4 && this.status == 200) {
                let data = this.responseText;
                console.log(data);

                if (data == 1) {
                    window.location.href = '/';
                } else {
                    document.getElementById("alerta").style.display = "block";
                    document.getElementById("alerta").innerText = "Datos incorrectos";
                    setTimeout(function() {
                        document.getElementById("alerta").style.display = "none";
                    }, 5000);
                }
            }
        }
        http.open("POST", url);
        http.setRequestHeader("content-type", "application/x-www-form-urlencoded")
        http.send("codigo=" + codigo + "&nip=" + nip);
    }
</script>

<body>
    <div class="barra">
        <img src="imagenes/logoUDGbarra.png">
        <img class="cucei" src="imagenes/cucei.png">
    </div>
    <h1>Bienvenido a Biblioteca CUCEI</h1>
    <div class="contenedor">
        <p class="alerta" id="alerta" style="display: none; color:red;"></p>
    </div>
    <div class="contenedor datos">
        <label for="codigo">Código </label><input name="codigo" id="codigo" type="text" maxlength="9" placeholder="Codigo">
        <label for="nip">NIP </label><input name="nip" id="nip" type="password" placeholder="NIP">
    </div>
    <div class="contenedor opciones">
        <a class="boton verde" id="entrar">Entrar</a>
        <a href="registroUsuario.php" class="boton azul" id="registrarme">Registrarme</a>
    </div>
    <?php
    include 'footer.php';
    ?>