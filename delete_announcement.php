<?php
require_once 'config.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('HTTP/1.1 403 Forbidden');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM announcements WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(['success' => true]);
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['success' => false, 'error' => 'Error al eliminar el aviso']);
    }
} else {
    header('HTTP/1.1 400 Bad Request');
}
?>