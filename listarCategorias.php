<?php

//! ---------------- LISTAR DE CATEGORIAS ----------------

// Incluir conexión a la base de datos y a la función conseguirCategorias
require_once 'requires/conexion.php';
require_once 'functions/conseguirCategorias.php';

$categorias = conseguirCategorias($pdo);


?>