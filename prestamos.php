<?php
include('header.php');
?>

<body>

    <div class="contenedor busqueda">
        <label for="busqueda">Buscar </label><input id="buscar-prestamo" type="text" placeholder="Buscar...">
    </div>
    <div id="prestamos" class="contenedor prestamos">

    </div>
</body>

<?php
include('footer.php');
?>

<script>
    document.getElementById("buscar-prestamo").addEventListener("keyup", function() {
        buscar = document.getElementById("buscar-prestamo").value;

        if (buscar == '') {
            ajax();
            return;
        }

        const http = new XMLHttpRequest();
        const url = '/back-end/buscarPrestamo.php';
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
        const url = '/back-end/prestamos.php';

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
        prestamos = document.getElementById('prestamos');
        prestamos.innerHTML = '';

        for (let prestamo of data) {
            estado = '';
            if (prestamo.estado == 0) {
                estado = 'Preparando';
            } else if (prestamo.estado == 1) {
                estado = 'En espera a ser recogido';
            } else if (prestamo.estado == 2) {
                estado = 'En proceso';
            } else if (prestamo.estado == 3) {
                estado = 'Terminado';
            }
            prestamos.innerHTML += `
                <div class="contenedor prestamo">
                    <p><span>ID prestamo: </span>${prestamo.id}</p>
                    <p><span>Codigo de academico: </span>${prestamo.codigo}</p>
                    <p><span>Nombre: </span>${prestamo.nombre}</p>
                    <p><span>Fecha de pedido: </span>${prestamo.fecha}</p>
                    <p><span>Fecha para devolver: </span>${prestamo.fechaDevolucion}</p>
                    <p><span>Estado: </span>${estado}</p>
                    <div class="botones">
                        <a  href="prestamo.php?id=${prestamo.id}">Ver detalle</a>
                    </div>
                </div>
            `;
        }
    }
</script>