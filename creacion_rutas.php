<?php

//Quiero crear una carpeta llamada views y dentro de ella quiero crear carpetas para cada una de las secciones que tengo en el menú, y dentro de cada carpeta quiero crear los archivos que corresponden a cada una de las opciones del menú. Por ejemplo, en la carpeta Empleados quiero crear los archivos registrar.php, listar.php, consultar.php, actualizar.php y eliminar.php. En la carpeta Profesiones quiero crear los archivos registrar.php, listar.php, consultar.php, actualizar.php y eliminar.php. En la carpeta Cargos quiero crear los archivos registrar.php, listar.php, consultar.php, actualizar.php y eliminar.php. En la carpeta Consultas quiero crear los archivos consulta1.php, consulta2.php, consulta3.php, consulta4.php, consulta5.php, consulta6.php, consulta7.php, consulta8.php, consulta9.php y consulta10.php.
// Crear la carpeta views si no existe
if (!file_exists('views')) {
    mkdir('views', 0777, true);
}
// Crear las carpetas y archivos para cada sección
foreach ($menu as $seccion => $opciones) {
    // Crear la carpeta para la sección
    if (!file_exists("views/$seccion")) {
        mkdir("views/$seccion", 0777, true);
    }
    // Crear los archivos para cada opción
    foreach ($opciones as $opcion) {
        $filename = strtolower(str_replace(' ', '_', $opcion)) . '.php';
        $filepath = "views/$seccion/$filename";
        if (!file_exists($filepath)) {
            file_put_contents($filepath, "<?php\n// Contenido de $filename\n echo '
            <h1>
                Bienvenido a la sección
                $seccion - Opción $opcion
            </h1>
            <p>
                Esta es la vista para la opción $opcion en la sección $seccion.
            </p>
            '?>");
        }
    }
}
// Crear archivo que indica que ya se ejecutó
file_put_contents($flagFile, 'Rutas creadas el ' . date('Y-m-d H:i:s'));
?>
