<?php
require_once 'config.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('HTTP/1.1 403 Forbidden');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($book) {
        echo json_encode($book);
    } else {
        header('HTTP/1.1 404 Not Found');
    }
} else {
    header('HTTP/1.1 400 Bad Request');
}
?>