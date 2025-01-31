<?php
session_start();
require_once 'requires/conexion.php';

require_once 'requires/conexion.php';

// Inicializamos las variables de sesión para control de intentos
$_SESSION['errorInicioSesion'] = $_SESSION['errorInicioSesion'] ?? 0;
$_SESSION['ultimoIntento'] = $_SESSION['ultimoIntento'] ?? time();
$_SESSION['loginExito'] = $_SESSION['loginExito'] ?? false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['botonLogin']) && $_SESSION['errorInicioSesion'] < 3) {
    $email = filter_var(trim($_POST['emailLogin']), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['passwordLogin']);

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            if (password_verify($password, $user['password'])) {
                $_SESSION['errorInicioSesion'] = 0; // Reiniciamos los intentos
                $_SESSION['loginExito'] = true;

                // Guardamos los datos del usuario en la sesión
                $_SESSION['usuario'] = [
                    'id' => $user['id'], 
                    'nombre' => $user['nombre'],
                    'email' => $user['email']
                ];

                header("Location: index.php");
                exit();
            } else {
                $_SESSION['errorPassLogin'] = "La contraseña no es correcta.";
                $_SESSION['errorInicioSesion']++;
                $_SESSION['ultimoIntento'] = time();
            }
        } else {
            echo "El email no existe en nuestra Base de Datos";
        }
    } else {
        echo "El email o contraseña errónea";
    }
}

// Bloqueo de intentos fallidos
if ($_SESSION['errorInicioSesion'] >= 3) {
    $tiempoRestante = time() - $_SESSION['ultimoIntento'];
    if ($tiempoRestante < 5) {
        echo "<script> 
        setTimeout(function() {
            window.location.reload();
        }, 5000);
        </script>";
    } else {
        $_SESSION['errorInicioSesion'] = 0; // Reset después de 5 segundos
    }
}

// Para depuración, mejor usar logs en lugar de var_dump()
error_log("Error inicio sesion: " . $_SESSION['errorInicioSesion']);
error_log("Último intento: " . $_SESSION['ultimoIntento']);
?>
