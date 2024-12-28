<?php
require('fpdf/fpdf.php');

// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_articulos');

// Verificar si la conexión es exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener los artículos
$sql = "SELECT a.nombre, c.nombre AS categoria, p.nombre AS presentacion, a.imagen
        FROM articulos a
        JOIN categorias c ON a.idcategoria = c.id
        JOIN presentaciones p ON a.idpresentacion = p.id";
$result = $conn->query($sql);

// Crear una instancia del objeto FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Título del informe
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(200, 10, 'Informe de Articulos', 0, 1, 'C');

// Espacio antes del listado
$pdf->Ln(10);

// Configuración de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Nombre', 1, 0, 'C');
$pdf->Cell(40, 10, 'Categoria', 1, 0, 'C');
$pdf->Cell(40, 10, 'Presentacion', 1, 0, 'C');
$pdf->Cell(40, 10, 'Imagen', 1, 1, 'C');  // Columna para la imagen

// Restablecer el estilo de la fuente para los datos
$pdf->SetFont('Arial', '', 12);

// Iterar sobre los resultados de la consulta y agregar las filas a la tabla
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(40, 10, $row['nombre'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['categoria'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['presentacion'], 1, 0, 'C');
    
    // Agregar la imagen del artículo
    $imagePath = 'uploads/' . $row['imagen'];
    
    // Verificar si la imagen existe antes de agregarla
    if (file_exists($imagePath)) {
        // Establecer el tamaño del recuadro para la imagen
        $imageWidth = 10; // Ancho del recuadro para la imagen
        $imageHeight = 10; // Alto del recuadro para la imagen

        // Insertar la imagen dentro del recuadro
        $pdf->Image($imagePath, $pdf->GetX(), $pdf->GetY(), $imageWidth, $imageHeight);
    } else {
        // Si no hay imagen, mostrar un texto
        $pdf->Cell(40, 10, 'No imagen', 1, 0, 'C');
    }
    
    $pdf->Ln(); // Salto de línea para la siguiente fila
}

// Output the PDF
$pdf->Output();
?>
