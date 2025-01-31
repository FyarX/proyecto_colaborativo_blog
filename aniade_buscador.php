<?php
session_start();
require_once 'requires/conexion.php';

// Verificar que la conexión a la base de datos existe
if (!isset($pdo)) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

// Recoger el término de búsqueda desde el formulario
$termino = isset($_GET['query']) ? trim($_GET['query']) : '';

// Si no hay término, redirigir al index
if (empty($termino)) {
    header("Location: index.php");
    exit();
}

try {
    $sql = "SELECT e.id, e.titulo, e.descripcion, c.nombre AS categoria, 
                   u.nombre AS autor, e.fecha 
            FROM entradas e
            INNER JOIN categorias c ON e.categoria_id = c.id
            INNER JOIN usuarios u ON e.usuario_id = u.id
            WHERE e.titulo LIKE :termino OR e.descripcion LIKE :termino
            ORDER BY e.fecha DESC
            LIMIT 20";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':termino', "%$termino%", PDO::PARAM_STR);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<p>Error al realizar la búsqueda: " . $e->getMessage() . "</p>");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
    
    <!-- Redirección automática después de 5 segundos -->
    <script>
        setTimeout(() => {
            window.location.href = "index.php"; // Redirige a index.php después de 5 segundos
        }, 5000);
    </script>
</head>
<body>
    <main>
        <h1>Resultados de Búsqueda para "<?= htmlspecialchars($termino) ?>"</h1><br>

        <?php if (!empty($resultados)): ?>
            <p>Serás redirigido a la página de inicio en 10 segundos...</p>
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
                            <td><?= htmlspecialchars(date("d/m/Y", strtotime($resultado['fecha']))) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Redirección automática después de 2 segundos con JavaScript -->
            <script>
                setTimeout(() => { 
                    window.location.href = "index.php"; 
                }, 10000);
            </script>

        <?php else: ?>
            <p>No se encontraron resultados para "<?= htmlspecialchars($termino) ?>".</p>
            <p>Serás redirigido a la página de inicio en 10 segundos...</p>
        <?php endif; ?>
    </main>
</body>
</html>
