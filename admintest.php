<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
include 'conexion.php';

// Imprimir el contenido de $_POST y $_FILES para depurar
//echo "<pre>";
//print_r($_POST);
//print_r($_FILES);
//echo "</pre>";

// Verificar si el formulario fue enviado y si los datos están presentes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verificar si el campo nombre_cliente existe en el POST y no está vacío
    if (isset($_POST['nombre_cliente']) && !empty($_POST['nombre_cliente'])) {
        $nombre_cliente = $_POST['nombre_cliente'];
    } else {
        die("Error: El campo 'nombre_cliente' es obligatorio.");
    }

    // Verificar si el archivo de video fue subido correctamente
    if (isset($_FILES['video']) && $_FILES['video']['error'] === 0) {
        $ruta_video = "videos_testimonios/" . basename($_FILES["video"]["name"]);

        // Mover el archivo solo si no hay errores
        if (move_uploaded_file($_FILES['video']['tmp_name'], $ruta_video)) {
            echo "El video se ha subido correctamente.";
        } else {
            die("Error al mover el archivo.");
        }
    } else {
        die("Error en la subida del archivo: " . $_FILES['video']['error']);
    }

    // Verificar si el campo comentario existe (es opcional)
    $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : "";

    // Consulta SQL para insertar el testimonio en la base de datos
    $sql = "INSERT INTO testimonios (nombre_cliente, ruta_video, comentario) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre_cliente, $ruta_video, $comentario);

    if ($stmt->execute()) {
        echo "Testimonio subido con éxito.";
    } else {
        echo "Error al subir el testimonio: " . $stmt->error;
    }
}


// Eliminar video si se proporciona la opción delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM testimonios WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: admintest.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Testimonios</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <ul>
                <li><a href="carrusel.php">Gestionar Carrusel</a></li>
                <li><a href="admin.php">Gestionar Productos</a></li>
                <li><a href="adminpromociones.php">Gestionar Promociones</a></li>
                <li><a href="admintest.php">Testimonios</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <a href="logout.php">Cerrar Sesión</a>
        </div>
    </header>
    <main>
    <div>
        <h2>Subir Testimonio</h2>
        <form action="admintest.php" method="POST" enctype="multipart/form-data">
            <label for="nombre_cliente">Nombre del cliente:</label>
            <input type="text" name="nombre_cliente" required>

            <label for="video">Subir video:</label>
            <input type="file" name="video" accept="video/*" required>

            <label for="comentario">Comentario:</label>
            <textarea name="comentario"></textarea>

            <button type="submit">Subir Testimonio</button>
        </form>

        <h2>Videos Testimonios</h2>
        <table>
            <?php
            // Mostrar testimonios
            $sql = "SELECT id, nombre_cliente, ruta_video, comentario FROM testimonios WHERE estado = 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='testimonio'>";
                    
                    echo "<h4>" . $row['nombre_cliente'] . "</h4>";
                    echo "<video width='320' height='240' controls>
                            <source src='" . $row['ruta_video'] . "' type='video/mp4'>
                            Tu navegador no soporta la reproducción de este video.
                          </video>";
                    echo "<a href='admintest.php?delete=" . $row['id'] . "' onclick=\"return confirm('¿Estás seguro de que quieres eliminar el video?');\">Eliminar</a>";
                    if (!empty($row['comentario'])) {
                        echo "<p>" . $row['comentario'] . "</p>";
                    }
                    echo "</div>";
                }
            } else {
                echo "No hay testimonios disponibles.";
            }
            ?>
        </table>
    </div>
    </main>
</body>
</html>
