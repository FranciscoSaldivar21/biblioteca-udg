<div id="carrito" class="contenedor prueba">
    <div class="contenedor carrito">
        <p id="idPrestamo"></p>
        <div id="carro">

        </div>
        <div class="botones">
            <button id="boton-cerrar" class="boton rojo">Cerrar</button>
            <button onClick="finalizarPrestamo()" class="boton verde">Finalizar</button>
        </div>
    </div>
</div>

<script>
    const boton_carrito = document.getElementById("boton-carrito");
    boton_carrito.addEventListener('click', () => {
        console.log("Boton abrir");
        document.getElementById('carrito').classList.toggle('mostrar');
        console.log(carrito);
    })

    document.getElementById("boton-cerrar").addEventListener('click', () => {
        console.log("Boton cerrar");
        document.getElementById('carrito').classList.toggle('mostrar');
    })
</script>

<script>
    let carrito = [];
    var folio;
    var error = false;
    obtenerIdPrestamo();
    obtenerSancion();

    function obtenerSancion() {
        //Validar que no haya sanciones
        const http1 = new XMLHttpRequest();
        const url1 = '/back-end/sancion.php';

        http1.onreadystatechange = function() {
            //solicitud exitosa
            if (this.readyState == 4 && this.status == 200) {
                console.log("Respuesta" + this.responseText);
                if (this.responseText == true) {
                    error = true;
                }
            }
        }
        http1.open("POST", url1, true);
        http1.send();
    }

    if ("carrito" in localStorage) {
        carrito = JSON.parse(localStorage.getItem('carrito'));
    }


    class Libro {
        constructor(titulo, isbn, estado, imagen, id) {
            this.titulo = titulo;
            this.isbn = isbn;
            this.estado = estado;
            this.imagen = imagen;
            this.id = id;
        }

    }


    function getIdLibroDisponible(nombre, isbn, existencia, imagen, ruta) {
        const http = new XMLHttpRequest();
        let id = 0;
        const url = '/back-end/getIdDisponible.php';
        isbn = JSON.stringify(isbn);

        http.onreadystatechange = function() {
            //solicitud exitosa
            if (this.readyState == 4 && this.status == 200) {
                console.log("ID disponible: " + this.response);
                agregarCarrito(nombre, isbn, existencia, imagen, ruta, this.responseText)
            }
        }
        http.open("POST", url, true);
        http.send(isbn);
    }

    function agregarCarrito(nombre, isbn, existencia, imagen, ruta, idLibro) {
        //Llamar función para obtener libro disponible
        console.log("ISBN " + isbn);
        //Validar si el libro ya se agregó
        var id = carrito.filter(function(id) {
            return id.isbn === isbn;
        });

        if (id.length > 0) {
            alert("Ya agregaste ese libro al carrito");
            return;
        }

        const libro = new Libro(nombre, isbn, estado, imagen, idLibro);
        if (existencia <= 0) {
            alert("El libro no está disponible por el momento");
            return;
        } else {
            carrito.push(libro);
            localStorage.setItem('carrito', JSON.stringify(carrito))
            dibujarCarro();
        }
    }

    function obtenerIdPrestamo() {
        const http = new XMLHttpRequest();
        const url = '/back-end/idPrestamo.php';
        http.onreadystatechange = function() {
            //solicitud exitosa
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                folio = this.responseText;
                console.log(folio);
                aux = document.getElementById("idPrestamo");
                aux.innerHTML += `ID prestamo: ${folio}`;
                dibujarCarro();
            }
        }
        http.open("POST", url, true);
        http.send();
    }

    function dibujarCarro() {
        aux = document.getElementById("carro");
        aux.innerHTML = '';
        if (carrito.length < 1) {
            aux.innerHTML = '';
            return;
        }
        //////////////////////////////////////
        ruta = 'imagenesServer/';
        for (let libro of carrito) {
            aux.innerHTML += `
                <div class="elemento-carrito">
                    <div class="imagen-carrito">
                        <img href="#" alt="portada de libro" class="portada" src="${ruta}${libro.imagen}">
                    </div>
                    <div class="contenido-libro">
                        <p><span>Titulo: </span>${libro.titulo}</p>
                        <p><span>ISBN: </span>${libro.isbn}</p>
                        <div class="botones">
                            <a onClick="quitarLibro('${libro.id}')" title="Quitar libro" class="boton rojo">Quitar libro</a>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    function quitarLibro(id) {
        carrito = carrito.filter((item) => item.id != id);
        localStorage.setItem('carrito', JSON.stringify(carrito))
        dibujarCarro();
    }

    function finalizarPrestamo() {
        if (carrito.length == 0) {
            alert("Agrega elementos a la cesta");
            return;
        }

        if(error == true){
            alert("Usted tiene sanciones y no puede solicitar prestamos, arreglelas primero");
            return;
        }

        datos = '';
        const http = new XMLHttpRequest();
        const url = '/back-end/prestamo.php';
        datos = JSON.stringify(carrito);

        http.onreadystatechange = function() {
            //solicitud exitosa
            if (this.readyState == 4 && this.status == 200) {
                let idPrestamo = this.responseText;

                if (idPrestamo) {
                    window.location.href = "prestamo.php?id=" + idPrestamo;
                } else {
                    alert("Algo falló");
                }
            }
        }
        http.open("POST", url, true);
        http.send(datos);

        localStorage.removeItem("carrito");
        dibujarCarro();
        console.log("Finalizar prestamo");
    }
</script>