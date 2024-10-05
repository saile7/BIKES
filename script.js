
document.getElementById('vaciar-carrito').addEventListener('click', function() {
    if (confirm('¿Estás seguro de que quieres vaciar el carrito?')) {
        fetch('vaciar_carrito.php', {
            method: 'POST'
        })
        .then(response => response.text())
        .then(data => {
            window.location.href = 'index.php'; // Recargar la página para reflejar los cambios
        })
        .catch(error => console.error('Error:', error));
    }
});

