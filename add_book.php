<?php
require_once 'config.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit;
}

// Función para verificar y crear directorio
function ensureDirectoryExists($dir) {
    if (!file_exists($dir)) {
        if (!mkdir($dir, 0755, true)) {
            die("Error: No se pudo crear el directorio $dir");
        }
    }
}

// Función para mostrar errores
function showError($message) {
    echo json_encode(['error' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Validar que se hayan enviado todos los campos requeridos
        if (empty($_POST['title']) || empty($_POST['author']) || empty($_POST['category'])) {
            showError("Todos los campos son obligatorios");
        }

        $title = $_POST['title'];
        $author = $_POST['author'];
        $category = $_POST['category'];
        $description = $_POST['description'] ?? '';

        // Crear directorio de archivos si no existe
        $upload_dir = __DIR__ . '/archivos/';
        ensureDirectoryExists($upload_dir);
        
        // Procesar el archivo PDF
        if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
            showError('Error al subir el archivo PDF: ' . $_FILES['pdf_file']['error']);
        }

        // Validar el tipo de archivo PDF
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $pdf_file_type = $finfo->file($_FILES['pdf_file']['tmp_name']);
        $allowed_pdf_types = array('application/pdf');
        if (!in_array($pdf_file_type, $allowed_pdf_types)) {
            showError('Solo se permiten archivos PDF');
        }

        // Generar nombre único para el PDF
        $pdf_name = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "", $_FILES['pdf_file']['name']);
        $pdf_path = $upload_dir . $pdf_name;
        $pdf_web_path = 'archivos/' . $pdf_name;

        // Subir el archivo PDF
        if (!move_uploaded_file($_FILES['pdf_file']['tmp_name'], $pdf_path)) {
            showError('Error al mover el archivo PDF. Verifica los permisos del directorio');
        }
        chmod($pdf_path, 0644);

        // Procesar la imagen de portada
        $cover_image = '';
        $cover_web_path = '';
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $image_file_type = $finfo->file($_FILES['cover_image']['tmp_name']);
            $allowed_image_types = array('image/jpeg', 'image/png', 'image/gif');
            if (!in_array($image_file_type, $allowed_image_types)) {
                showError('Solo se permiten imágenes JPG, PNG y GIF');
            }

            $image_name = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "", $_FILES['cover_image']['name']);
            $image_path = $upload_dir . $image_name;
            $cover_web_path = 'archivos/' . $image_name;

            if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $image_path)) {
                showError('Error al subir la imagen de portada');
            }
            chmod($image_path, 0644);
            $cover_image = $image_path;
        }

        // Insertar en la base de datos
        $stmt = $pdo->prepare("INSERT INTO books (title, author, category, description, pdf_file, cover_image) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt->execute([$title, $author, $category, $description, $pdf_web_path, $cover_web_path])) {
            showError('Error al guardar en la base de datos');
        }

        // Redirigir al panel de administración
        header('Location: admin_panel.php?success=1');
        exit;

    } catch (Exception $e) {
        showError('Error: ' . $e->getMessage());
    }
}
?>