<?php 
// 1. Iniciamos sesión
session_start();

require_once 'requires/conexion.php';

$_SESSION['loginExito'] = $_SESSION['loginExito'] ?? false;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets\css\contacto.css">
    <title>Contacto</title>
</head>
<body>
<header>
        <h1>Blog de Videojuegos</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="#">Acción</a></li>
                <li><a href="#">Rol</a></li>
                <li><a href="#">Deportes</a></li>
                <li><a href="#">Responsabilidad</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>
    <form action="" method="POST">
        <fieldset>
            <legend>¿Quieres contactar con nosotros?</legend>
            <label for="nombre">Nombre:</label>
            <input type="text" placeholder="Introduce tu nombre" name="nombre" id="nombre">
            <label for="correo">Correo-electronico</label>
            <input type="text" placeholder="Introduce tu correo" name="correo" id="correo">
            <label for="asunto">Asunto:</label>
            <input type="text" placeholder="Introduce el asunto" name="asunto" id="asunto">
            <label for="mensaje">Mensaje</label>
            <textarea name="mensaje" id="mensaje" cols="30" rows="10"></textarea>
            <input type="submit" value="Enviar">
            <input type="reset" value="borrar">
        </fieldset>
    </form>    
</body>
</html>