<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el comentario y validarlo
    $comentario = $_POST['comentario'];

    if (!empty($comentario)) {
        // Guardar el comentario en la base de datos
        $sql = "INSERT INTO comentarios (comentario) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $comentario);
        $stmt->execute();
    }

    // Redirigir de nuevo a la página de comentarios
    header('Location: test.php');
    exit();
}
?>
