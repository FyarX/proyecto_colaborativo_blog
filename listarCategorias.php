<?php

//! ---------------- LISTAR DE CATEGORIAS ----------------

// Incluir conexión a la base de datos y a la función conseguirCategorias
require_once 'requires/conexion.php';
require_once 'functions/conseguirCategorias.php';

$categorias = conseguirCategorias($conexion);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Categorias</title>
</head>
<body>
    <h1>Listado de Categorias</h1>

</body>
</html>