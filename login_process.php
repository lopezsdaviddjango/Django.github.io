<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $type = $_POST['type'];

    if ($type == 'admin') {
        // Verificación de admin
        if ($username === 'django' && $password === '007django') {
            $_SESSION['user_id'] = 1;
            $_SESSION['is_admin'] = true;
            header('Location: admin_panel.php');
            exit;
        }
    } else {
        // Verificación de usuario normal
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['is_admin'] = false;
            header('Location: dashboard.php');
            exit;
        }
    }
    
    // Si llegamos aquí, la autenticación falló
    header('Location: index.php?error=1');
    exit;
}
?>