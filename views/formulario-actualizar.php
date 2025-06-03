<div id="formulario-actualizar" class="container" style="display: none;">
  <!-- Mostrar el nombre de la tabla en singular dependiendo del la terminacion de la tabla-->

  <h2>Actualizar 
    <?php if(substr($tabla, -2) === 'es'){
      echo ucfirst(substr($tabla, 0, -2));
    }else{
      echo ucfirst(substr($tabla, 0, -1));
    } ?>
  </h2>
  <form class="form" id="formulario-actualizar">
    
    <!-- Campo ID oculto -->
    <input type="hidden" id="table-id">
      
    <?php
      if($tabla=='empleados'){
        echo "<label>Nombre</label>";
        echo "<input type='text' id='nombre' name='nombre' placeholder='Tu nombre completo' required>";

        echo "<label>Apellido Paterno</label>";
        echo "<input type='text' id='apellido-paterno' name='apellido-paterno' placeholder='Tu apellido paterno' required>";

        echo "<label>Apellido Materno</label>";
        echo "<input type='text' id='apellido-materno' name='apellido-materno' placeholder='Tu apellido materno' required>";

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
        // Si la tabla no es empleados, se muestra el formulario para el resto de las tablas
        if(substr($tabla, -2) === 'es') {
          echo "<label>".ucfirst(substr($tabla, 0, -2))."</label>";
          echo "<input type='text' id='nombre' name='nombre' placeholder='Tu ".ucfirst(substr($tabla, 0, -2))."' required>";
        } else {
          echo "<label>".ucfirst(substr($tabla, 0, -1))."</label>";
          echo "<input type='text' id='nombre' name='nombre' placeholder='Tu ".ucfirst(substr($tabla, 0, -1))."' required>";
        }
      }
    ?>

    <!-- Botones de acción -->
    <div class="form-buttons">
      <button type="button" class="btn" onclick="validarFormularioYRegistrar('<?= $urlDeRetorno ?>','update')">Actualizar</button>

      <button type="button" class="btn cancel" onclick="cancelarEdicion('formulario-actualizar','container')">Cancelar</button>
    </div>

  </form>
</div>
