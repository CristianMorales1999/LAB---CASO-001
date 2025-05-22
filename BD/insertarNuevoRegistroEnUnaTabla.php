<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

$conexion = conectarDB();

//Evaluar el nombre de la tabla
$tabla = $_POST['tabla']; // Obtener el nombre de la tabla desde la URL
$nuevoRegistro = $_POST['nuevoItem']; // Obtener el nuevo registro el cual es un objeto que contiene los datos a insertar
// $nuevoRegistro = json_decode($nuevoRegistro, true); // Convertir el objeto JSON a un array asociativo

$campos = array_keys($nuevoRegistro); // Obtener los nombres de los campos
$valores = array_values($nuevoRegistro); // Obtener los valores de los campos

$campos = implode(", ", $campos); // Convertir el array de campos a una cadena separada por comas

//Preparar la consulta SQL con ?s
$consulta = "INSERT INTO $tabla ($campos) VALUES (" . str_repeat('?,', count($valores) - 1) . "?)"; // Crear la consulta SQL
$stmt = $conexion->prepare($consulta); // Preparar la consulta
$stmt->bind_param(str_repeat('s', count($valores)), ...$valores); // Vincular los parámetros a la consulta

// Ejecutar la consulta
if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Registro insertado de manera exitosa!'
    ]);
    exit();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al insertar el registro: ' . $stmt->error
    ]);
    return;
}
?>
