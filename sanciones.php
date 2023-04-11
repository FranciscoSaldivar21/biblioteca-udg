<?php
include 'header.php';
?>

<script>
    window.onload = ajax();

    function ajax() {
        const http = new XMLHttpRequest();
        const url = '/back-end/sanciones.php';

        http.onreadystatechange = function() {
            //solicitud exitosa
            if (this.readyState == 4 && this.status == 200) {
                let data = JSON.parse(this.responseText);
                render(data);
            }
        }
        http.open("GET", url);
        http.send();
    }

    function render(data) {
        let myTable = "<table><tr><th>ID</th>";
        myTable += "<th>Descripción</th>";
        myTable += "<th>Costo</th>";
        myTable += "<th>Accion</th></tr>";

        for (let sancion of data) {
            myTable += "<tr><td>" + sancion.id + "</td>";
            myTable += "<td>" + sancion.descripcion + "</td>";
            myTable += "<td>$" + sancion.costo + "</td>";
            myTable += "<td><a href=editaTipoSancion.php?id=" + sancion.id + ">Editar</a></td>";
            myTable += "</tr>";
        }

        myTable += "</table>";
        document.getElementById('sanciones').innerHTML = myTable;
    }
</script>

<body>
    <div class="contenedor sanciones" id="sanciones">
        <!--<a class="boton verde" href="tipoSancion.php">Ver sanciones</a>
        <a class="boton rojo" href="tipoSancion.php">Ver sanciones</a>-->
    </div>
    <div class="contenedor verSanciones">
        <a href="agregarSancion.php" class="boton rojo">Crear sanción</a>
    </div>
</body>

<?php
include 'footer.php';
?>