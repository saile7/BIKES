<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'conexion.php';

// Verifica si se ha enviado un ID para edición
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']); // Asegúrate de que $id sea un número entero
    
    // Consulta para obtener los detalles del producto
    $result = $conn->query("SELECT * FROM product WHERE id=$id");
    
    // Verifica si el producto existe
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Producto no encontrado";
        exit;
    }
}

// Maneja el formulario de actualización del producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = intval($_POST['id']); // Asegúrate de que $id sea un número entero
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $imagen = $_POST['imagen_actual'];

    // Maneja la subida de una nueva imagen
    if ($_FILES['imagen']['name']) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verifica si el archivo es una imagen real
        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                $imagen = $target_file;
            } else {
                echo "Lo siento, hubo un error al subir tu archivo.";
            }
        } else {
            echo "El archivo no es una imagen.";
        }
    }

    // Actualiza los detalles del producto en la base de datos
    $sql = "UPDATE product SET nombre='$nombre', descripcion='$descripcion', precio='$precio', categoria='$categoria', imagen='$imagen' WHERE id=$id";
    
    // Debug: Ver la consulta SQL antes de ejecutarla
    //echo $sql; exit;
    
    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
        exit; // Añadir exit después de la redirección
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header>
        <h1>Editar Producto</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="admin.php">Administrar Productos</a></li>
            </ul>
        </nav>
        <div class="user-options">
            <a href="logout.php">Cerrar Sesión</a>
        </div>
    </header>
    <main>
        <!-- Formulario de edición de producto -->
        <form action="edit.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo isset($product['id']) ? $product['id'] : ''; ?>">
            <h2>Editar Producto</h2>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo isset($product['nombre']) ? $product['nombre'] : ''; ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required><?php echo isset($product['descripcion']) ? $product['descripcion'] : ''; ?></textarea>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" value="<?php echo isset($product['precio']) ? $product['precio'] : ''; ?>" required>

            <label for="categoria">Categoría:</label>
            <input type="text" id="categoria" name="categoria" value="<?php echo isset($product['categoria']) ? $product['categoria'] : ''; ?>" required>

            <label for="imagen">Imagen actual:</label>
            <input type="hidden" name="imagen_actual" value="<?php echo isset($product['imagen']) ? $product['imagen'] : ''; ?>">
            <?php if (isset($product['imagen'])): ?>
                <img src="<?php echo $product['imagen']; ?>" alt="<?php echo $product['nombre']; ?>" width="100"><br>
            <?php endif; ?>

            <label for="imagen">Nueva Imagen (opcional):</label>
            <input type="file" id="imagen" name="imagen" accept="image/*">

            <input type="submit" name="update" value="Actualizar Producto">
        </form>
    </main>
</body>
</html>
