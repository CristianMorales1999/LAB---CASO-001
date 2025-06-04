<?php 
require_once 'conexion.php';
$conexion = conectarDB();

// Obtener los datos enviados por POST
$tabla = $_POST['tabla'] ?? null;
$item = $_POST['item'] ?? null;

if (!$tabla || !$item || !is_array($item)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Faltan parámetros necesarios para actualizar el registro.'
    ]);
    exit();
}

// Validar que el ID esté presente y sea numérico
$id = $item['id'] ?? null;
if (!$id || !is_numeric($id)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'El ID es obligatorio y debe ser numérico.'
    ]);
    exit();
}

// Quitar el campo 'id' del array para no actualizarlo
$campos = $item;
unset($campos['id']);

// Si no hay campos para actualizar
if (empty($campos)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No hay campos para actualizar.'
    ]);
    exit();
}

// Construir la consulta SQL dinámicamente
$set = [];
$tipos = '';
$valores = [];

foreach ($campos as $columna => $valor) {
    $set[] = "$columna = ?";
    $tipos .= 's'; // Asumimos string, puedes mejorar esto si sabes el tipo de dato
    $valores[] = $valor;
}

// Añadir el id al final para el WHERE
$tipos .= 'i';
$valores[] = $id;

$setStr = implode(', ', $set);
$sql = "UPDATE $tabla SET $setStr WHERE id = ?";

$stmt = $conexion->prepare($sql);
if (!$stmt) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al preparar la consulta: ' . $conexion->error
    ]);
    exit();
}

// Preparar los parámetros para bind_param
$stmt->bind_param($tipos, ...$valores);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Registro actualizado correctamente.'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al actualizar el registro: ' . $stmt->error
    ]);
}
