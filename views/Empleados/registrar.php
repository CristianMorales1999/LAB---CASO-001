
<?php
    require_once 'BD/obtenerTodosLosRegistroDeUnaTabla.php';

    $cargos = obtenerTodosLosRegistrosDeUnaTabla('cargos');
    $profesiones = obtenerTodosLosRegistrosDeUnaTabla('profesiones');
?>
<div id="contenedor" class="container">
  <h2>Contactarnos</h2>
  <form class="form">
    <label>Nombre</label>
    <input type="text" id="nombre" name="nombre" placeholder="Tu nombre completo" required>

    <label>Apellido Paterno</label>
    <input type="text" id="apellidoPaterno" name="apellidoPaterno" placeholder="Tu apellido paterno" required>

    <label>Apellido Materno</label>
    <input type="text" id="apellidoMaterno" name="apellidoMaterno" placeholder="Tu apellido materno" required>

    <!-- <label>Email</label>
    <input type="email" id="correo" name="correo" placeholder="tucorreo@ejemplo.com" required> -->
    <!-- <label>Teléfono</label>
    <input type="tel" id="telefono" name="telefono" placeholder="999999999" required> -->

    <label>Cargo</label>
    <select id="cargo" name="cargo" required>
        <?php
        if ($cargos) {
            // Mostrar opcion por defecto
            echo "<option value=\"\" disabled selected>Seleccionar...</option>";
            foreach ($cargos as $cargo) {
                echo "<option value=\"{$cargo['nombre']}\">{$cargo['nombre']}</option>";
            }
        } else {
            echo "<option value=\"\" disabled>No hay cargos disponibles</option>";
        }
        ?>
    </select>

    <label>Profesión</label>
    <select id="profesion" name="profesion" required>
        <?php
        if ($profesiones) {
            // Mostrar opcion por defecto
            echo "<option value=\"\" disabled selected>Seleccionar...</option>";
            foreach ($profesiones as $profesion) {
                echo "<option value=\"{$profesion['nombre']}\">{$profesion['nombre']}</option>";
            }
        } else {
            echo "<option value=\"\" disabled>No hay profesiones disponibles</option>";
        }
        ?>
    </select>

    <!-- <label>Servicio</label>
    <select id="servicio" name="servicio" required>
      <option value="" disabled selected>Seleccionar...</option>
      <option value="Información General">Información General</option>
      <option value="TI">TI</option>
      <option value="Teléfono">Teléfono</option>
    </select> -->
    <!-- <label>Consulta</label>
    <textarea id="consulta" name="consulta" placeholder="Escribe tu mensaje aquí..." rows="4"></textarea> -->

    <div class="form-buttons">
      <button type="button" class="btn" onclick="validarFormularioYRegistrar('empleados','container');">Enviar</button>
      <button type="reset" class="btn cancel">Cancelar</button>
    </div>
  </form>
</div>