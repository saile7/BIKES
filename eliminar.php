<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'conexion.php';

// Verifica si se ha enviado un ID para eliminar
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Asegúrate de que $id sea un número entero

    // Consulta para eliminar el producto
    $sql = "DELETE FROM product WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Redirige a la página de administración
        header("Location: admin.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No se ha proporcionado un ID para eliminar.";
}
?>
