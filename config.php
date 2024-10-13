<?php
// config.php
$host = 'localhost';
$dbname = 'library_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

session_start();

// Crear las tablas si no existen
$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    author VARCHAR(200) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT,
    pdf_file VARCHAR(255) NOT NULL,
    cover_image VARCHAR(255),
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS announcements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    content TEXT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
?>