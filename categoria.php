<?php
session_start();

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', 'mayu23', 'tienda');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Agregar producto al carrito
// Agregar producto al carrito
if (isset($_GET['id']) && isset($_GET['cantidad'])) {
    $id_producto = $_GET['id'];
    $cantidad = intval($_GET['cantidad']);
    
    // Verifica si el producto ya está en el carrito
    $producto_encontrado = false;
    foreach ($_SESSION['carrito'] as &$producto) {
        if ($producto['id'] == $id_producto) {
            $producto['cantidad'] += $cantidad; // Incrementa la cantidad
            $producto_encontrado = true;
            break;
        }
    }
    
    // Si el producto no está en el carrito, agrégalo con la cantidad seleccionada
    if (!$producto_encontrado) {
        $_SESSION['carrito'][] = array('id' => $id_producto, 'cantidad' => $cantidad);
    }

    // Redireccionar a la página de categoría con un mensaje de éxito
    header("Location: categoria.php?categoria=" . $_GET['categoria'] . "&exito=1");
    exit;
}

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;

// Verifica si se ha proporcionado un ID de producto específico
if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];
    $sql = "SELECT * FROM product WHERE categoria='$categoria' AND id='$id_producto'";
} else {
    // Muestra todos los productos de la categoría si no hay un ID específico
$sql = "SELECT * FROM product WHERE categoria='$categoria' ORDER BY nombre ASC";
}
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRBIKE</title>
    
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="productos.css">
        <!-- Agrega Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

</head>
<body>
 <?php
if (isset($_GET['exito']) && $_GET['exito'] == 1) {
    echo "<p class='mensaje-exito'>¡Producto agregado al carrito correctamente!</p>";
}
?>
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
 
        <h2>Productos - <?php echo ucfirst($categoria); ?></h2>
        <div class="contenido">
    <div id="mostrador" class="mostrador">
        <div class="fila">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='item' onclick='cargar(this)'>";
                    echo "<img src='uploads/" . $row['imagen'] . "' alt='" . $row['nombre'] . "'>";
                    echo "<p class='descripcion'>" . $row['nombre'] . "</p>";
                    echo "<span class='precio'>$" . $row['precio'] . "</span>";
                    echo "<input type='hidden' class='descripcion-larga' value='" . $row['descripcion'] . "'>";
                    echo "<form action='categoria.php' method='GET'>";
                    echo '<input type="hidden" name="categoria" value="' . $categoria . '">';
                    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay productos en esta categoría</p>";
            }
            
            ?>
        </div>
    </div>
    <div id="seleccion" class="seleccion">
        <span class="cerrar" onclick="cerrar()">X</span>
        <div class="info">
            <img id="img" src="" alt="">
            <h2 id="modelo"></h2>
            <p id="descripcion"></p>
            <span id="precio" class="precio"></span>
           <div class="formi"> 
          <form action='categoria.php' method='GET'>
    <label for="cantidad">Cantidad:</label>
    <input type='number' name='cantidad' value='1' min='1'>
    
    <!-- Mantener el valor de la categoría -->
    <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($categoria); ?>">
    
    <!-- Agregar el ID del producto para que puedas añadirlo al carrito -->
    <input type="hidden" name="id" id="producto_id" value="">
    
    <button type='submit'>Agregar al carrito</button>
</form>

            </div>
        </div>
    </div>
</div>

        
    </main>
    <script src="productos.js"></script>
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
