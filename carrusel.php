<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'conexion.php';

// Agregar nuevo carrusel
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_FILES['imagen']['name'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($imagen);

    if (move_uploaded_file($imagen_tmp, $target_file)) {
        $sql = "INSERT INTO carrusel (titulo, descripcion, imagen) VALUES ('$titulo', '$descripcion', '$imagen')";
        if ($conn->query($sql) === TRUE) {
            echo "Imagen agregada exitosamente";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error al subir la imagen";
    }
}

// Eliminar imagen del carrusel
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM carrusel WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: carrusel.php");
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
    <title>Gestionar Carrusel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <ul>
                <li><a href="carrusel.php">Gestionar Carrusel</a></li>
                <li><a href="admin.php">Gestionar Productos</a></li>
                <li><a href="adminpromociones.php">Gestionar Promociones</a></li>
                <li><a href="admintest.php">testimonios</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <a href="logout.php">Cerrar Sesión</a>
        </div>
    </header>
    <main>
    <div>
        <!-- Formulario para agregar imágenes al carrusel -->
        <form action="carrusel.php" method="post" enctype="multipart/form-data">
            <h2>Agregar Imagen al Carrusel</h2>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*" required>

            <input type="submit" name="add" value="Agregar Imagen">
        </form>

        <!-- Mostrar lista de imágenes del carrusel -->
        <h2>Imágenes del Carrusel</h2>
        <table>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
            <?php
            $sql = "SELECT * FROM carrusel";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['titulo'] . "</td>";
                    echo "<td>" . $row['descripcion'] . "</td>";
                    echo "<td><img src='uploads/" . $row['imagen'] . "' alt='" . $row['titulo'] . "' width='100'></td>";
                    echo "<td><a href='carrusel.php?delete=" . $row['id'] . "' onclick=\"return confirm('¿Estás seguro de que quieres eliminar esta imagen?');\">Eliminar</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay imágenes en el carrusel</td></tr>";
            }

            $conn->close();
            ?>
        </table>
        </div>
         
        
    </main>
      <script src="carrusel.js"></script>
</body>
</html>
