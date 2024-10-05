<?php
session_start();
include 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Obtener la información del producto
$id = $_GET['id'];
$sql = "SELECT * FROM product WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    // Solo actualizar el precio anterior si el producto está en promoción
    if (isset($_POST['precio_anterior']) && !empty($_POST['precio_anterior'])) {
        $precio_anterior = $_POST['precio_anterior'];
    } else {
        $precio_anterior = null; // O el valor que desees asignar si no hay precio anterior
    }

    // Actualizar el nombre, precio y precio anterior
    $sql = "UPDATE product SET nombre = ?, precio = ?, precio_anterior = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdii", $nombre, $precio, $precio_anterior, $id);
    $stmt->execute();

    header("Location: adminpromociones.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto</h1>
   <form action="editar_producto.php?id=<?php echo $product['id']; ?>" method="POST">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $product['nombre']; ?>">
    
    <label for="precio">Precio:</label>
    <input type="text" name="precio" value="<?php echo $product['precio']; ?>">

    <!-- Nuevo campo para el precio anterior -->
    <label for="precio_anterior">Precio Anterior:</label>
    <input type="text" name="precio_anterior" value="<?php echo $product['precio_anterior']; ?>">

    <!-- Otros campos de edición -->
    <button type="submit">Guardar Cambios</button>
</form>

</body>
</html>
