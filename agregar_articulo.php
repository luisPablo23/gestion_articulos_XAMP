<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_articulos');

// Verificar si la conexión es exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $idcategoria = $_POST['idcategoria'];
    $idpresentacion = $_POST['idpresentacion'];

    // Subir la imagen
    if (isset($_FILES['imagen'])) {
        $imagen = $_FILES['imagen']['name'];
        $imagenTmp = $_FILES['imagen']['tmp_name'];
        $rutaImagen = 'uploads/' . $imagen;

        // Mover la imagen a la carpeta 'uploads'
        if (move_uploaded_file($imagenTmp, $rutaImagen)) {
            // Insertar los datos en la base de datos
            $sql = "INSERT INTO articulos (nombre, idcategoria, idpresentacion, imagen) 
                    VALUES ('$nombre', '$idcategoria', '$idpresentacion', '$imagen')";

            if ($conn->query($sql) === TRUE) {
                echo "Nuevo artículo agregado exitosamente.";
                // Redirigir o mostrar un mensaje después de la inserción
                header('Location: articulos.php'); // Redirige a la lista de artículos
                exit;
            } else {
                echo "Error al agregar artículo: " . $conn->error;
            }
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "No se ha subido ninguna imagen.";
    }
}

// Cerrar la conexión
$conn->close();
?>
