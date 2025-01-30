<?php

session_start();

require_once 'requires/conexion.php';

// Validación de los datos enviados por el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/estilo.css">
    <title>Actualizar los Datos del Usuario</title>
</head>
<body>

<div class="main" style="border: 1px solid black; width: 30%; justify-content: center; align-items: center; margin: 0 auto; margin-top: 50px;">
    <h2 style="text-align: center;">Actualizar Datos</h2>
    <p>Por favor, actualiza los datos que desees cambiar:</p>
    <form action="actualizarUsuario.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required></br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" id="email" required></br>

        <label for="password">Nueva Contraseña (opcional):</label>
        <input type="password" name="password" id="password"></br>

        <button type="submit">Guardar Cambios</button></br>
    </form>
</div>
</body>
</html>