<?php
require_once 'config.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare("INSERT INTO announcements (title, content) VALUES (?, ?)");
    if ($stmt->execute([$title, $content])) {
        header('Location: admin_panel.php?success=2');
    } else {
        header('Location: admin_panel.php?error=2');
    }
    exit;
}
?>