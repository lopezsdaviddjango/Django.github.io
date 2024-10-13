<?php
require_once 'config.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare("UPDATE announcements SET title = ?, content = ? WHERE id = ?");
    if ($stmt->execute([$title, $content, $id])) {
        header('Location: admin_panel.php?success=3');
    } else {
        header('Location: admin_panel.php?error=3');
    }
    exit;
}
?>