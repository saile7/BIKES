<?php
session_start();
include 'conexion.php';

// Eliminar un producto del carrito si se ha solicitado
if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $key => $producto) {
            if ($producto['id'] == $id_producto) {
                unset($_SESSION['carrito'][$key]);
                break;
            }
        }
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Re-indexar el array
    }
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) === 0) {
    echo "El carrito está vacío.";
    exit;
}

// Extraer los IDs de los productos en el carrito
$ids = array_column($_SESSION['carrito'], 'id');

// Verificar que hay IDs antes de proceder
if (count($ids) === 0) {
    echo "El carrito está vacío.";
    exit;
}


$productos = implode(",", $ids);
$sql = "SELECT * FROM product WHERE id IN ($productos)";
$result = $conn->query($sql);

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRBIKE</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="productos.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<header>
     <h1>DR.BIKES</h1>
   	<nav>
  		  <ul>
        <li><a href="index.php">Inicio</a></li>
        <li class="has-submenu"><a href="#">Bicicletas</a>
            <ul class="submenu">
                <li>
                    <a href="categoria.php?categoria=MTB">MTB</a>
                </li>
                <li>
                    <a href="categoria.php?categoria=Ruta">RUTA</a>
                </li>
            </ul>
        </li>
        <li class="dropdown">
        <a href="#" class="dropbtn">Productos</a>
        <div class="dropdown-content">
            <div class="dropdown-section">
                <h3>Productos Locales</h3>
                <ul>
                    <li>
                    <a href="categoria.php?categoria=Loc.Bottom_Bracket">Bottom Bracket</a> 
                    <a href="categoria.php?categoria=Loc.Cadenilla" >Cadenilla</a>
                    <a href="categoria.php?categoria=Loc.Descarrilador" >Descarrilador</a>
                    <a href="categoria.php?categoria=Loc.Catalina" >Catalina</a>
                    <a href="categoria.php?categoria=Loc.Discos" >Discos</a>
                    <a href="categoria.php?categoria=Loc.Manzanas" >Manzanas</a>
                    <a href="categoria.php?categoria=Loc.Mordazas" >Mordazas</a>
                    <a href="categoria.php?categoria=Loc.Frenos_Discos" >Frenos de discos</a>
                    <a href="categoria.php?categoria=Loc.Platos" >Platos</a>
                    <a href="categoria.php?categoria=Loc.Shifter" >Shifter</a>
                    <a href="#" >Mas..</a>
                    </li>
                    <!-- Más elementos de repuestos -->
                    <ul><li></li></ul>
                </ul>
                
            </div>
            <div class="dropdown-section">
                <h3>Productos Importados</h3>
                <ul>
                    <li><a href="categoria.php?categoria=Imp.Aros">Aros</a>
                    		<a href="categoria.php?categoria=Imp.Ruedas">Ruedas</a>
                    		<a href="categoria.php?categoria=Imp.Suspenciones">Suspenciones</a>
                    		<a href="categoria.php?categoria=Imp.Catalina" >Catalina</a>
                    		<a href="categoria.php?categoria=Imp.Discos" >Discos</a>
                   		<a href="categoria.php?categoria=Imp.Manzanas" >Manzanas</a>
                    		<a href="categoria.php?categoria=Imp.Mordazas" >Mordazas</a>
                    		 <a href="categoria.php?categoria=Imp.Shifter" >Shifter</a>
                    		<a href="categoria.php?categoria=Imp.Frenos" >Frenos</a>
                    		<a href="categoria.php?categoria=Imp.Stem" >Stem</a>
                    		<a href="categoria.php?categoria=Imp.Pinones" >Piñones</a>
                    		<a href="categoria.php?categoria=Imp.Tensor" >Tensores</a>
                    		<a href="categoria.php?categoria=Imp.Guantes" >Guantes</a>
                    		<a href="categoria.php?categoria=Imp.Cascos" >Cascos</a>
                    		<a href="categoria.php?categoria=Imp.Bolsos" >Bolsos</a>
                    		<a href="categoria.php?categoria=Imp.Herramientas" >Herramientas</a>
                    		<a href="categoria.php?categoria=Imp.Velocimetro" >Velocimetro</a>
                    		<a href="categoria.php?categoria=Imp.Caramañolas" >Caramañolas</a>
                    		<a href="categoria.php?categoria=Imp.Luces" >Luces</a>
                    		<a href="#" >Mas..</a>
                    		
                    </li>
                    <!-- Más elementos de accesorios -->
                </ul>
            </div>
            <div class="dropdown-section">
                <h3>Grupo Shimano</h3>
                <ul>
                    <li><a href="categoria.php?categoria=Shimano_105">105</a>
                    		<a href="categoria.php?categoria=Shimano_XTR">XTR</a>
                    		<a href="categoria.php?categoria=Shimano_XT">XT</a>
                    		<a href="categoria.php?categoria=Shimano_SLX" >SLX</a>
                    		<a href="categoria.php?categoria=Shimano_Deore" >Deore</a>
                    		<a href="categoria.php?categoria=Shimano_Claris" >Claris</a>
                    		<a href="categoria.php?categoria=Shimano_Cues" >Cues</a>
                    		<a href="categoria.php?categoria=Shimano_Alivio" >Alivio</a>
                    		<a href="categoria.php?categoria=Shimano_Tiagra" >Tiagra</a>
                    </li>
                    <!-- Más elementos de grupos Shimano -->
                </ul>
            </div>
            
            <div class="dropdown-section">
                <h3>&nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Gafas</h3>
                <ul>
                    <li><a href="categoria.php?categoria=Fotocromaticas">Fotocromaticas</a>
                    		<a href="categoria.php?categoria=Polarizadas">Polarizadas</a>
                    </li>
                    <!-- Más elementos de grupos Shimano -->
                </ul>
            </div>
        </div>
    </li>
        <li><a href="serviciotecnico.php">Servicio Tecnico</a></li>
        <li><a href="contactanos.php">Contactanos</a></li>
         <li><a href="nosotros.php">Nosotros</a></li>
    </ul>
