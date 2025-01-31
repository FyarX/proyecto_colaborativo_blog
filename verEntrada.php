<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['botonVerEntrada']) && isset($_POST['tituloEntrada'])) {
    require_once 'requires/conexion.php';
    
    $tituloEntrada = filter_var(trim($_POST['tituloEntrada']), FILTER_SANITIZE_STRING);

    if (empty($tituloEntrada)) {
        echo "El título de la entrada no puede estar vacío.<br>";
        header("refresh:1;url=index.php");
        exit();
    }
    
    $sql = "SELECT id, usuario_id, categoria_id, titulo, descripcion, fecha FROM entradas WHERE titulo = :titulo";
    $stmt = $pdo->prepare(query: $sql);
    $stmt->bindParam(':titulo', $tituloEntrada, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the entrada
    $entrada = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($entrada) {
        // Display entrada details
        echo '<h1>Entrada: ' . htmlspecialchars($entrada['titulo']) . '</h1>';
        echo '<p>Descripción: ' . htmlspecialchars($entrada['descripcion']) . '</p>';
        echo '<p>Fecha: ' . htmlspecialchars($entrada['fecha']) . '</p>';
        echo '<p>Usuario: ' . htmlspecialchars($entrada['usuario_id']) . '</p>';
        echo '<p>Categoría: ' . htmlspecialchars($entrada['categoria_id']) . '</p>';
        echo '<a href="index.php">Volver</a>';
    } else {
        echo "La entrada no existe.<br>";
        header("refresh:5;url=index.php");
        exit();
    }
} else {
    echo "Error en la solicitud POST";
    header("refresh:1;url=index.php");
    exit();
}
?>