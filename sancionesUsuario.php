<?php
include('header.php');
?>

<body>

    <div class="contenedor busqueda">
        <label for="busqueda">Buscar </label><input id="buscar-sancion" type="text" placeholder="Buscar...">
    </div>
    <?php if ($_SESSION['rol'] == 1) : ?>
        <div class="botones">
            <a href="registrarSancion.php" class="boton rojo">Nueva sanción</a>
            <a href="sanciones.php" class="boton verde">Tipos sanciones</a>
        </div>
    <?php endif; ?>
    <div id="sanciones" class="contenedor prestamos">

    </div>
</body>

<?php
include('footer.php');
?>

<script>
    document.getElementById("buscar-sancion").addEventListener("keyup", function() {
        buscar = document.getElementById("buscar-sancion").value;

        if (buscar == '') {
            ajax();
            return;
        }

        const http = new XMLHttpRequest();
        const url = '/back-end/buscarSancion.php';
        buscar = JSON.stringify(buscar);

        http.onreadystatechange = function() {
            //solicitud exitosa
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == false) {
                    return;
                }
                let data = JSON.parse(this.responseText);
                render(data);
            }
        }
        http.open("POST", url, true);
        http.send(buscar);
    });
</script>

<script>
    window.onload = ajax();

    function ajax() {
        const http = new XMLHttpRequest();
        const url = '/back-end/sancionesUsuarios.php';

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
        sanciones = document.getElementById('sanciones');
        sanciones.innerHTML = '';

        for (let sancion of data) {
            estado = '';
            if (sancion.estado == 0) {
                estado = 'Pendiente';
            } else if (sancion.estado == 1) {
                estado = 'Solucionada';
            }
            sanciones.innerHTML += `
                <div class="contenedor prestamo">
                    <p><span>ID sancion: </span>${sancion.id}</p>
                    <p><span>Codigo de usuario: </span>${sancion.codigo}</p>
                    <p><span>Nombre: </span>${sancion.nombre}</p>
                    <p><span>Fecha de sancion: </span>${sancion.fecha}</p>
                    <p><span>Estado: </span>${estado}</p>
                    <div class="botones">
                        <a  href="sancionUsuario.php?id=${sancion.id}">Ver detalle</a>
                    </div>
                </div>
            `;
        }
    }
</script>