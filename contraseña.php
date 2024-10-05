<?php
$password = 'ivan123@'; // Cambia esto por la contraseña deseada
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;
?>
