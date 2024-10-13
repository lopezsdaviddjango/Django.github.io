<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Verificar si las contraseñas coinciden
    if ($password !== $confirm_password) {
        header('Location: register.php?error=passwords_dont_match');
        exit;
    }

    // Verificar si el usuario ya existe
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        header('Location: register.php?error=user_exists');
        exit;
    }

    // Insertar el nuevo usuario
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if ($stmt->execute([$username, $hashed_password])) {
        header('Location: index.php?success=registered');
    } else {
        header('Location: register.php?error=registration_failed');
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Biblioteca Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="cube-background">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6">
                <div class="login-container">
                    <h2 class="text-center mb-4">Registro</h2>
                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="username" placeholder="Usuario" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirmar Contraseña" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                    </form>
                    <p class="mt-3 text-center">¿Ya tienes una cuenta? <a href="index.php">Inicia sesión aquí</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>