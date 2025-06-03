<?php
require_once 'conexion.php';
$conexion = conectarDB();

$tabla = $_POST['tabla'] ?? null;
$col = $_POST['columna'] ?? null;
$valor = $_POST['valor'] ?? null;

if (!$tabla || !$col || $valor === null) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Faltan parámetros necesarios.'
    ]);
    exit();
}

// Si el valor es un número y la columna es "id", no uses LIKE
$esBusquedaPorID = ($col === 'id' && is_numeric($valor));
$valorLike = '%' . $valor . '%'; // Para búsquedas parciales

if ($tabla !== 'empleados') {
    // Validar columnas permitidas para tablas generales (mejor con lista blanca)
    $consulta = $esBusquedaPorID
        ? "SELECT * FROM $tabla WHERE id = ? ORDER BY id ASC"
        : "SELECT * FROM $tabla WHERE $col LIKE ? ORDER BY id ASC";
} else {
    $columnasPermitidas = [
        'id' => 'e.id',
        'nombres' => 'e.nombres',
        'apellido_paterno' => 'e.apellido_paterno',
        'apellido_materno' => 'e.apellido_materno',
        'cargo' => 'c.cargo',
        'profesion' => 'p.profesion'
    ];

    if (!array_key_exists($col, $columnasPermitidas)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Columna no permitida para búsqueda en empleados.'
        ]);
        exit();
    }

    $consulta = $esBusquedaPorID
        ? "SELECT 
                e.id, 
                e.nombres, 
                e.apellido_paterno, 
                e.apellido_materno, 
                c.cargo AS cargo, 
                p.profesion AS profesion 
            FROM empleados e 
            INNER JOIN cargos c ON e.cargo_id = c.id 
            INNER JOIN profesiones p ON e.profesion_id = p.id 
            WHERE e.id = ? 
            ORDER BY e.id ASC"
        : "SELECT 
                e.id, 
                e.nombres, 
                e.apellido_paterno, 
                e.apellido_materno, 
                c.cargo AS cargo, 
                p.profesion AS profesion 
            FROM empleados e 
            INNER JOIN cargos c ON e.cargo_id = c.id 
            INNER JOIN profesiones p ON e.profesion_id = p.id 
            WHERE {$columnasPermitidas[$col]} LIKE ? 
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

$param = $esBusquedaPorID ? $valor : $valorLike;
$stmt->bind_param('s', $param);

if (!$stmt->execute()) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al ejecutar la consulta: ' . $stmt->error
    ]);
    exit();
}

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $primerRegistro = $resultado->fetch_assoc();
    $columnas = array_keys($primerRegistro);
    
    $tablaHTML = "<thead><tr>";
    foreach ($columnas as $columna) {
        $columnaMostrar = ucfirst(strtolower(str_replace('_', ' ', $columna)));
        $tablaHTML .= "<th>" . htmlspecialchars($columnaMostrar) . "</th>";
    }
    $tablaHTML .= "<th>Acción</th></tr></thead><tbody>";

    // Agregar el primer registro como la primera fila de la tabla
    // con el botón de acción para editar
    $tablaHTML .= "<tr>";
    foreach ($primerRegistro as $dato) {
        $tablaHTML .= "<td>" . htmlspecialchars($dato) . "</td>";
    }
    $tablaHTML .= "<td><button class='btn actualizar-btn' onclick=\"cargarFormularioActualizar('" . $tabla . "','".$primerRegistro['id'] . "','vista-consultar')\">Editar</button></td></tr>";

    // Agregar el resto de los registros
    while ($fila = $resultado->fetch_assoc()) {
        $tablaHTML .= "<tr>";
        foreach ($fila as $dato) {
            $tablaHTML .= "<td>" . htmlspecialchars($dato) . "</td>";
        }
        // Agregar botón de acción para cada fila pasando como parámetro el nombre de la tabla y el ID del registro
        $tablaHTML .= "<td><button class='btn actualizar-btn' onclick=\"cargarFormularioActualizar('" . $tabla . "','" . $fila['id'] . "','vista-consultar')\">Editar</button></td>";
        $tablaHTML .= "</tr>";
    }

    $tablaHTML .= "</tbody>";

    echo json_encode([
        'status' => 'success',
        'message' => 'Registros encontrados.',
        'tabla' => $tablaHTML
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No se encontraron registros para el valor proporcionado.'
    ]);
}
?>
