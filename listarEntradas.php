<?php
require_once "requires/conexion.php";
require_once "functions/conseguirUltimasEntradas.php";

// Obtener las últimas entradas desde la base de datos
$entradas = conseguirUltimasEntradas ($pdo);
?>

