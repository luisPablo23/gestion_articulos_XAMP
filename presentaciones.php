<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Presentaciones</title>
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
        .btn-primary, .btn-warning {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-warning mb-4">Gestión de Presentaciones</h1>

        <!-- Navegación -->
        <div class="text-center mb-4">
            <a href="articulos.php" class="btn btn-primary mx-2">Ir a Artículos</a>
            <a href="categorias.php" class="btn btn-success mx-2">Ir a Categorías</a>
        </div>

        <!-- Listado de Presentaciones -->
        <h2 class="text-warning mb-3">Listado de Presentaciones</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-warning">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody id="presentaciones-list">
                    <!-- Los datos serán cargados aquí dinámicamente -->
                </tbody>
            </table>
        </div>

        <!-- Formulario para agregar presentación -->
        <h2 class="text-warning mb-3">Agregar Nueva Presentación</h2>
        <form id="presentacionForm" class="card p-4 shadow">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingresa el nombre de la presentación" required>
            </div>
            <button type="submit" class="btn btn-warning w-100">Agregar Presentación</button>
        </form>
    </div>

    <!-- Scripts -->
    <script>
        function loadPresentaciones() {
            fetch('api/api.php?action=getPresentaciones')
                .then(response => response.json())
                .then(data => {
                    const presentacionesList = document.getElementById('presentaciones-list');
                    presentacionesList.innerHTML = data.map(presentacion => `
                        <tr>
                            <td>${presentacion.id}</td>
                            <td>${presentacion.nombre}</td>
                        </tr>
                    `).join('');
                });
        }

        document.getElementById('presentacionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('api/api.php?action=addPresentacion', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.status === 'success') {
                        loadPresentaciones();
                    }
                });
        });

        // Cargar datos al cargar la página
        document.addEventListener('DOMContentLoaded', loadPresentaciones);
    </script>
</body>
</html>
