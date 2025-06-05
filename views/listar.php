<?php
  // Incluir el archivo de conexión a la base de datos 
  require_once '../BD/obtenerRegistrosDeUnaTabla.php';

  $tabla = $_GET['tabla']; // Obtener el nombre de la tabla desde la URL

  $accion = $_GET['accion'] ?? null; //Si se manda parámetro de accion "Eliminar" o "Actualizar"
  if($accion){
    $accion = ($accion && $accion=="actualizar") ? "Editar" : ucfirst($accion);
    if($tabla=="empleados"){
        $cargos = obtenerTodosLosRegistrosDeUnaTabla('cargos');
        $profesiones = obtenerTodosLosRegistrosDeUnaTabla('profesiones');
    }
  }
  

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
            if($accion){//Mostrar el nombre de la columna de acción si la hubiera
                echo "<th>Acción</th>";
                $nColumnas++;
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
          if($accion){//Si hay una accion que se muestre
            echo "<td><button class='btn actualizar-btn' onclick=\"cargarFormularioActualizar('" . $tabla . "','" . $row['id'] . "','listado')\">".$accion."</button></td>";
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

<?php
if($accion){
  //Variable de archivo padre de donde fué llamado
  $urlDeRetorno = "views/listar.php";
  $idContenedorAMostar="listado";
  //Incluir archivo de formularioActualizar.php
  require_once "formulario-actualizar.php";
}
?>
