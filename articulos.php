<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_articulos');

// Verificar si la conexion es exitosa
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Obtener los articulos de la base de datos
$sql = "SELECT a.id, a.nombre, c.nombre AS categoria, p.nombre AS presentacion, a.imagen
        FROM articulos a
        JOIN categorias c ON a.idcategoria = c.id
        JOIN presentaciones p ON a.idpresentacion = p.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Articulos</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #5cb85c;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 0;
        }

        a {
            text-decoration: none;
            color: #007bff;
            margin: 0 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        h2 {
            margin: 20px 0 10px;
            color: #333;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #f2f2f2;
        }

        table img {
            width: 50px;
            height: auto;
            border-radius: 5px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        /* Asegurando que las imagenes sean proporcionadas de manera consistente en el formato adecuado */
        .image-column {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestion de Articulos</h1>
        <div style="text-align: center;">
            <a href="categorias.php">Ir a Categorias</a>
            <a href="presentaciones.php">Ir a Presentaciones</a>
            <a href="informe_articulos.php">Generar Informe PDF</a>
        </div>

        <h2>Listado de Articulos</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Presentacion</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nombre']}</td>
                                <td>{$row['categoria']}</td>
                                <td>{$row['presentacion']}</td>
                                <td><img src='uploads/{$row['imagen']}' alt='{$row['nombre']}' class='image-column'></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay articulos disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>Agregar Nuevo Articulo</h2>
        <form action="agregar_articulo.php" method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="idcategoria">Categoria:</label>
            <select id="idcategoria" name="idcategoria" required>
                <?php
                $categorias = $conn->query("SELECT * FROM categorias");
                while ($categoria = $categorias->fetch_assoc()) {
                    echo "<option value='{$categoria['id']}'>{$categoria['nombre']}</option>";
                }
                ?>
            </select>

            <label for="idpresentacion">Presentacion:</label>
            <select id="idpresentacion" name="idpresentacion" required>
                <?php
                $presentaciones = $conn->query("SELECT * FROM presentaciones");
                while ($presentacion = $presentaciones->fetch_assoc()) {
                    echo "<option value='{$presentacion['id']}'>{$presentacion['nombre']}</option>";
                }
                ?>
            </select>

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" required>

            <button type="submit">Agregar Articulo</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
