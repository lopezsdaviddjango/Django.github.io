<?php
require_once 'config.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Obtener libros
$stmt = $pdo->query("SELECT * FROM books ORDER BY upload_date DESC");
$books = $stmt->fetchAll();

// Obtener anuncios
$stmt = $pdo->query("SELECT * FROM announcements ORDER BY date DESC LIMIT 5");
$announcements = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario - Biblioteca Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="cube-background">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Biblioteca Digital</a>
            <div class="d-flex">
                <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Sección de Anuncios -->
        <div class="content-container mb-4">
            <h2>Anuncios Recientes</h2>
            <?php if (count($announcements) > 0): ?>
                <div class="list-group">
                    <?php foreach ($announcements as $announcement): ?>
                        <div class="list-group-item">
                            <h5 class="mb-1"><?= htmlspecialchars($announcement['title']) ?></h5>
                            <p class="mb-1"><?= nl2br(htmlspecialchars($announcement['content'])) ?></p>
                            <small>Fecha: <?= htmlspecialchars($announcement['date']) ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No hay anuncios recientes.</p>
            <?php endif; ?>
        </div>

        <!-- Sección de Libros -->
        <div class="content-container">
            <h2>Libros Disponibles</h2>
            <div class="row" id="booksContainer">
                <?php foreach ($books as $book): ?>
                <div class="col-md-4 mb-4 book-item" data-category="<?= htmlspecialchars($book['category']) ?>">
                    <div class="card book-card">
                        <img src="<?= htmlspecialchars($book['cover_image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($book['title']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                            <p class="card-text">
                                <strong>Autor:</strong> <?= htmlspecialchars($book['author']) ?><br>
                                <strong>Categoría:</strong> <?= htmlspecialchars($book['category']) ?>
                            </p>
                            <?php if (!empty($book['description'])): ?>
                                <p class="card-text"><?= nl2br(htmlspecialchars($book['description'])) ?></p>
                            <?php endif; ?>
                            <div class="d-grid gap-2">
                                <a href="<?= htmlspecialchars($book['pdf_file']) ?>" class="btn btn-primary" target="_blank">Leer</a>
                                <a href="<?= htmlspecialchars($book['pdf_file']) ?>" class="btn btn-outline-secondary" download>Descargar PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('searchInput').addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const books = document.querySelectorAll('.book-item');
            
            books.forEach(book => {
                const title = book.querySelector('.card-title').textContent.toLowerCase();
                const author = book.querySelector('.card-text').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || author.includes(searchTerm)) {
                    book.style.display = 'block';
                } else {
                    book.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>