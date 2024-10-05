<?php session_start();

if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];
    
    foreach ($_SESSION['carrito'] as $key => $producto) {
        if ($producto['id'] == $id_producto) {
            unset($_SESSION['carrito'][$key]);
            break;
        }
    }
    
    $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Re-indexar el array
    header("Location: index.php");
    exit();
}
?>
