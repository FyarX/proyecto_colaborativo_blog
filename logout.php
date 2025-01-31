<?php 

session_start();

// Eliminar las cookies de "Recordarme"
setcookie('email', '', time() - 3600, "/"); // Expira inmediatamente
setcookie('password', '', time() - 3600, "/"); // Expira inmediatamente

// Eliminar todas las variables de sesión y destruirla
session_unset();
session_destroy();


echo "Sesión Cerrada con éxito";
// Redirigir después de un pequeño retraso
echo "<script> 
        setTimeout(function(){
            window.location.href = 'index.php';}, 1300); 
    </script>";
?>
