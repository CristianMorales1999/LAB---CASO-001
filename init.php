<?php

// Número de consultas que vamos a tener
$numConsultas = 10;

// Definición del arreglo de consultas numeradas
$consultas = array_map(fn($i) => "Consulta $i", range(1, $numConsultas));

// Definición del arreglo de opciones CRUD (reutilizable)
$opcionesCRUD = ['Registrar', 'Listar', 'Consultar', 'Actualizar', 'Eliminar'];

// Definición de las secciones que usan CRUD
$seccionesConCRUD = ['Empleados', 'Profesiones', 'Cargos'];

// Creación del menú
$menu = array_combine($seccionesConCRUD, array_fill(0, count($seccionesConCRUD), $opcionesCRUD));

// Agregando las consultas al menú
$menu['Consultas'] = $consultas;
?>
