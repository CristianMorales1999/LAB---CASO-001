<?php
// Incluir el archivo de conexión a la base de datos 
require_once '../../BD/obtenerRegistrosDeUnaTabla.php';

$tabla = $_GET['tabla']; // Obtener el nombre de la tabla desde la URL

$cargos = obtenerTodosLosRegistrosDeUnaTabla('cargos');
$profesiones = obtenerTodosLosRegistrosDeUnaTabla('profesiones');
?>

<div id="vista-consultar" class="container">
    <h2>Consultar Empleados</h2>
    <form class="form">

        <div class="form-group">
            <label>Buscar por:</label>
            <select id="columna" name="columna" required>
                <option value="nombres">Nombre</option>
                <option value="apellido_paterno">Apellido Paterno</option>
                <option value="apellido_materno">Apellido Materno</option>
                <option value="cargo_id">Cargo</option>
                <option value="profesion_id">Profesión</option>
            </select>
        </div>

        <div class="form-group" id="busqueda-cargo" style="display: none;">
            <label>Seleccione Cargo:</label>
            <select id="cargo" name="cargo" required>
                <?php
                if ($cargos) {
                    //Mostrar un mensaje de selección con valor de cadena vacía
                    echo "<option value=\"\" disabled selected>Seleccionar...</option>";
                    // Recorrer los cargos y mostrarlos en el select
                    foreach ($cargos as $cargo) {
                        echo "<option value=\"{$cargo['id']}\">{$cargo['cargo']}</option>";
                    }
                } else {
                    echo "<option value=\"\" disabled>No hay cargos disponibles</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group" id="busqueda-profesion" style="display: none;">
            <label>Seleccione Profesión:</label>
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
        </div>

        <div class="form-group">
            <input type="text" id="busqueda" name="busqueda" placeholder="Ingrese criterio de búsqueda">
        </div>

        <button type="button" class="btn" onclick="buscarItemPorCampo('<?= $tabla ?>','tabla','mensaje')">Buscar</button>
        <button type="button" class="btn cancel" onclick="cancelarBusqueda()">Cancelar</button>

    </form>

    <!-- Contenedor para los mensajes -->
    <div id="mensaje"></div>

    <!-- Contenedor para los resultados -->
    <table id="tabla"></table>
</div>


<?php
//Variable de archivo padre de donde fué llamado
$urlDeRetorno = "listar.php";
//Incluir archivo de formularioActualizar.php
require_once "formulario-actualizar.php";
?>