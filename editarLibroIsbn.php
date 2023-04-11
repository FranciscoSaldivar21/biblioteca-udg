<?php
include 'header.php';
include 'back-end/conexion.php';
$db = conectarDB();


$isbn = intval($_GET['isbn']);

$query = "SELECT id FROM libro INNER JOIN librosisbn ON libro.isbn = librosisbn.isbn WHERE libro.isbn = ${isbn}";
$result = mysqli_query($db, $query);

$query = "SELECT * FROM libro WHERE isbn = ${isbn}";
$result2 = mysqli_query($db, $query);
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("formulario").addEventListener('submit', validarFormulario);
    });

    function validarFormulario(evento) {
        evento.preventDefault();
        var idLibro = document.getElementById('idLibro').value;
        var pasillo = document.getElementById('pasillo').value;
        var estante = document.getElementById('estante').value;
        var estado = document.getElementById('estado').value;

        if (idLibro == 0) {
            document.getElementById("alerta").style.display = "block";
            document.getElementById("alerta").innerText = "Seleccione un ID";
            setTimeout(function() {
                document.getElementById("alerta").style.display = "none";
            }, 5000);
            return;
        }
        if (pasillo == 0 || estante == 0 || estado == "0") {
            document.getElementById("alerta").style.display = "block";
            document.getElementById("alerta").innerText = "Llene todos los campos";
            setTimeout(function() {
                document.getElementById("alerta").style.display = "none";
            }, 5000);
            return;
        } else {
            console.log("Entré");
            this.submit();
        }
    }

    function obtenerDatos() {
        //Obtener ID para mostrar datos
        id = document.getElementById('idLibro').value;
        if (id == 0) {
            document.getElementById("libroIsbn").style.display = "none";
            return;
        }
        //Consultar en BDD
        const http = new XMLHttpRequest();
        const url = '/back-end/libroIsbn.php';
        buscar = JSON.stringify(id);

        http.onreadystatechange = function() {
            //solicitud exitosa
            if (this.readyState == 4 && this.status == 200) {
                let data = JSON.parse(this.responseText);
                dibujarCampos(data);
            }
        }
        http.open("POST", url, true);
        http.send(buscar);
    }

    function dibujarCampos(data) {
        document.getElementById("libroIsbn").style.display = "block";
        for (let row of data) {
            var pasillo = document.getElementById("pasillo");
            pasillo.value = row.pasillo;
            var estante = document.getElementById("estante");
            estante.value = row.estante;
            break;
        }
    }
</script>

<body>
    <div class="contenedor">
        <p class="alerta" id="alerta" style="display: none; color:red;"></p>
    </div>
    <form type='POST' id="formulario" class="contenedor formulario usuario" action="back-end/actualizaLibroIsbn.php">
        <?php while ($fila = mysqli_fetch_array($result2)) : ?>
            <label for="isbn">ISBN </label><input value="<?php echo $fila['isbn']; ?>" name="isbn" id="isbn" type="text" readonly>
            <label for="titulo">Titulo </label><input value="<?php echo $fila['nombre']; ?>" name="titulo" id="titulo" type="text" readonly>
        <?php endwhile; ?>

        <label for="idLibro">Selecciona un libro para modificar:</label>
        <select name="idLibro" id="idLibro" onchange="obtenerDatos();">
            <option value=0 selected>--Seleccione ID--</option>
            <?php while ($row = mysqli_fetch_array($result)) :
                $i = 0;
            ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></option>
            <?php
                $i++;
            endwhile;
            ?>
        </select><br>
        <div class="libroIsbn" id="libroIsbn">
            <label>Pasillo<input type="number" id="pasillo" name="pasillo"></label>
            <label>Estante<input type="number" id="estante" name="estante"></label>
            <label for="estado">Choose a car:</label>
            <select name="estado" id="estado">
                <option value="0">--Seleccione estado--</option>
                <option value="1">Disponible</option>
                <option value="2">No disponible</option>
            </select>
        </div>
        <input type="submit" class="boton verde" id="guardar" value="Guardar">
    </form>
    <div class="contenedor ingresar">
        <a href="libro.php?isbn=<?php echo $isbn; ?>" class="boton azul">Regresar</a>
    </div>
    <?php
    include 'footer.php';
    ?>