<?php

//Funcion para obtener la conexion a la BD
function obtenerConexionBD($rutaDeArchivoDeConexion = 'conexion.php')
{
    require_once $rutaDeArchivoDeConexion;
    $conexion = conectarDB(); // Asumo que esta función existe en conexion.php
    return $conexion;
}

//Funcion para ejecutar una consulta y obtener el resultado de dicha ejecución
function obtenerResultadosDeEjecucionDeConsulta($stmt){
    if ($stmt->execute()) {
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            $registros = array();
            while ($fila = $resultado->fetch_assoc()) {
                $registros[] = $fila;
            }
            $stmt->close();
            return $registros;
        }
        $stmt->close();
        return []; // Devolver array vacío si no hay resultados para consistencia
    }
    if ($stmt) {
        // error_log("Error en la ejecución de la consulta: " . $stmt->error); // Opcional: loggear error
        $stmt->close();
    }
    return null; // O un array vacío: []
}

// CONSULTAS A REALIZAR 
//Consulta1: Mostrar los apellidos y nombres de todos los empleados, además de su cargo en la empresa.
function obtenerResultadosDeConsultaNro01($rutaDeArchivoDeConexion = 'conexion.php')
{
    $conexion = obtenerConexionBD($rutaDeArchivoDeConexion);
    if (!$conexion) return null;

    $sql = "SELECT 
            e.apellido_paterno, 
            e.apellido_materno,
            e.nombres, 
            c.cargo AS cargo_empleado
          FROM empleados e 
          INNER JOIN cargos c ON e.cargo_id = c.id 
          ORDER BY e.id ASC;
    ";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        // error_log("Error en la preparación de la consulta 1: " . $conexion->error); // Opcional
        $conexion->close();
        return null;
    }
    $resultado=obtenerResultadosDeEjecucionDeConsulta($stmt);
    $conexion->close();
    return $resultado;
}

//Consulta2: Mostrar los apellidos y nombres de todos los empleados, además de su profesión.
function obtenerResultadosDeConsultaNro02($rutaDeArchivoDeConexion = 'conexion.php')
{
    $conexion = obtenerConexionBD($rutaDeArchivoDeConexion);
    if (!$conexion) return null;

    $sql = "SELECT 
            e.apellido_paterno, 
            e.apellido_materno, 
            e.nombres, 
            p.profesion AS profesion_empleado
          FROM empleados e 
          INNER JOIN profesiones p ON e.profesion_id = p.id 
          ORDER BY e.id ASC;
    ";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        $conexion->close();
        return null;
    }
    $resultado=obtenerResultadosDeEjecucionDeConsulta($stmt);
    $conexion->close();
    return $resultado;
}

//Consulta3: Mostrar los apellidos y nombres de todos los empleados, además de su cargo y profesión.
function obtenerResultadosDeConsultaNro03($rutaDeArchivoDeConexion = 'conexion.php')
{
    $conexion = obtenerConexionBD($rutaDeArchivoDeConexion);
    if (!$conexion) return null;

    $sql = "SELECT 
            e.apellido_paterno, 
            e.apellido_materno, 
            e.nombres, 
            c.cargo AS cargo_empleado, 
            p.profesion AS profesion_empleado
          FROM empleados e 
          INNER JOIN cargos c ON e.cargo_id = c.id 
          INNER JOIN profesiones p ON e.profesion_id = p.id 
          ORDER BY e.id ASC;
    ";
    $stmt = $conexion->prepare($sql);
     if (!$stmt) {
        $conexion->close();
        return null;
    }
    $resultado=obtenerResultadosDeEjecucionDeConsulta($stmt);
    $conexion->close();
    return $resultado;
}

