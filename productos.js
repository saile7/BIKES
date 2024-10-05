let mostrador = document.getElementById("mostrador");
let seleccion = document.getElementById("seleccion");
let imgSeleccionada = document.getElementById("img");
let modeloSeleccionado = document.getElementById("modelo");
let descripSeleccionada = document.getElementById("descripcion");
let precioSeleccionado = document.getElementById("precio");

// Nuevo: Campo oculto del ID del producto en el formulario del modal
let productoIdSeleccionado = document.getElementById("producto_id");

function cargar(item) {
    quitarBordes();
    mostrador.style.width = "60%";
    seleccion.style.width = "40%";
    seleccion.style.opacity = "1";
    item.style.border = "2px solid red";

    // Actualizar la información visual
    imgSeleccionada.src = item.getElementsByTagName("img")[0].src;
    modeloSeleccionado.innerHTML = item.getElementsByTagName("p")[0].innerHTML;
    descripSeleccionada.innerHTML = item.getElementsByClassName("descripcion-larga")[0].value;
    precioSeleccionado.innerHTML = item.getElementsByTagName("span")[0].innerHTML;

    // Nuevo: Actualizar el ID del producto en el campo oculto del formulario
    productoIdSeleccionado.value = item.querySelector('input[name="id"]').value;
}

function cerrar() {
    mostrador.style.width = "100%";
    seleccion.style.width = "0%";
    seleccion.style.opacity = "0";
    quitarBordes();
}

function quitarBordes() {
    var items = document.getElementsByClassName("item");
    for (i = 0; i < items.length; i++) {
        items[i].style.border = "none";
    }
}
