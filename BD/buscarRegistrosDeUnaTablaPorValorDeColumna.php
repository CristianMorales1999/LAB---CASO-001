<?php
    require_once 'conexion.php';
    $conexion = conectarDB();

    // Obtener el nombre de la tabla y el valor de la columna desde la solicitud POST
    $tabla = $_POST['tabla']; // Nombre de la tabla
    $col = $_POST['columna']; // Nombre de la columna
    $valor = $_POST['valor']; // Valor a buscar
    $valor = '%' . $valor . '%'; // Agregar comodines para búsqueda parcial

    // echo json_encode([
    //         'status' => 'success',
    //         'message' => 'Registros debuger.',
    //         'tabla' => $tabla. ' - ' . $col . ' - ' . $valor
    //     ]);
    // exit();

    if(!isset($tabla) || !isset($col) || !isset($valor)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Faltan parámetros necesarios.'
        ]);
        exit();
    }
    //Si no es la tabla empleados, se busca el valor en la columna especificada
    if ($tabla != 'empleados') {
        $consulta = "SELECT * FROM $tabla WHERE $col LIKE ? ORDER BY id ASC";
    } else {
        $columnasPermitidas=[
            'nombres'=> 'e.nombres',
            'apellido_paterno'=> 'e.apellido_paterno',
            'apellido_materno'=> 'e.apellido_materno',
            'cargo'=> 'c.cargo',
            'profesion'=> 'p.profesion'
        ];

        // Si es la tabla empleados, se busca el valor en los campos específicos
        $consulta = "SELECT 
                        e.id, 
                        e.nombres, 
                        e.apellido_paterno, 
                        e.apellido_materno, 
                        c.cargo AS cargo, 
                        p.profesion AS profesion 
                    FROM empleados e 
                    INNER JOIN cargos c ON e.cargo_id = c.id 
                    INNER JOIN profesiones p ON e.profesion_id = p.id 
                    WHERE $columnasPermitidas[$col] LIKE ? 
                    ORDER BY e.id ASC";
    }
    // Preparar la consulta SQL
    $stmt = $conexion->prepare($consulta);
    // Verificar si la preparación de la consulta fue exitosa
    if (!$stmt) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al preparar la consulta: ' . $conexion->error
        ]);
        exit();
    }
    $stmt->bind_param('s', $valor); // Vincular el parámetro
    if (!$stmt->execute()) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al ejecutar la consulta: ' . $stmt->error
        ]);
        exit();
    }
    $resultado = $stmt->get_result(); // Obtener el resultado de la consulta
    
    //verificar si hay resultados
    if ($resultado->num_rows > 0) {
        $registros = array();
        $primerRegistro = $resultado->fetch_assoc();
        // Obtener los nombres de las columnas
        $columnas = array_keys($primerRegistro);
        
        $tabla="<thead><tr>";

        // Recorrer los nombres de las columnas y mostrarlas en la tabla
        foreach ($columnas as $columna) {
            $columna = str_replace('_', ' ', $columna);
            $columna = preg_replace('/(?<!^)(?=[A-Z])/', ' ', $columna);
            $columna = preg_replace('/\s+/', ' ', $columna);
            $columna = trim($columna);
            $columna = ucfirst(strtolower($columna));
            // Mostrar el nombre de la columna
            $tabla .= "<th>" . htmlspecialchars($columna) . "</th>";
        }
        $tabla.= "<th>Accion</th>"; // Agregar columna de acciones
        $tabla .= "</tr></thead><tbody>";

        // Agregar una fila para el primer registro
        $tabla .= "<tr>";
        // Recorrer cada columna del primer registro y agregarla a la tabla
        foreach ($primerRegistro as $columna) {
            //echo "<script>console.log(" . json_encode($columna) . ");</script>";
            $tabla .= "<td>" . htmlspecialchars($columna) . "</td>";
        }
        // Agregar una celda para accion editar
        $tabla .= "<td><button class='btn actualizar-btn' onclick=\"cargarFormularioActualizar(" . json_encode($primerRegistro) . ",'container')\">Editar</button></td>";
        $tabla .= "</tr>";

        // Recorrer los registros y almacenarlos en el array
        while ($fila = $resultado->fetch_assoc()) {

            $tabla .= "<tr>";
            // Recorrer cada columna de la fila y agregarla a la tabla
            foreach ($fila as $columna) {
                //echo "<script>console.log(" . json_encode($columna) . ");</script>";
                $tabla .= "<td>" . htmlspecialchars($columna) . "</td>";
            }
            // Agregar una celda para accion editar
            $tabla .= "<td><button class='btn actualizar-btn' onclick=\"cargarFormularioActualizar(" . json_encode($fila) . ",'container')\">Editar</button></td>";

            $tabla .= "</tr>";
        }
        $tabla .= "</tbody>";
        echo json_encode([
            'status' => 'success',
            'message' => 'Registros encontrados.',
            'tabla' => $tabla
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No se encontraron registros para el valor proporcionado.'
        ]);
    }
?>
