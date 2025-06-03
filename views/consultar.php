<?php
// Incluir el archivo de conexión a la base de datos 
require_once '../BD/obtenerRegistrosDeUnaTabla.php';

$tabla = $_GET['tabla']; // Obtener el nombre de la tabla desde la URL

$nombreTabla = ucfirst(strtolower($tabla)); // Convertir el nombre de la tabla a mayúsculas y minúsculas

$cargos = obtenerTodosLosRegistrosDeUnaTabla('cargos');
$profesiones = obtenerTodosLosRegistrosDeUnaTabla('profesiones');
?>

<div id="vista-consultar" class="container">
    <h2>Consultar <?= $nombreTabla ?></h2>

    <form class="form">

        <div class="form-group">
            <label>Buscar por:</label>

            <?php 
                if ($tabla === 'empleados') {
                    // Mostrar el campo de búsqueda específico para empleados
                    echo "<select id=\"columna\" name=\"columna\" required>";
                    echo "<option value=\"id\">ID</option>";
                    echo "<option value=\"nombres\">Nombre</option>";
                    echo "<option value=\"apellido_paterno\">Apellido Paterno</option>";
                    echo "<option value=\"apellido_materno\">Apellido Materno</option>";
                    echo "<option value=\"cargo\">Cargo</option>";
                    echo "<option value=\"profesion\">Profesión</option>";
                    echo "</select>";
                } else {
                    // Mostrar el campo de búsqueda genérico para otras tablas
                    echo "<select id=\"columna\" name=\"columna\" required>";
                    echo "<option value=\"id\">ID</option>";
                    //echo "<option value=\"nombre\">Nombre</option>";
                    if(substr($tabla, -2) === 'es') {
                        echo "<option value=\"" . substr($tabla, 0, -2) . "\">" . ucfirst(substr($tabla, 0, -2)) . "</option>";
                    } else {
                        echo "<option value=\"" . substr($tabla, 0, -1) . "\">" . ucfirst(substr($tabla, 0, -1)) . "</option>";
                    }

                    echo "</select>";
                }
            ?>
        </div>
        
        <?php if ($tabla === 'empleados'){ ?>
            <div class="form-group" id="busqueda-cargo" style="display: none;">
                <label>Seleccione Cargo:</label>
                <select id="cargo" name="cargo" required>
                    <?php
                    if ($cargos) {
                        //Mostrar un mensaje de selección con valor de cadena vacía
                        echo "<option value=\"\" disabled selected>Seleccionar...</option>";
                        // Recorrer los cargos y mostrarlos en el select
                        foreach ($cargos as $cargo) {
                            echo "<option value=\"{$cargo['cargo']}\">{$cargo['cargo']}</option>";
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
                            echo "<option value=\"{$profesion['profesion']}\">{$profesion['profesion']}</option>";
                        }
                    } else {
                        echo "<option value=\"\" disabled>No hay profesiones disponibles</option>";
                    }
                    ?>
                </select>
            </div>
        <?php } ?>

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