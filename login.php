<?php

session_start();

require_once 'requires/conexion.php';

// Verificar si las cookies existen
if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $email = $_COOKIE['email'];
    $password = base64_decode($_COOKIE['password']);
    
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch();
        if (password_verify($password, $user['password'])) {
            $_SESSION['loginExito'] = true;
            $_SESSION['errorInicioSesion'] = 0;
        }
    }
}

// 7. Definimos una variable de sesión para controlar los 3 intentos fallidos de inicio de sesión
$_SESSION['errorInicioSesion'] = $_SESSION['errorInicioSesion'] ?? 0;
$_SESSION['ultimoIntento'] = $_SESSION['ultimoIntento'] ?? time();
$_SESSION['loginExito'] = $_SESSION['loginExito'] ?? false;

// 6. Formulario de Inicio de Sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['botonLogin']) && $_SESSION['errorInicioSesion'] < 3) {
    // Comprobamos que el email es válido
    $email = filter_var(trim($_POST['emailLogin']), FILTER_VALIDATE_EMAIL);
    // Comprobamos que la contraeña es válida
    $password = trim($_POST['passwordLogin']);

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            if (password_verify($password, $user['password'])) {
                $_SESSION['errorInicioSesion'] = 0;
                $_SESSION['loginExito'] = true;

                // Si el usuario quiere ser recordado, establecemos una cookie
                if (isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'on') {
                    // Aquí usamos un ejemplo simple, pero es recomendable usar un token de seguridad para la cookie.
                    setcookie('email', $email, time() + 3600 * 24 * 30, "/"); // 30 días
                    setcookie('password', base64_encode($password), time() + 3600 * 24 * 30, "/");
                }

            } else {
                $_SESSION['errorPassLogin'] = "La contraseña no es correcta.";
                $_SESSION['errorInicioSesion']++;
                $_SESSION['ultimoIntento'] = time(); // Guardo la hora del ultimo intento fallido
            }
        } else {
            echo "El email no existe en nuestra Base de Datos";
        }
    } else {
        echo "El email o contraseña errónea";
    }
    header("Location: index.php");
    exit();
}

// 7. Controlamos los 3 intentos fallidos de inicio de sesión
echo "Error inicio sesion" . var_dump($_SESSION['errorInicioSesion']);
echo "ultimo intento: " . var_dump($_SESSION['ultimoIntento']);
if ($_SESSION['errorInicioSesion'] >= 3) {
    $tiempoRestante = time() - $_SESSION['ultimoIntento'];
    if ($tiempoRestante < 5) {
        // Bloqueo al usuario durante 5 segundos
        echo "<script> 
        setTimeout(function() {
            window.location.reload();
        }, 5000);
        </script>";
    } else {
        // Hacemos un reset de los errores si han pasado más de 5 segundos
        $_SESSION['errorInicioSesion'] = 0;
    }
}
