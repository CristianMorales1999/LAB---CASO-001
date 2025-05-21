<?php

function conectarDB($database = 'db_caso_01') {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $port = 3306; // Puerto por defecto de MySQL
    $charset = 'utf8mb4';

    // Crear conexión
    $conexion = new mysqli($host, $username, $password, $database, $port);

    // Verificar conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }else{
        // Establecer el conjunto de caracteres
        if (!$conexion->set_charset($charset)) {
            die("Error cargando el conjunto de caracteres $charset: " . $conexion->error);
        }
    }
    return $conexion;
}

?>