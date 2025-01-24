<?php

//! ---------------- LISTAR CATEGORIAS ----------------

// Incluir conexión a la base de datos y a la función conseguirCategorias
require_once 'requires/conexion.php';
require_once 'functions/conseguirCategorias.php';

// Llamar a la función conseguirCategorias y guardar el resultado en la variable $categorias
$categorias = conseguirCategorias($pdo);


?>
