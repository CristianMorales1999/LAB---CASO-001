<?php
// Incluir el archivo de conexión a la base de datos 
require_once '../../BD/obtenerRegistrosDeUnaTabla.php';

$empleados = obtenerTodosLosRegistrosDeUnaTabla('empleados');
?>

<div id="vista-actualizar" class="container">
    <h2>Actualizar Empleado</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Cargo</th>
                <th>Profesion</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($empleados) {
                foreach ($empleados as $empleado) {
                    echo "<tr>";
                    echo "<td>{$empleado['id']}</td>";
                    echo "<td>{$empleado['nombres']}</td>";
                    echo "<td>{$empleado['apellido_paterno']}</td>";
                    echo "<td>{$empleado['apellido_materno']}</td>";
                    echo "<td>{$empleado['cargo']}</td>";
                    echo "<td>{$empleado['profesion']}</td>";
                    echo "<td><button class='btn' onclick='editarEmpleado({$empleado['id']})'>Editar</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay empleados registrados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
//Variable de archivo padre de donde fué llamado
$urlDeRetorno = "actualizar.php";
//Incluir archivo de formularioActualizar.php
require_once "formulario-actualizar.php";
?>