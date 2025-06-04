<div id="formulario-actualizar" class="container" style="display: none;">
  <h2>Actualizar <?= $nombreTabla ?></h2>
  <form class="form" id="formulario-actualizar">
    
    <!-- Campo ID oculto -->
    <input type="hidden" id="empleado-id">

    <!--Campos editables de tabla empleados-->
    <label>Nombre</label>
    <input type="text" id="nombre" name="nombre" placeholder="Tu nombre completo" required>

    <label>Apellido Paterno</label>
    <input type="text" id="apellidoPaterno" name="apellidoPaterno" placeholder="Tu apellido paterno" required>

    <label>Apellido Materno</label>
    <input type="text" id="apellidoMaterno" name="apellidoMaterno" placeholder="Tu apellido materno" required>

    <!-- Cargo -->
    <label>Cargo</label>
    <select id="cargo" name="cargo" required>
      <option value="" disabled selected>Seleccionar...</option>
      <?php
      if ($cargos) {
        foreach ($cargos as $cargo) {
          echo "<option value=\"{$cargo['id']}\">{$cargo['cargo']}</option>";
        }
      } else {
        echo "<option value=\"\" disabled>No hay cargos disponibles</option>";
      }
      ?>
    </select>
    
    <!-- Profesión -->
    <label>Profesión</label>
    <select id="profesion" name="profesion" required>
      <option value="" disabled selected>Seleccionar...</option>
      <?php
      if ($profesiones) {
        foreach ($profesiones as $profesion) {
          echo "<option value=\"{$profesion['id']}\">{$profesion['profesion']}</option>";
        }
      } else {
        echo "<option value=\"\" disabled>No hay profesiones disponibles</option>";
      }
      ?>
    </select>
    
    <!-- Botones de acción -->
    <div class="form-buttons">
      <button type="button" class="btn" onclick="validarFormularioYRegistrar('<?= $urlDeRetorno ?>','update')">Actualizar</button>

      <button type="button" class="btn cancel" onclick="cancelarEdicion('formulario-actualizar','container')">Cancelar</button>
    </div>

  </form>
</div>
