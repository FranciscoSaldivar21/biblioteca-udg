<?php
//Modificar esta parte por el header del admin, validar la sesión del usuario
include 'header.php';
if ($_SESSION['rol'] == 0)
    header('Location: /');

?>

<script>
    //Añadir un evento en la pagina
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("formulario").addEventListener('submit', validarFormulario);
    });

    function validarFormulario(evento) {
        evento.preventDefault();
        var isbn = document.getElementById('isbn').value;
        var titulo = document.getElementById('titulo').value;
        var autores = document.getElementById('autores').value;
        var editorial = document.getElementById('editorial').value;
        var edicion = document.getElementById('edicion').value;
        var imagen = document.getElementById('imagen').value;

        const http = new XMLHttpRequest();
        const url = '/back-end/validarISBN.php';
        aux = JSON.stringify(isbn);

        http.onreadystatechange = function() {
            //Se encontró isbn
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == true) {
                    console.log("Se agregó solo el isbn");
                    //evento.submit();
                    const http = new XMLHttpRequest();
                    const url = '/back-end/insertaLibroISBN.php';
                    let aux = JSON.stringify(isbn);

                    http.onreadystatechange = function() {
                        //Se encontró isbn
                        if (this.readyState == 4 && this.status == 200) {
                            if (this.responseText == true) {
                                window.location.href = "/";
                            } else {
                                console.log("Algo salió mal");
                            }
                        }
                    }
                    http.open("POST", url, true);
                    http.send(aux);
                    return;
                } else {
                    document.getElementById("alert").style.display = "block";
                    setTimeout(function() {
                        document.getElementById("alert").style.display = "none";
                    }, 5000);
                    document.getElementById("alert2").style.display = "block";
                    setTimeout(function() {
                        document.getElementById("alert2").style.display = "none";
                    }, 5000);
                }
            }
        }
        http.open("POST", url, true);
        http.send(aux);

        if (isbn == '' || titulo == '' || autores == '' || editorial == '' || edicion == '' || imagen == '') {
            document.getElementById("alert").style.display = "block";
            setTimeout(function() {
                document.getElementById("alert").style.display = "none";
            }, 5000);
        } else {
            this.submit();
        }
    }
</script>
<main class="contenedor seccion pequeno">
    <a href="/" class="boton rojo">Cancelar</a>
    <h4>Llene el formulario completo</h4>
    <p id="alert" style="display: none; color:red;">Llene el formulario completo</p>
    <p id="alert2" style="display: none; color:red;">El ISBN no existe</p>
    <form class="formulario" method="POST" action="back-end/insertaLibro.php" enctype="multipart/form-data" id="formulario">
        <fieldset class="campos">
            <legend>Si el libro ya está registrado solo ingresa el ISBN</legend>
            <label for="isbn">ISBN: </label>
            <input id="isbn" name="isbn" type="text" id="isbn" placeholder="ISBN de libro">
            <label for="titulo">Titulo: </label>
            <input id="titulo" name="titulo" type="text" id="titulo" placeholder="Titulo de libro">
            <label for="autores">Autores: </label>
            <input id="autores" name="autores" type="text" id="autores" placeholder="Autores del libro">
            <label for="editorial">Editorial: </label>
            <input id="editorial" name="editorial" type="text" id="editorial" placeholder="Editorial del libro">
            <label for="edicion">Edición: </label>
            <input id="edicion" name="edicion" type="number" min="1900" max="2099" step="1" id="edicion" placeholder="Edición del libro" />
            <label for="imagen">Agrega portada </label>
            <input id="imagen" type="file" name="imagen" accept="image/*">
        </fieldset>
        <input type="submit" class="boton verde enviar" value="Guardar">
    </form>
</main>
<?php
//Modificar esta parte por el footer del admin, validar la sesión del usuario
include 'footer.php';
?>