</nav>
        <form action="buscar.php" method="GET" class="form-busqueda">
        <input type="search" name="query" placeholder="¿Qué deseas buscar?" required class="busqueda-input">
        <button type="submit" id="search-button" class="busqueda-boton">Buscar</button>
    </form>
      
         <div class="cart-icon">
    <a href="carrito.php">
        <i class="fas fa-shopping-cart cart-icon"></i>
        <span class="cart-count"><?php echo count($_SESSION['carrito']); ?></span>
    </a>
</div>
</header>
<main>
    <div class="product-grid">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                foreach ($_SESSION['carrito'] as $producto) {
                    if ($producto['id'] == $row['id']) {
                        $subtotal = $row['precio'] * $producto['cantidad'];
                        $total += $subtotal;

                        echo "<div class='product-item'>";
                        echo "<img src='uploads/" . $row['imagen'] . "' alt='" . $row['nombre'] . "'>";
                        echo "<h2>" . $row['nombre'] . "</h2>";
                        echo "<p>" . $row['descripcion'] . "</p>";
                        echo "<p>Precio: $" . $row['precio'] . " x " . $producto['cantidad'] . " = $" . $subtotal . "</p>";
                        echo "<a href='carrito.php?id=" . $row['id'] . "'> <button>Eliminar</button></a>"; // Cambiado el enlace
                        echo "</div>";
                    }
                }
            }
            
            
        } else {
            echo "No se encontraron productos.";
        }
        ?>
    </div>

    <?php
    // Generar el mensaje para WhatsApp
    $mensaje = "¡Hola! Quiero hacer un pedido:\n";
    foreach ($_SESSION['carrito'] as $producto) {
        $sql = "SELECT nombre, precio FROM product WHERE id = " . $producto['id'];
        $result = $conn->query($sql);
        $producto_info = $result->fetch_assoc();
        $mensaje .= $producto_info['nombre'] . " - $" . $producto_info['precio'] . " x " . $producto['cantidad'] . "\n";
    }
    $mensaje .= "Total: $" . $total;

    $mensaje = urlencode($mensaje);
    $whatsapp_number = "593098714032"; // Reemplaza con el número de WhatsApp
    ?>
    <?php 
		echo "<h3>Total: $" . $total . "</h3>";    
    ?>
    <!-- Botón para enviar el pedido por WhatsApp -->
    <div class='product-it'>
        <a href="https://wa.me/<?php echo $whatsapp_number; ?>?text=<?php echo $mensaje; ?>" target="_blank">
            <button class="envio">Enviar Pedido por WhatsApp</button></a>
    <!-- Botón para vaciar el carrito -->
    <button id="vaciar-carrito" class="btn-vaciar">Vaciar Carrito</button>

    </div> 
		
   
</main>
<script src="script.js"> </script>
</body>
<footer class="footer">
     <div class="container">
      <div class="row">
        <div class="footer-col">
          <h4>company</h4>
          <ul>
            <li><a href="#">about us</a></li>
            <li><a href="login.php">login</a></li>
            <li><a href="#">privacy policy</a></li>
            <li><a href="#">affiliate program</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>get help</h4>
          <ul>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">shipping</a></li>
            <li><a href="#">returns</a></li>
            <li><a href="#">order status</a></li>
            <li><a href="#">payment options</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Horario de Atención</h4>
          <ul>
            <li><a href="#">Lunes: 8am-19pm</a></li>
            <li><a href="#">Martes: 8am-19pm</a></li>
            <li><a href="#">Miercoles: 8am-19pm</a></li>
            <li><a href="#">Jueves: 8am-19pm</a></li>
            <li><a href="#">Viernes: 8am-19pm</a></li>
            <li><a href="#">Sabado: 8am-14pm</a></li>
            
          </ul>
        </div>
        <div class="footer-col">
          <h4>Redes Sociales</h4>
          <div class="social-links">
            <a href="https://www.facebook.com/Dr.Bikesuio"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/dr._bikes/"><i class="fab fa-instagram"></i></a>
            <a href="https://wa.me/0987314032"><i class="fab fa-whatsapp"></i></a>
            <a href="https://www.tiktok.com/@_dr.bikes"><i class="fab fa-tiktok"></i></a>
          </div>
        </div>
      </div>
     </div>
</footer>
</html>


