<?php
session_start();
include 'conexion.php';

$error = ""; // Variable para almacenar el mensaje de error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['rol'] = $user['rol'];

            if ($user['rol'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DR.BIKES</title>
    <link rel="stylesheet" href="logi.css">
    <link rel="stylesheet" href="ci-icon/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <form method="post" action="login.php" class="form">
            <h1 class="title">Inicio</h1>
             <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
            <div class="inp">
                
        <input type="text" id="username" name="username" class="input" required placeholder="Usuario:"><br>
            </div>
            <div class="inp">
                
        <input type="password" id="password" name="password" class="input" required placeholder="Contraseña:"><br>

            </div>
            <button class="submit">   
            INICIAR        
            </button>
            <p class="footer">¿No tienes cuenta? <a href="registro.php" class="link">Por favor, Regístrate</a></p>
        </form>
    </div>
    <div class="banner">
        <div class="wel_text">
            <h1>BIENVENIDO<br/></h1>
            <p class="para"> A DR.BIKES.COM</p>
        </div>
    </div>
</body>
</html>
