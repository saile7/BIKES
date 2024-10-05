<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'conexion.php';
// Si se ha enviado el formulario para actualizar una promoción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_POST['promocion'])) {
        $id = $_POST['id'];
        $promocion = $_POST['promocion'] ? 1 : 0;

        $sql = "UPDATE product SET promocion = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $promocion, $id);
        $stmt->execute();
    }
}

// Obtener todos los productos
$sql = "SELECT * FROM product";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos</title>
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
                <li><a href="admintest.php">testimonios</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <a href="logout.php">Cerrar Sesión</a>
        </div>
    </header>
<body>
    <h1>Administrar Promociones</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Promoción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
            	 <td><?php echo "<img src='uploads/" . $row['imagen'] . "' alt='" . $row['nombre'] . "'>"; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td>$<?php echo $row['precio']; ?></td>
                <td>
                    <form action="adminpromociones.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <input type="checkbox" name="promocion" value="1" <?php echo $row['promocion'] ? 'checked' : ''; ?>>
    
    <!-- Mostrar el precio anterior solo si está en promoción -->
    <?php if ($row['promocion']): ?>
        <label for="precio_anterior">Precio Anterior:</label>
        <input type="number" name="precio_anterior" step="0.01" value="<?php echo $row['precio_anterior']; ?>">
    <?php endif; ?>
    
    <button type="submit">Actualizar</button>
</form>

                </td>
                <td>
                    <a href="editar_producto.php?id=<?php echo $row['id']; ?>">Editar</a> |
                    <a href="eliminar_producto.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
