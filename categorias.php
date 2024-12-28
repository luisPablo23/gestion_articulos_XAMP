<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorias</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-primary {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-success mb-4">Gestión de Categorias</h1>

        <!-- Navegación -->
        <div class="text-center mb-4">
            <a href="articulos.php" class="btn btn-primary mx-2">Ir a Articulos</a>
            <a href="presentaciones.php" class="btn btn-warning mx-2">Ir a Presentaciones</a>
        </div>

        <!-- Listado de Categorías -->
        <h2 class="text-success mb-3">Listado de Categorías</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody id="categorias-list">
                    <!-- Los datos serán cargados aquí dinámicamente -->
                </tbody>
            </table>
        </div>

        <!-- Formulario para agregar categoría -->
        <h2 class="text-success mb-3">Agregar Nueva Categoria</h2>
        <form id="categoriaForm" class="card p-4 shadow">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingresa el nombre de la categoría" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Agregar Categoria</button>
        </form>
    </div>

    <!-- Scripts -->
    <script>
        function loadCategorias() {
            fetch('api/api.php?action=getCategorias')
                .then(response => response.json())
                .then(data => {
                    const categoriasList = document.getElementById('categorias-list');
                    categoriasList.innerHTML = data.map(categoria => `
                        <tr>
                            <td>${categoria.id}</td>
                            <td>${categoria.nombre}</td>
                        </tr>
                    `).join('');
                });
        }

        document.getElementById('categoriaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('api/api.php?action=addCategoria', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.status === 'success') {
                        loadCategorias();
                    }
                });
        });

        // Cargar datos al cargar la página
        document.addEventListener('DOMContentLoaded', loadCategorias);
    </script>
</body>
</html>
