<?php
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
