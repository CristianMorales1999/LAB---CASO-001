<?php
require_once '../../BD/obtenerRegistrosDeUnaTabla.php';

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

        <label>Cargo</label>
        <select id="cargo" name="cargo" required>
            <?php
            if ($cargos) {
                echo "<option value=\"\" disabled selected>Seleccionar...</option>";
                foreach ($cargos as $cargo) {
                    echo "<option value=\"{$cargo['id']}\">{$cargo['cargo']}</option>";
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
                echo "<option value=\"\" disabled selected>Seleccionar...</option>";
                foreach ($profesiones as $profesion) {
                    echo "<option value=\"{$profesion['id']}\">{$profesion['profesion']}</option>";
                }
            } else {
                echo "<option value=\"\" disabled>No hay profesiones disponibles</option>";
            }
            ?>
        </select>


        <div class="form-buttons">
            <button type="button" class="btn" onclick="validarFormularioYRegistrar('empleados','container');">Enviar</button>
            <button type="reset" class="btn cancel">Cancelar</button>
        </div>
    </form>
</div>