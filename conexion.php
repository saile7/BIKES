<?php
$servername = "localhost";
$username = "root";
$password = "mayu23";
$dbname = "tienda";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
//echo "Bienvenido";
?>