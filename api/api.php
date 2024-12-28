<?php
// Configuración de la base de datos
$host = 'localhost';  // O la IP de tu servidor MySQL
$dbname = 'gestion_articulos';  // Nombre de tu base de datos
$username = 'root';  // Tu nombre de usuario MySQL
$password = '';  // Tu contraseña MySQL

// Crear la conexión
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error de conexión: " . $e->getMessage()]);
    exit();
}

// Función para obtener todos los artículos
function getArticulos($pdo) {
    $stmt = $pdo->prepare("SELECT articulos.id, articulos.nombre, articulos.imagen, categorias.nombre AS categoria, presentaciones.nombre AS presentacion
                           FROM articulos
                           JOIN categorias ON articulos.idcategoria = categorias.id
                           JOIN presentaciones ON articulos.idpresentacion = presentaciones.id");
    $stmt->execute();
    $articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $articulos;
}

// Función para obtener todas las categorías
function getCategorias($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM categorias");
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categorias;
}

// Función para obtener todas las presentaciones
function getPresentaciones($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM presentaciones");
    $stmt->execute();
    $presentaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $presentaciones;
}

// Función para agregar un artículo
function addArticulo($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO articulos (nombre, imagen, idcategoria, idpresentacion) VALUES (?, ?, ?, ?)");
    $stmt->execute([$data['nombre'], $data['imagen'], $data['idcategoria'], $data['idpresentacion']]);
    return ["status" => "success", "message" => "Artículo agregado correctamente."];
}

// Función para agregar una categoría
function addCategoria($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO categorias (nombre) VALUES (?)");
    $stmt->execute([$data['nombre']]);
    return ["status" => "success", "message" => "Categoría agregada correctamente."];
}

// Función para agregar una presentación
function addPresentacion($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO presentaciones (nombre) VALUES (?)");
    $stmt->execute([$data['nombre']]);
    return ["status" => "success", "message" => "Presentación agregada correctamente."];
}

// Determinar qué acción tomar
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Ejecutar la acción correspondiente
switch ($action) {
    case 'getArticulos':
        echo json_encode(getArticulos($pdo));
        break;
    case 'getCategorias':
        echo json_encode(getCategorias($pdo));
        break;
    case 'getPresentaciones':
        echo json_encode(getPresentaciones($pdo));
        break;
    case 'addArticulo':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Subir la imagen
            if (isset($_FILES['imagen'])) {
                $image_name = $_FILES['imagen']['name'];
                $image_tmp = $_FILES['imagen']['tmp_name'];
                $image_path = "../uploads/" . $image_name;

                // Mover el archivo de imagen al directorio 'uploads'
                if (move_uploaded_file($image_tmp, $image_path)) {
                    $data = [
                        'nombre' => $_POST['nombre'],
                        'imagen' => $image_name,
                        'idcategoria' => $_POST['idcategoria'],
                        'idpresentacion' => $_POST['idpresentacion']
                    ];
                    echo json_encode(addArticulo($pdo, $data));
                } else {
                    echo json_encode(["status" => "error", "message" => "Error al subir la imagen."]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Imagen no recibida."]);
            }
        }
        break;
    case 'addCategoria':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['nombre' => $_POST['nombre']];
            echo json_encode(addCategoria($pdo, $data));
        }
        break;
    case 'addPresentacion':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['nombre' => $_POST['nombre']];
            echo json_encode(addPresentacion($pdo, $data));
        }
        break;
    default:
        echo json_encode(["status" => "error", "message" => "Acción no válida."]);
        break;
}
?>
