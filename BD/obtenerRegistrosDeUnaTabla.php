<?php

function obtenerTodosLosRegistrosDeUnaTabla($tabla, $rutaDeArchivoDeConexion = 'conexion.php', $contenedorDeCarga = 'listado')
{
  // Incluir el archivo de conexión a la base de datos 
  require_once $rutaDeArchivoDeConexion;
  // Conectar a la base de datos
  $conexion = conectarDB();

  //preparar la consulta SQL

  if ($tabla == 'empleados') {
    $sql = "SELECT 
            e.id, 
            e.nombres, 
            e.apellido_paterno, 
            e.apellido_materno, 
            c.cargo AS cargo, 
            p.profesion AS profesion 
          FROM empleados e 
          INNER JOIN cargos c ON e.cargo_id = c.id 
          INNER JOIN profesiones p ON e.profesion_id = p.id 
          ORDER BY e.id ASC;
";
  } else {
    $sql = "SELECT * FROM $tabla order by id asc";
  }

  $stmt = $conexion->prepare($sql);

  // Ejecutar la consulta
  if ($stmt->execute()) {
    // Obtener el resultado
    $resultado = $stmt->get_result();
    //cerrar la conexión
    $stmt->close();
    $conexion->close();

    // Verificar si hay resultados
    if ($resultado->num_rows > 0) {
      // Crear un array para almacenar los registros
      $registros = array();
      // Recorrer los resultados y almacenarlos en el array
      while ($fila = $resultado->fetch_assoc()) {
        $registros[] = $fila;
      }
      // Devolver el array de registros
      return $registros;
    }
    return null;
  } else {
    // Manejar el error
    echo "<script>setTimeout(function(){ mostrarMensajeDeError('Error al obtener los registros: " . $stmt->error . "','$contenedorDeCarga'); }, 2000);</script>";
    return null;
  }
}
