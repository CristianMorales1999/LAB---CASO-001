<?php
  require_once '../helpers.php';
  $nombreTabla=convertirASingularCapitalizado($tabla);
?>
<div id="formulario-actualizar" class="container" style="display: none;">
  <!-- Mostrar el nombre de la tabla en singular dependiendo del la terminacion de la tabla-->

  <h2>Actualizar <?= $nombreTabla ?>
  </h2>
  <form class="form" id="formulario-actualizar">
    
    <!-- Campo ID oculto -->
    <input type="hidden" id="table-id">
      
    <?php
      if($tabla=='empleados'){
        echo "<label>Nombre</label>";
        echo "<input type='text' id='nombre' name='nombre' placeholder='Tu nombre completo' required>";

        echo "<label>Apellido Paterno</label>";
        echo "<input type='text' id='apellidoPaterno' name='apellidoPaterno' placeholder='Tu apellido paterno' required>";

        echo "<label>Apellido Materno</label>";
        echo "<input type='text' id='apellidoMaterno' name='apellidoMaterno' placeholder='Tu apellido materno' required>";

        echo "<label>Cargo</label>";
        echo "<select id='cargo-actualizar' name='cargo' required>";
        echo "<option value='' disabled selected>Seleccionar...</option>";

        if ($cargos) {
          foreach ($cargos as $cargo) {
            echo "<option value=\"{$cargo['id']}\">{$cargo['cargo']}</option>";
          }
        } else {
          echo "<option value=\"\" disabled>No hay cargos disponibles</option>";
        }
        echo "</select>";

        echo "<label>Profesión</label>";
        echo "<select id='profesion-actualizar' name='profesion' required>";
        echo "<option value='' disabled selected>Seleccionar...</option>";

        if ($profesiones) {
          foreach ($profesiones as $profesion) {
            echo "<option value=\"{$profesion['id']}\">{$profesion['profesion']}</option>";
          }
        } else {
          echo "<option value=\"\" disabled>No hay profesiones disponibles</option>";
        }
        echo "</select>";
      }else{
        //Label para el nombre de la tabla
        echo "<label>" . $nombreTabla. "</label>";
        echo "<input type=\"text\" id=\"" . strtolower($nombreTabla) . "\" name=\"" . $nombreTabla . "\" placeholder=\"Tu " . $nombreTabla . "\" required>";
      }
    ?>

    <!-- Botones de acción -->
    <div class="form-buttons">
      <button type="button" class="btn" onclick="validarFormularioYRegistrar('<?= $tabla ?>','<?= $urlDeRetorno ?>','update')">Actualizar</button>

      <button type="button" class="btn cancel" onclick="cancelarEdicion('formulario-actualizar','vista-consultar')">Cancelar</button>
    </div>

  </form>
</div>
