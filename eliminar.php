<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_articulos');

// Verificar si la conexion es exitosa
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}
