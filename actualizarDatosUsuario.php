<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar los Datos del Usuario</title>
</head>
<body>

<h1 class="title" style="text-align: center;">Actualizar Datos del Usuario</h1>

<form action="actualizarUsuario.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

        <label for="password">Nueva Contraseña (opcional):</label>
        <input type="password" name="password" id="password">

        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>