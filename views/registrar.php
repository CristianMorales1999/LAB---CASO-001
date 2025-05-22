<?php
    // Incluir el archivo de conexión a la base de datos 
    require_once '../BD/obtenerRegistrosDeUnaTabla.php';

    $tabla = $_GET['tabla']; // Obtener el nombre de la tabla desde la URL

    if($tabla == 'empleados'){
        $cargos = obtenerTodosLosRegistrosDeUnaTabla('cargos');
        $profesiones = obtenerTodosLosRegistrosDeUnaTabla('profesiones');
    }

    $nombreTabla = $tabla;
    // Convertir el nombre de la tabla a singular
    if (substr($nombreTabla, -2) == 'es') {
        $nombreTabla = substr($nombreTabla, 0, -2);
    }else if (substr($nombreTabla, -1) == 's') {
        $nombreTabla = substr($nombreTabla, 0, -1);
    }
    // Capitalizar la primera letra del nombre de la tabla
    $nombreTabla = ucfirst(strtolower($nombreTabla));
?>

<div id="contenedor" class="container">
    <h2>Registrar <?php echo $nombreTabla ?></h2>
    <form class="form">

        <?php 
            if($tabla=='empleados'){
                //Label para el nombre, apellido paterno y apellido materno
                echo "<label>Nombre</label>";
                echo "<input type=\"text\" id=\"nombre\" name=\"nombre\" placeholder=\"Tu nombre completo\" required>";
                echo "<label>Apellido Paterno</label>";
                echo "<input type=\"text\" id=\"apellidoPaterno\" name=\"apellidoPaterno\" placeholder=\"Tu apellido paterno\" required>";
                echo "<label>Apellido Materno</label>";
                echo "<input type=\"text\" id=\"apellidoMaterno\" name=\"apellidoMaterno\" placeholder=\"Tu apellido materno\" required>";
                //Label para el cargo
                echo "<label>Cargo</label>";
                echo "<select id=\"cargo\" name=\"cargo\" required>";
                if ($cargos) {
                    echo "<option value=\"\" disabled selected>Seleccionar...</option>";
                    foreach ($cargos as $cargo) {
                        echo "<option value=\"{$cargo['id']}\">{$cargo['cargo']}</option>";
                    }
                } else {
                    echo "<option value=\"\" disabled>No hay cargos disponibles</option>";
                }
                echo "</select>";
                //Label para la profesion
                echo "<label>Profesión</label>";
                echo "<select id=\"profesion\" name=\"profesion\" required>";
                if ($profesiones) {
                    echo "<option value=\"\" disabled selected>Seleccionar...</option>";
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
        <div class="form-buttons">
            <button type="button" class="btn" onclick="validarFormularioYRegistrar('<?php echo $tabla ?>','container');">Enviar</button>
            <button type="reset" class="btn cancel">Cancelar</button>
        </div>
    </form>
</div>