<?php
session_start();
include 'conexion.php';  // Asegúrate de que se conecta a la base de datos

// Verifica si se ha enviado el formulario con el producto y cantidad
if (isset($_POST['id']) && isset($_POST['cantidad'])) {
    $id = $_POST['id'];
    $cantidad = $_POST['cantidad'];

    // Obtener la información del producto desde la base de datos
    $sql = "SELECT * FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        // Preparar el producto para agregarlo al carrito
        $item = array(
            'id' => $product['id'],
            'nombre' => $product['nombre'],
            'precio' => $product['precio'],
            'cantidad' => $cantidad,
            'imagen' => $product['imagen']
        );

        // Verifica si el carrito ya está en la sesión
        if (isset($_SESSION['carrito'])) {
            $carrito = $_SESSION['carrito'];
        } else {
            $carrito = array();
        }

        // Si el producto ya está en el carrito, aumentar la cantidad
        $encontrado = false;
        foreach ($carrito as &$itemCarrito) {
            if ($itemCarrito['id'] == $id) {
                $itemCarrito['cantidad'] += $cantidad;
                $encontrado = true;
                break;
            }
        }

        // Si no se encuentra el producto, agregarlo al carrito
        if (!$encontrado) {
            $carrito[] = $item;
        }

        // Guardar el carrito en la sesión
        $_SESSION['carrito'] = $carrito;
    }
}

// Redirigir a la página anterior o al carrito
header("Location: carrito.php");
exit();
?>
