<?php
session_start();
require_once '../requires/conexion.php';

// Recoger el término de búsqueda desde el formulario
$termino = isset($_GET['query']) ? trim($_GET['query']) : '';

// Si no hay término, redirigir al index
if (empty($termino)) {
    header("Location: ../index.php");
    exit();
}

try {
    // Consulta SQL para buscar entradas cuyo título contenga el término de búsqueda
    $sql = "SELECT e.id, e.titulo, e.descripcion, c.nombre AS categoria, 
                   u.nombre AS autor, e.fecha 
            FROM entradas e
            INNER JOIN categorias c ON e.categoria_id = c.id
            INNER JOIN usuarios u ON e.usuario_id = u.id
            WHERE e.titulo LIKE :termino
            ORDER BY e.fecha DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':termino', "%$termino%", PDO::PARAM_STR);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al realizar la búsqueda: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body>
    <?php require_once '../requires/header.php'; ?>

    <main>
        <h1>Resultados de Búsqueda para "<?= htmlspecialchars($termino) ?>"</h1><br>

        <?php if (!empty($resultados)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Autor</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $resultado): ?>
                        <tr>
                            <td>
                                <a href="mostrarEntrada.php?id=<?= $resultado['id'] ?>">
                                    <?= htmlspecialchars($resultado['titulo']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars(substr($resultado['descripcion'], 0, 100)) ?>...</td>
                            <td><?= htmlspecialchars($resultado['categoria']) ?></td>
                            <td><?= htmlspecialchars($resultado['autor']) ?></td>
                            <td><?= htmlspecialchars($resultado['fecha']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se encontraron resultados para "<?= htmlspecialchars($termino) ?>".</p>
        <?php endif; ?>
    </main>
</body>

</html>