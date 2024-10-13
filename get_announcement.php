<?php
require_once 'config.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('HTTP/1.1 403 Forbidden');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM announcements WHERE id = ?");
    $stmt->execute([$id]);
    $announcement = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($announcement) {
        echo json_encode($announcement);
    } else {
        header('HTTP/1.1 404 Not Found');
    }
} else {
    header('HTTP/1.1 400 Bad Request');
}
?>