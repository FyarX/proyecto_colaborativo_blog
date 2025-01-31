<?php
require_once "requires/conexion.php";

// Verificar si existe un ID de entrada
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos de la entrada desde la base de datos
    $stmt = $pdo->prepare("SELECT * FROM entradas WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $entrada = $stmt->fetch();

    // Si no se encuentra la entrada, redirigir
    if (!$entrada) {
        echo "Entrada no encontrada.";
        exit;
    }

    // Verificar si el formulario de edición se ha enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titulo = trim($_POST['titulo']);
        $descripcion = trim($_POST['descripcion']);
        $categoria = trim($_POST['categoria']);

        // Actualizar la entrada en la base de datos
        $stmt = $pdo->prepare("UPDATE entradas SET titulo = :titulo, descripcion = :descripcion, categoria = :categoria WHERE id = :id");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo "Entrada actualizada con éxito.";
            header("Location: listarEntradas.php"); // Redirigir a la lista de entradas
            exit();
        } else {
            echo "Error al actualizar la entrada.";
        }
    }
} else {
    echo "ID de entrada no especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Entrada</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>
<body>
    <main>
        <h1>Editar Entrada</h1>
        <form method="POST">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" value="<?= htmlspecialchars($entrada['titulo']) ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" required><?= htmlspecialchars($entrada['descripcion']) ?></textarea>

            <label for="categoria">Categoría:</label>
            <input type="text" name="categoria" value="<?= htmlspecialchars($entrada['categoria']) ?>" required>

            <button type="submit">Actualizar Entrada</button>
        </form>
        <a href="listarEntradas.php">Volver a la lista</a>
    </main>
</body>
</html>
