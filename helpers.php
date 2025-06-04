<?php 

function convertirASingularCapitalizado($palabraEnPlural){
    // Convertir el nombre de la tabla a singular
    if (substr($palabraEnPlural, -2) == 'es') {
        $palabraEnPlural = substr($palabraEnPlural, 0, -2);
    }else if (substr($palabraEnPlural, -1) == 's') {
        $palabraEnPlural = substr($palabraEnPlural, 0, -1);
    }
    // Capitalizar la primera letra del nombre de la tabla
    $palabraEnSingularCapitalizada = ucfirst(strtolower($palabraEnPlural));
    return $palabraEnSingularCapitalizada;
}

?>