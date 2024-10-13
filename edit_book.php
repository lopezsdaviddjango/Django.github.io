
<?php
require_once 'config.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE books SET title = ?, author = ?, category = ?, description = ? WHERE id = ?");
    $stmt->execute([$title, $author, $category, $description, $id]);

    // Manejar la actualización de archivos PDF y portada si se proporcionan
    if (!empty($_FILES['pdf_file']['name'])) {
        // Lógica para subir y actualizar el archivo PDF
    }

    if (!empty($_FILES['cover_image']['name'])) {
        // Lógica para subir y actualizar la imagen de portada
    }

    header('Location: admin_panel.php?success=1');
    exit;
}

header('Location: admin_panel.php?error=1');
exit;
?>