//Consulta4: Mostrar los empleados que tienen secundaria completa o son contadores
function obtenerResultadosDeConsultaNro04($rutaDeArchivoDeConexion = 'conexion.php')
{
    $conexion = obtenerConexionBD($rutaDeArchivoDeConexion);
    if (!$conexion) return null;

    $sql = "SELECT 
            e.apellido_paterno, 
            e.apellido_materno, 
            e.nombres, 
            p.profesion AS profesion_empleado
          FROM empleados e 
          INNER JOIN profesiones p ON e.profesion_id = p.id 
          WHERE p.profesion = 'SECUNDARIA COMPLETA' OR p.profesion = 'CONTADOR'
          ORDER BY e.id ASC;
    "; // Valores en MAYÚSCULAS
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        $conexion->close();
        return null;
    }
    $resultado=obtenerResultadosDeEjecucionDeConsulta($stmt);
    $conexion->close();
    return $resultado;
}

//Consulta5: Mostrar los empleados que son vendedores
function obtenerResultadosDeConsultaNro05($rutaDeArchivoDeConexion = 'conexion.php')
{
    $conexion = obtenerConexionBD($rutaDeArchivoDeConexion);
    if (!$conexion) return null;

    $sql = "SELECT 
            e.apellido_paterno, 
            e.apellido_materno, 
            e.nombres, 
            c.cargo AS cargo_empleado
          FROM empleados e 
          INNER JOIN cargos c ON e.cargo_id = c.id 
          WHERE c.cargo = 'VENDEDOR'
          ORDER BY e.id ASC;
    "; // Valor en MAYÚSCULAS
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        $conexion->close();
        return null;
    }
    $resultado=obtenerResultadosDeEjecucionDeConsulta($stmt);
    $conexion->close();
    return $resultado;
}

//Consulta6: Mostrar los datos del empleado Miguel Cervantes Saavedra
function obtenerResultadosDeConsultaNro06($rutaDeArchivoDeConexion = 'conexion.php')
{
    $conexion = obtenerConexionBD($rutaDeArchivoDeConexion);
    if (!$conexion) return null;

    $sql = "SELECT 
            e.id,
            e.nombres, 
            e.apellido_paterno, 
            e.apellido_materno, 
            p.profesion AS profesion_empleado,
            c.cargo AS cargo_empleado
          FROM empleados e 
          INNER JOIN profesiones p ON e.profesion_id = p.id
          INNER JOIN cargos c ON e.cargo_id = c.id 
          WHERE e.nombres = 'MIGUEL' 
            AND e.apellido_paterno = 'CERVANTES' 
            AND e.apellido_materno = 'SAAVEDRA'
          ORDER BY e.id ASC; 
    "; // Valores en MAYÚSCULAS
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        $conexion->close();
        return null;
    }
    $resultado=obtenerResultadosDeEjecucionDeConsulta($stmt);
    $conexion->close();
    return $resultado;
}

//Consulta7: Mostrar los empleados que son cajeros y tienen secundaria completa
function obtenerResultadosDeConsultaNro07($rutaDeArchivoDeConexion = 'conexion.php')
{
    $conexion = obtenerConexionBD($rutaDeArchivoDeConexion);
    if (!$conexion) return null;

    $sql = "SELECT 
            e.apellido_paterno, 
            e.apellido_materno, 
            e.nombres, 
            p.profesion AS profesion_empleado,
            c.cargo AS cargo_empleado
          FROM empleados e 
          INNER JOIN profesiones p ON e.profesion_id = p.id
          INNER JOIN cargos c ON e.cargo_id = c.id 
          WHERE c.cargo = 'CAJERO' AND p.profesion = 'SECUNDARIA COMPLETA'
          ORDER BY e.id ASC;
    "; // Valores en MAYÚSCULAS
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        $conexion->close();
        return null;
    }
    $resultado=obtenerResultadosDeEjecucionDeConsulta($stmt);
    $conexion->close();
    return $resultado;
}

//Consulta8: Mostrar los datos del empleado numero 8
function obtenerResultadosDeConsultaNro08($rutaDeArchivoDeConexion = 'conexion.php')
{
    $conexion = obtenerConexionBD($rutaDeArchivoDeConexion);
    if (!$conexion) return null;

    $sql = "SELECT 
            e.id,
            e.nombres, 
            e.apellido_paterno, 
            e.apellido_materno, 
            p.profesion AS profesion_empleado,
            c.cargo AS cargo_empleado
          FROM empleados e 
          INNER JOIN profesiones p ON e.profesion_id = p.id
          INNER JOIN cargos c ON e.cargo_id = c.id 
          WHERE e.id = 8;
    ";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        $conexion->close();
        return null;
    }
    $resultado=obtenerResultadosDeEjecucionDeConsulta($stmt);
    $conexion->close();
    return $resultado;
}

