<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Articulos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary mb-4">Gestion de Articulos</h1>
        <p class="text-center text-muted">Elige una opcion para gestionar Articulos, Categorias o Presentaciones</p>

        <!-- Tarjetas de redirección -->
        <div class="row justify-content-center">
            <!-- Tarjeta de Artículos -->
            <div class="col-md-4">
                <div class="card border-primary mb-3">
                    <div class="card-body text-center">
                        <h4 class="card-title text-primary">Articulos</h4>
                        <p class="card-text">Administra los articulos de tu inventario, incluyendo sus imagenes, categorias y presentaciones.</p>
                        <a href="articulos.php" class="btn btn-primary">Ir a Articulos</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Categorías -->
            <div class="col-md-4">
                <div class="card border-success mb-3">
                    <div class="card-body text-center">
                        <h4 class="card-title text-success">Categorías</h4>
                        <p class="card-text">Organiza los artículos en categorías para facilitar la búsqueda y el orden.</p>
                        <a href="categorias.php" class="btn btn-success">Ir a Categorías</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Presentaciones -->
            <div class="col-md-4">
                <div class="card border-warning mb-3">
                    <div class="card-body text-center">
                        <h4 class="card-title text-warning">Presentaciones</h4>
                        <p class="card-text">Gestiona las presentaciones de los articulos para definir sus formatos o tamanos.</p>
                        <a href="presentaciones.php" class="btn btn-warning">Ir a Presentaciones</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
