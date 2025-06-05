<?php
  // Incluir el archivo de conexión a la base de datos 
  require_once '../BD/buscarRegistrosDeTablasPorNroDeConsulta.php';

  $nroDeConsulta = $_GET['nroDeConsulta']; // Obtener el nombre de la tabla desde la URL

  $resultado=obtenerResultadosDeUnaDeterminadaConsulta($nroDeConsulta);
  $nColumnas=1;
?>

<div id="listado" class="container">
  <h2>Resultados de consulta <?php echo $nroDeConsulta?></h2>
  <table>
    <thead>
      <tr>
        <?php
          if ($resultado && is_array($resultado) && count($resultado) > 0) {
            // Obtener los nombres de las columnas
            $columnas = array_keys($resultado[0]);
            $nColumnas=0;
            // Recorrer los nombres de las columnas y mostrarlas en la tabla
            foreach ($columnas as $columna) {
                $columna = str_replace('_', ' ', $columna);
                $columna = preg_replace('/(?<!^)(?=[A-Z])/', ' ', $columna);
                $columna = preg_replace('/\s+/', ' ', $columna);
                $columna = trim($columna);
                $columna = ucfirst(strtolower($columna));
                // Mostrar el nombre de la columna
                echo "<th>" . $columna . "</th>";
                $nColumnas++;
            }
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
        echo "<tr><td colspan='" . $nColumnas . "'>No hay registros disponibles</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>
