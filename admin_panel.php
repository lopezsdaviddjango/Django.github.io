<?php
require_once 'config.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit;
}

// Obtener libros
$stmt = $pdo->query("SELECT * FROM books ORDER BY upload_date DESC");
$books = $stmt->fetchAll();

// Obtener anuncios
$stmt = $pdo->query("SELECT * FROM announcements ORDER BY date DESC");
$announcements = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Biblioteca Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Panel de Administración</a>
            <div class="d-flex">
                <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Gestión de Libros</h2>
        <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addBookModal">Agregar Libro</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td><?= htmlspecialchars($book['category']) ?></td>
                    <td>
                        <button class="btn btn-sm btn-info edit-book" data-id="<?= $book['id'] ?>">Editar</button>
                        <button class="btn btn-sm btn-danger delete-book" data-id="<?= $book['id'] ?>">Eliminar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="mt-5">Gestión de Anuncios</h2>
        <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">Agregar Anuncio</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($announcements as $announcement): ?>
                <tr>
                    <td><?= htmlspecialchars($announcement['title']) ?></td>
                    <td><?= htmlspecialchars($announcement['date']) ?></td>
                    <td>
                        <button class="btn btn-sm btn-info edit-announcement" data-id="<?= $announcement['id'] ?>">Editar</button>
                        <button class="btn btn-sm btn-danger delete-announcement" data-id="<?= $announcement['id'] ?>">Eliminar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar libro -->
    <div class="modal fade" id="addBookModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Libro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="add_book.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="title" placeholder="Título" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="author" placeholder="Autor" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="category" placeholder="Categoría" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" name="description" placeholder="Descripción"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="pdf_file" class="form-label">Archivo PDF</label>
                            <input type="file" class="form-control" name="pdf_file" accept=".pdf" required>
                        </div>
                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Imagen de Portada</label>
                            <input type="file" class="form-control" name="cover_image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Libro</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar anuncio -->
    <div class="modal fade" id="addAnnouncementModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Anuncio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="add_announcement.php" method="POST">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="title" placeholder="Título" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" name="content" placeholder="Contenido" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Anuncio</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar libro -->
    <div class="modal fade" id="editBookModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Libro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="edit_book.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="edit-book-id">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="title" id="edit-book-title" placeholder="Título" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="author" id="edit-book-author" placeholder="Autor" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="category" id="edit-book-category" placeholder="Categoría" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" name="description" id="edit-book-description" placeholder="Descripción"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="pdf_file" class="form-label">Nuevo Archivo PDF (opcional)</label>
                            <input type="file" class="form-control" name="pdf_file" accept=".pdf">
                        </div>
                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Nueva Imagen de Portada (opcional)</label>
                            <input type="file" class="form-control" name="cover_image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar Libro</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar anuncio -->
    <div class="modal fade" id="editAnnouncementModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Anuncio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="edit_announcement.php" method="POST">
                        <input type="hidden" name="id" id="edit-announcement-id">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="title" id="edit-announcement-title" placeholder="Título" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" name="content" id="edit-announcement-content" placeholder="Contenido" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar Anuncio</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Editar libro
            $('.edit-book').click(function() {
                var id = $(this).data('id');
                $.getJSON('get_book.php?id=' + id, function(data) {
                    $('#edit-book-id').val(data.id);
                    $('#edit-book-title').val(data.title);
                    $('#edit-book-author').val(data.author);
                    $('#edit-book-category').val(data.category);
                    $('#edit-book-description').val(data.description);
                    $('#editBookModal').modal('show');
                });
            });

            // Eliminar libro
            $('.delete-book').click(function() {
                if (confirm('¿Está seguro de que desea eliminar este libro?')) {
                    var id = $(this).data('id');
                    $.post('delete_book.php', {id: id}, function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Error al eliminar el libro');
                        }
                    }, 'json');
                }
            });

            // Editar anuncio
            $('.edit-announcement').click(function() {
                var id = $(this).data('id');
                $.getJSON('get_announcement.php?id=' + id, function(data) {
                    $('#edit-announcement-id').val(data.id);
                    $('#edit-announcement-title').val(data.title);
                    $('#edit-announcement-content').val(data.content);
                    $('#editAnnouncementModal').modal('show');
                });
            });

            // Eliminar anuncio
            $('.delete-announcement').click(function() {
                if (confirm('¿Está seguro de que desea eliminar este anuncio?')) {
                    var id = $(this).data('id');
                    $.post('delete_announcement.php', {id: id}, function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Error al eliminar el anuncio');
                        }
                    }, 'json');
                }
            });
        });
    </script>
</body>
</html>