document.addEventListener("DOMContentLoaded", function() {
    const carruselInner = document.querySelector(".carrusel-inner");
    let index = 0;
    const items = document.querySelectorAll(".carrusel-item");
    const totalItems = items.length;
    const intervalTime = 3000; // Tiempo entre cambios (en ms)
    
    function moveToNextSlide() {
        index = (index + 1) % totalItems;
        const offset = -index * 100; // Moverse a la izquierda
        carruselInner.style.transform = `translateX(${offset}%)`;
    }
    
    setInterval(moveToNextSlide, intervalTime);
});
//setInterval(moveToNextSlide, intervalTime): Cambia la imagen del carrusel cada intervalTime milisegundos.
//moveToNextSlide(): Calcula el desplazamiento necesario y actualiza el estilo transform para mover el carrusel.

// Seleccionamos el elemento del dropdown
    const dropdown = document.querySelector('.dropdown');
    const dropdownContent = document.querySelector('.dropdown-content');

    // Agregamos eventos para mostrar y ocultar el menú
    dropdown.addEventListener('mouseover', function() {
        dropdownContent.style.display = 'flex'; // Mostrar el menú
    });

    dropdown.addEventListener('mouseout', function() {
        dropdownContent.style.display = 'none'; // Ocultar el menú
    });