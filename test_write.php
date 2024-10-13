echo '<?php
$file = "archivos/test.txt";
$content = "Prueba de escritura";
if (file_put_contents($file, $content) !== false) {
    echo "Archivo creado exitosamente";
} else {
    echo "Error al crear el archivo";
}
?>' > test_write.php