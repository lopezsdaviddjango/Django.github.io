<?php
require_once 'config.php';
if(isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Platform - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="cube-background">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6">
                <div class="login-container">
                    <ul class="nav nav-tabs mb-4" id="loginTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#user">Usuario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#admin">Administrador</a>
                        </li>
                    </ul>
                    
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="user">
                            <form action="login_process.php" method="POST">
                                <input type="hidden" name="type" value="user">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="username" placeholder="Usuario">
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="password" placeholder="Contraseña">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                            </form>
                        </div>
                        
                        <div class="tab-pane fade" id="admin">
                            <form action="login_process.php" method="POST">
                                <input type="hidden" name="type" value="admin">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="username" placeholder="Usuario Admin">
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="password" placeholder="Contraseña Admin">
                                </div>
                                <button type="submit" class="btn btn-dark w-100">Acceso Administrativo</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Nuevo botón de registro -->
                    <div class="text-center mt-3">
                        <p>¿No tienes una cuenta?</p>
                        <a href="register.php" class="btn btn-outline-primary">Registrarse</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>
</body>
</html>