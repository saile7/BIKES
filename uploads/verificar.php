<?php
$directory = 'uploads';
if (is_writable($directory)) {
    echo 'El directorio ' . $directory . ' es escribible.';
} else {
    echo 'El directorio ' . $directory . ' NO es escribible.';
}
?>
