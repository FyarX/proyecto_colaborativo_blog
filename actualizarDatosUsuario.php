<?php

session_start();

require_once 'requires/conexion.php';

if (!isset($_SESSION['usuario']['id'])) {
    echo "Error: Usuario no autenticado.";
    exit;
}

$usuario_id = $_SESSION['usuario']['id'];

// Validación de los datos enviados por el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

// Verificación de que el email no esté vacío
if (empty($email)) {
    $error_message = "El campo de correo electrónico no puede estar vacío.";
} else {
    // Verificación de existrencia en la base de datos
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $error_message = "El correo electrónico ya está registrado.";
    } else {
try {

    //? CONSULTA A LA BASE DE DATOSç
        
        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";

        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, password = :hashed_password WHERE id = :id";
        }
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if (!empty($password)) {
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        }
        $stmt->execute();

        //? ACTUALIZACIÓN DE DATOS DE SESIÓN 
        $_SESSION['usuario']['nombre'] = $nombre;
        $_SESSION['usuario']['email'] = $email;

        echo "<script> 
                    window.scrollTo(0, 0.2 * window.innerHeight);
                    alert('Datos actualizados correctamente.'); 
                    window.location.href = '../index.php';
                </script>";
        
                header("Location:index.php");
                exit;
} catch (PDOException $e) {
    echo "Error al actualizar los datos del usuario: " . $e->getMessage();
}
}
}
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

<section class="content" style="border: 1px solid black; width: 30%; justify-content: center; align-items: center; margin: 0 auto; margin-top: 50px;">
    <h2 style="text-align: center;">Actualizar Datos</h2>
    <p>Por favor, actualiza los datos que desees cambiar:</p>
    <form action="actualizarDatosUsuario.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required></br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" id="email" required></br>

        <label for="password">Nueva Contraseña (opcional):</label>
        <input type="password" name="password" id="password"></br>

        <button type="submit">Guardar Cambios</button></br>
    </form>
</>
</body>
</html>