//Consulta9: Mostrar los empleados que no son cajeros ni vendedores ordenados por nombre.
function obtenerResultadosDeConsultaNro09($rutaDeArchivoDeConexion = 'conexion.php')
{
    $conexion = obtenerConexionBD($rutaDeArchivoDeConexion);
    if (!$conexion) return null;

    $sql = "SELECT 
            e.apellido_paterno, 
            e.apellido_materno, 
            e.nombres, 
            c.cargo AS cargo_empleado
          FROM empleados e 
          INNER JOIN cargos c ON e.cargo_id = c.id 
          WHERE c.cargo NOT IN ('CAJERO', 'VENDEDOR')
          ORDER BY e.nombres ASC, e.apellido_paterno ASC, e.apellido_materno ASC;
    "; // Valores en MAYÚSCULAS
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        $conexion->close();
        return null;
    }
    $resultado=obtenerResultadosDeEjecucionDeConsulta($stmt);
    $conexion->close();
    return $resultado;
}

//Consulta10: Mostrar los empleados que en medio del nombre tengan la letra ”I”, no tengan secundaria completa ni sean cajeros.
function obtenerResultadosDeConsultaNro10($rutaDeArchivoDeConexion = 'conexion.php')
{
    $conexion = obtenerConexionBD($rutaDeArchivoDeConexion);
    if (!$conexion) return null;

    $sql = "SELECT 
            e.id,
            e.nombres, 
            e.apellido_paterno, 
            e.apellido_materno, 
            p.profesion AS profesion_empleado,
            c.cargo AS cargo_empleado
          FROM empleados e 
          INNER JOIN profesiones p ON e.profesion_id = p.id
          INNER JOIN cargos c ON e.cargo_id = c.id 
          WHERE e.nombres LIKE '%I%' -- Solo necesitamos buscar 'I' mayúscula
            AND p.profesion != 'SECUNDARIA COMPLETA'
            AND c.cargo != 'CAJERO'
          ORDER BY e.id ASC;
    "; // Valores en MAYÚSCULAS y LIKE ajustado
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        $conexion->close();
        return null;
    }
    $resultado=obtenerResultadosDeEjecucionDeConsulta($stmt);
    $conexion->close();
    return $resultado;
}


//Funcion para filtrar el llamado a la funcion que ejecuta un numero de consulta determinada
function obtenerResultadosDeUnaDeterminadaConsulta($nroDeConsulta, $rutaDeArchivoDeConexion = 'conexion.php'){
    switch($nroDeConsulta){
        case 1:
            return obtenerResultadosDeConsultaNro01($rutaDeArchivoDeConexion);
        case 2:
            return obtenerResultadosDeConsultaNro02($rutaDeArchivoDeConexion);
        case 3:
            return obtenerResultadosDeConsultaNro03($rutaDeArchivoDeConexion);
        case 4:
            return obtenerResultadosDeConsultaNro04($rutaDeArchivoDeConexion);
        case 5:
            return obtenerResultadosDeConsultaNro05($rutaDeArchivoDeConexion);
        case 6:
            return obtenerResultadosDeConsultaNro06($rutaDeArchivoDeConexion);
        case 7:
            return obtenerResultadosDeConsultaNro07($rutaDeArchivoDeConexion);
        case 8:
            return obtenerResultadosDeConsultaNro08($rutaDeArchivoDeConexion);
        case 9:
            return obtenerResultadosDeConsultaNro09($rutaDeArchivoDeConexion);
        case 10:
            return obtenerResultadosDeConsultaNro10($rutaDeArchivoDeConexion);
        default: 
            return []; 
    }
}

?>