<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';
$conexion = conectarDB();

$tabla = $_POST['tabla'] ?? null;
$id = $_POST['id'] ?? null;

if (!$tabla || !$id) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Faltan parámetros necesarios.'
    ]);
    exit();
}

// Validar que el ID sea un número
if (!is_numeric($id)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'El ID debe ser un número.'
    ]);
    exit();
}

// Preparar la consulta SQL para actualizar el registro
$sql = "DELETE FROM $tabla WHERE id = ?";

$stmt = $conexion->prepare($sql);

// Verificar si la preparación de la consulta fue exitosa
if (!$stmt) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al preparar la consulta: ' . $conexion->error
    ]);
    exit();
}

// Vincular los parámetros
$stmt->bind_param("i", $id);
// Ejecutar la consulta
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Registro de la tabla '.$tabla.' con ID '.$id.' eliminado correctamente.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No se encontró ningún registro con el ID '.$id.' para eliminar en la tabla '.$tabla.'.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al eliminar el registro: ' . $stmt->error
    ]);
}
$stmt->close();
$conexion->close();

?>
