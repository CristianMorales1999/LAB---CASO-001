<?php

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
// Preparar la consulta SQL
if ($tabla !== 'empleados') {
    $consulta = "SELECT * FROM $tabla WHERE id = ? ORDER BY id ASC";
} else {
    $consulta = "SELECT 
                    e.id, 
                    e.nombres, 
                    e.apellido_paterno, 
                    e.apellido_materno, 
                    c.cargo AS cargo, 
                    c.id AS cargoId,
                    p.profesion AS profesion,
                    p.id AS profesionId
                FROM empleados e 
                INNER JOIN cargos c ON e.cargo_id = c.id 
                INNER JOIN profesiones p ON e.profesion_id = p.id 
                WHERE e.id = ? 
                ORDER BY e.id ASC";
}
$stmt = $conexion->prepare($consulta);
if (!$stmt) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al preparar la consulta: ' . $conexion->error
    ]);
    exit();
}
$stmt->bind_param('i', $id); // Usar 'i' para indicar que es un entero
if ($stmt->execute()) {
    $resultado = $stmt->get_result();
    if ($resultado->num_rows > 0) {
        $registro = $resultado->fetch_assoc();
        echo json_encode([
            'status' => 'success',
            'registroEncontrado' => $registro
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No se encontró ningún registro con el ID proporcionado.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al ejecutar la consulta: ' . $stmt->error
    ]);
}