<?php
include 'header.php';
require 'back-end/conexion.php';
$db = conectarDB();

$query = "SELECT id FROM sanciones ORDER BY id DESC LIMIT 1";
$result = mysqli_query($db, $query);
$folio = 0;

while ($row = mysqli_fetch_array($result)) {
    $folio = intval($row['id']) + 1;
    break;
}

$query = "SELECT * FROM tiposancion";
$result2 = mysqli_query($db, $query);
$result1 = mysqli_query($db, $query);
?>

<script>
    function buscarPrestamo(prestamo) {
        const http = new XMLHttpRequest();
        const url = '/back-end/buscarPrestamoID.php';
        buscar = JSON.stringify(prestamo);

        http.onreadystatechange = function() {
            //solicitud exitosa
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                if (this.responseText == false) {
                    document.getElementById("alerta").style.display = "block";
                    document.getElementById("alerta").innerText = "No fue posible encontrar prestamo";
                    setTimeout(function() {
                        document.getElementById("alerta").style.display = "none";
                        document.getElementById('idPrestamo').value = '';
                    }, 3000);
                    document.getElementById("agregar-libro").style.display = "none";
                    document.getElementById('codigo').value = '';
                } else {
                    document.getElementById('codigo').value = this.responseText;
                    document.getElementById("agregar-libro").style.display = "block";
                    obtenerLibros(prestamo);
                }
            }
        }
        http.open("POST", url, true);
        http.send(buscar);
    }

    function obtenerLibros(prestamo) {
        const http = new XMLHttpRequest();
        const url = '/back-end/librosPrestamo.php';
        buscar = JSON.stringify(prestamo);

        http.onreadystatechange = function() {
            //solicitud exitosa
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == false) {
                    console.log("Algo ocurrio");
                    return;
                } else {
                    let data = JSON.parse(this.responseText);
                    var i = 0;
                    for (let libro of data) {
                        var x = document.getElementById("idLibro");
                        var option = document.createElement("option");
                        option.value = parseInt(data[i]);
                        option.text = parseInt(data[i]);
                        x.add(option);
                        i++;
                    }
                }
            }
        }
        http.open("POST", url, true);
        http.send(buscar);
    }
</script>

