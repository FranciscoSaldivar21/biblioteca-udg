<script>
    window.onload = ajax();

    function ajax() {
        const http = new XMLHttpRequest();
        const url = '/back-end/catalogo.php';

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
        ruta = 'imagenesServer/';
        catalogo = document.getElementById('catalogo');
        catalogo.innerHTML = '';
        let isbnAnterior = 0;

        for (let libro of data) {
            isbnAux = libro.isbn;

            //Esta linea hace que no se dibuje 2 veces el mismo libro
            if (isbnAnterior === isbnAux)
                continue;

            aux = data.filter((item) => item.isbn == isbnAux && item.estado == 1);
            let existencia = aux.length;

            clase = '';
            existencia > 0 ? clase = 'disponible' : clase = 'no-disponible';
            existencia > 0 ? estado = 'Disponible' : estado = 'No disponible';
            catalogo.innerHTML += `
                <div class="elemento">
                    <div class="imagen">
                        <img href="#" alt="portada de libro" class="portada" src="${ruta}${libro.imagen}">
                    </div>
                    <div class="contenido-libro">
                        <p><span>Titulo: </span>${libro.nombre}</p>
                        <p><span>ISBN: </span>${libro.isbn}</p>
                        <p><span>Autor(es): </span>${libro.autores}</p>
                        <p><span>Editorial: </span>${libro.editorial}</p>
                        <p><span>Edición: </span>${libro.edicion}</p>
                        <p><span>Existencia: </span>${aux.length}</p>
                        <p class="${clase}"><span>Estado: </span>${estado}</p>
                        <div class="botones">
                            <a onclick="getIdLibroDisponible('${libro.nombre}',${libro.isbn},'${existencia}','${libro.imagen}','${ruta}')" href="#"><img title="Añadir al prestamo actual" src="/imagenes/add_car.png"></a>
                            <a title="Ver detalle de libro" href="libro.php?isbn=${libro.isbn}&id=${libro.id}" class="boton verde">Ver libro</a>
                        </div>
                    </div>
                </div>
            `;
            isbnAnterior = libro.isbn;
        }
    }
</script>

<body>

    <?php if ($_SESSION['auth'] && $_SESSION['rol'] == 1) : ?>
        <div class="contenedor admin">
            <a class="boton verde" href="admin_insertarLibro.php">Agregar nuevo libro</a>
        </div>
    <?php endif; ?>
    <div class="contenedor busqueda">
        <label for="busqueda">Buscar </label><input id="buscar-libro" type="text" placeholder="Por titulo, ISBN o autor">
    </div>
    <div id="catalogo" class="contenedor catalogo">

    </div>
</body>

<script>
    document.getElementById("buscar-libro").addEventListener("keyup", function() {
        buscar = document.getElementById("buscar-libro").value;
        const http = new XMLHttpRequest();
        const url = '/back-end/buscarLibros.php';
        buscar = JSON.stringify(buscar);

        http.onreadystatechange = function() {
            //solicitud exitosa
            if (this.readyState == 4 && this.status == 200) {
                let data = JSON.parse(this.responseText);
                render(data);
            }
        }
        http.open("POST", url, true);
        http.send(buscar);
    });
</script>