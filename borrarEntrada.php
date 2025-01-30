<?php
require_once "requires/conexion.php";

// Verificar si existe un ID de entrada
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Borrar la entrada de la base de datos
    $stmt = $pdo->prepare("DELETE FROM entradas WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Entrada eliminada con éxito.";
        header("Location: listarEntradas.php"); // Redirigir a la lista de entradas
        exit();
    } else {
        echo "Error al eliminar la entrada.";
    }
} else {
    echo "ID de entrada no especificado.";
    exit;
}
