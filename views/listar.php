<?php
  // Incluir el archivo de conexión a la base de datos 
  require_once '../BD/obtenerRegistrosDeUnaTabla.php';

  $tabla = $_GET['tabla']; // Obtener el nombre de la tabla desde la URL
  //Llamar la función para obtener todos los registros de la tabla Empleados
  $resultado = obtenerTodosLosRegistrosDeUnaTabla($tabla);
?>

<div id="listado" class="container">
  <h2>Lista de <?php echo ucfirst(strtolower($tabla));?></h2>
  <table>
    <thead>
      <tr>
        <?php
            // Obtener los nombres de las columnas
            $columnas = array_keys($resultado[0]);
            // Recorrer los nombres de las columnas y mostrarlas en la tabla
            foreach ($columnas as $columna) {
                $columna = str_replace('_', ' ', $columna);
                $columna = preg_replace('/(?<!^)(?=[A-Z])/', ' ', $columna);
                $columna = preg_replace('/\s+/', ' ', $columna);
                $columna = trim($columna);
                $columna = ucfirst(strtolower($columna));
                // Mostrar el nombre de la columna
                echo "<th>" . $columna . "</th>";
            }
        ?>
      </tr>
    </thead>
    <tbody>
      <?php
         //Validar si hay registros
      if ($resultado && is_array($resultado) && count($resultado) > 0) {
        // Recorrer los registros y mostrarlos en la tabla
        foreach ($resultado as $row) {
          echo "<tr>";
          foreach ($row as $columna) {
            echo "<td>" . htmlspecialchars($columna) . "</td>";
          }
          echo "</tr>";
        }
      } else {
        // No hay registros
        echo "<tr><td colspan='" . count($columnas) . "'>No hay registros disponibles</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>