<body>
    <h1>Registro de sanción</h1>
    <div class="contenedor">
        <div class="contenedor">
            <p><span>Folio: </span><?php echo $folio; ?></p>
            <p id="fecha"><span>Fecha: </span></p>
        </div>
        <div class="contenedor" id="librosSancionados">

        </div>
        <form id="formulario" class="contenedor formulario">
            <label for="idPrestamo">ID prestamo </label><input onchange="buscarPrestamo(this.value);" id="prestamo" name="idPrestamo" type="number" placeholder="ID prestamo">
            <p class="alerta" id="alerta" style="display: none; color:red;"></p>
            <label for="codigo">Codigo </label><input name="codigo" id="codigo" type="text" readonly>
            <div id="agregar-libro" class="agregar-libro">
                <select name="idLibro" id="idLibro" onchange="buscarLibro(this.value);">
                    <option value=0 selected>--Seleccione libro--</option>
                </select><br>
                <label for="isbn">ISBN </label><input name="isbn" id="isbn" type="text" readonly>
                <label for="titulo">Titulo </label><input name="titulo" id="titulo" type="text" readonly>
                <select name="idTipoSancion" id="idTipoSancion">
                    <option value=0 selected>--Seleccione sanción--</option>
                    <?php while ($fila = mysqli_fetch_array($result2)) : ?>
                        <option value=" <?php echo intval($fila['id']); ?>"><?php echo $fila['descripcion']; ?></option>
                    <?php endwhile; ?>
                </select><br>
                <p class="alerta" id="alerta3" style="display: none; color:red;"></p>
                <a id="boton-agregar" class="boton verde ocultar" onclick="agregarLibro();">Agregar libro</a>
            </div>
            <a class="boton verde" onclick="insertaSancion();">Terminar</a>
        </form>
        <div class="contenedor ingresar">
            <a href="sancionesUsuario.php" class="boton rojo">Regresar</a>
        </div>
    </div>
    <?php
    include 'footer.php';
    ?>

    <script>
        fecha();
        //Arreglo de libros
        let libros2 = [];

        function agregarLibro() {
            idLibro = document.getElementById('idLibro').value;
            isbn = document.getElementById('isbn').value;
            idTipoSancion = document.getElementById('idTipoSancion').value;
            descripcion = document.getElementById('idTipoSancion').options[document.getElementById('idTipoSancion').selectedIndex].text;

            if (idLibro == '' || isbn == '' || idTipoSancion == 0) {
                document.getElementById("alerta3").style.display = "block";
                document.getElementById("alerta3").innerText = "Llene todos los campos";
                setTimeout(function() {
                    document.getElementById("alerta3").style.display = "none";
                }, 3000);
                return;
            }

            //Validar si el libro ya se agregó
            var id = libros2.filter(function(id) {
                return id.idLibro === idLibro;
            });


            if (id.length > 0) {
                alert("Ya agregaste ese libro");
                limpiarCampos();
                return;
            }

            //Extraer costo de sanción
            const http = new XMLHttpRequest();
            const url = '/back-end/costoSancion.php';
            buscar = JSON.stringify(idTipoSancion);

            http.onreadystatechange = function() {
                //solicitud exitosa
                if (this.readyState == 4 && this.status == 200) {
                    costo = parseInt(this.responseText);
                    const libro = new Libros(idLibro, isbn, idTipoSancion, descripcion, costo);
                    libros2.push(libro);
                    console.log(libros2);
                    limpiarCampos();
                    render();
                }
            }
            http.open("POST", url, true);
            http.send(buscar);
        }

        function fecha() {
            date = new Date();
            year = date.getFullYear();
            month = date.getMonth() + 1;
            day = date.getDate();
            document.getElementById("fecha").innerHTML += day + "/" + month + "/" + year;
        }



        class Libros {
            constructor(idLibro, isbn, idTipoSancion, descripcion, costo) {
                this.idLibro = idLibro;
                this.isbn = isbn;
                this.idTipoSancion = idTipoSancion;
                this.descripcion = descripcion;
                this.costo = costo;
            }
        }

        function buscarLibro(idLibro) {
            const http = new XMLHttpRequest();
            const url = '/back-end/buscarLibro.php';
            buscar = JSON.stringify(idLibro);

            http.onreadystatechange = function() {
                //solicitud exitosa
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == false) {
                        document.getElementById("alerta2").style.display = "block";
                        document.getElementById("alerta2").innerText = "No se encontró el libro";
                        setTimeout(function() {
                            document.getElementById("alerta2").style.display = "none";
                            document.getElementById('idLibro').value = '';
                        }, 3000);
                        document.getElementById("boton-agregar").style.display = "none";
                    } else {
                        document.getElementById("boton-agregar").style.display = "block";
                        let data = JSON.parse(this.responseText);
                        for (let libro of data) {
                            document.getElementById('isbn').value = libro.isbn;
                            document.getElementById('idLibro').value = libro.id;
                            document.getElementById('titulo').value = libro.nombre;
                        }
                    }
                }
            }
            http.open("POST", url, true);
            http.send(buscar);
        }


        function limpiarCampos() {
            document.getElementById('idLibro').value = '';
            document.getElementById('isbn').value = '';
            document.getElementById('titulo').value = '';
            document.getElementById('idTipoSancion').value = 0;
        }

        function render() {
            librosSancionados = document.getElementById("librosSancionados");
            librosSancionados.innerHTML = "";
            let costo = 0;
            for (let libro of libros2) {
                costo += libro.costo;
                librosSancionados.innerHTML += `
                <div class="libro-sancionado">
                    <p><span>ID libro: </span>${libro.idLibro}</p>
                    <p><span>ISBN: </span>${libro.isbn}</p>
                    <p><span>ID sanción: </span>${libro.idTipoSancion}</p>
                    <p><span>Descripcion: </span>${libro.descripcion}</p>
                    <p><span>Costo: </span>${libro.costo}</p>
                    <a onclick="quitarElemento(${libro.idLibro});">Quitar</a>
                </div>
            `;
            }
            librosSancionados.innerHTML += `<p>Total: ${costo}</p>`;
        }

        function quitarElemento(id) {
            console.log("Entré");
            libros2 = libros2.filter((item) => item.idLibro != id);
            render();
        }

        function insertaSancion() {
            if (libros2.length <= 0) {
                alert("Agrega elementos");
                return;
            }
            codigo = document.getElementById('codigo').value;
            prestamo = document.getElementById('prestamo').value;

            const http = new XMLHttpRequest();
            const url2 = "/back-end/insertaSancion.php?codigo=" + codigo + "&prestamo=" + prestamo;
            datos = JSON.stringify(libros2);

            http.onreadystatechange = function() {
                //solicitud exitosa
                if (this.readyState == 4 && this.status == 200) {
                    let idSancion = this.responseText;

                    if (idSancion) {
                        console.log(idSancion);
                        window.location.href = "sancionUsuario.php?id=" + idSancion;
                    } else {
                        alert("Algo falló");
                    }
                }
            }
            http.open("POST", url2, true);
            http.send(datos);
        }
    </script>