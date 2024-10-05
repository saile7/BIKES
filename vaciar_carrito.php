<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vaciar el carrito
    unset($_SESSION['carrito']);
    // Devolver una respuesta
    echo "Carrito vacío.";
}
?>
