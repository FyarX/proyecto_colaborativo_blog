<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['asunto']) && isset($_POST['mensaje'])) {
        require_once 'requires/conexion.php';

        $nombre_persona = filter_var(trim($_POST['nombre']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email_persona = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
        $asunto_persona = filter_var(trim($_POST['asunto']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $mensaje_persona = filter_var(trim($_POST['mensaje']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     

        $sql = "INSERT INTO contacto (nombre, correo, asunto, mensaje) VALUES (:nombre, :correo, :asunto, :mensaje)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([
            ':nombre' => $nombre_persona,
            ':correo' => $email_persona,
            ':asunto' => $asunto_persona,
            ':mensaje' => $mensaje_persona
        ])) {
            echo "Mensaje enviado correctamente.<br>";
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "Error al enviar el mensaje: " . $errorInfo[2] . "<br>";
        }        
       
        header("refresh:2;url=contacto.php");
        exit();
    } else {
        echo "Error en la solicitud POST: ";
        
    }
} catch (Exception $e) {
    echo "Excepción capturada: " . $e->getMessage() . "<br>";
}
?>