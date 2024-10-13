<?php
require_once 'config.php';

$stmt = $pdo->query("SELECT id, title, pdf_file FROM books LIMIT 1");
$book = $stmt->fetch();

if ($book) {
    echo "Libro encontrado: " . htmlspecialchars($book['title']) . "<br>";
    echo "Ruta del PDF en la base de datos: " . htmlspecialchars($book['pdf_file']) . "<br>";
    
    $full_path = __DIR__ . '/' . $book['pdf_file'];
    echo "Ruta completa del archivo: " . $full_path . "<br>";
    
    if (file_exists($full_path)) {
        echo "El archivo existe en el servidor.<br>";
        echo "Tamaño del archivo: " . filesize($full_path) . " bytes<br>";
        echo "Permisos del archivo: " . substr(sprintf('%o', fileperms($full_path)), -4) . "<br>";
        echo "<a href='" . htmlspecialchars($book['pdf_file']) . "' target='_blank'>Intentar abrir PDF</a>";
    } else {
        echo "El archivo no existe en la ruta especificada.<br>";
    }
} else {
    echo "No se encontraron libros en la base de datos.";
}

echo "<br><br>Información del servidor:<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
?>