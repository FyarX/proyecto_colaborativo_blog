<?php
require_once "requires/conexion.php";
require_once "functions/conseguirUltimasEntradas.php";

// Obtener las últimas entradas desde la base de datos
$entradas = conseguirUltimasEntradas ($pdo);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Entradas</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>

<body>
    <main>
        <h1>Listado de Entradas</h1>
        <a href="index.php">Volver al inicio</a>
        <section>
        <?php if (!empty($entradas)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entradas as $entrada): ?>
                        <tr>
                            <!-- Mostrar los datos de cada entrada -->
                            <td><?= htmlspecialchars($entrada['titulo']) ?></td>
                            <td><?= htmlspecialchars(substr($entrada['descripcion'], 0, 100)) ?>...</td>
                            <td><?= htmlspecialchars($entrada['categoria']) ?></td>
                            <td><?= htmlspecialchars($entrada['fecha']) ?></td>

                            <!-- Mostrar opciones de edición y eliminación solo si el usuario es el autor -->
                            <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['id'] == $entrada['usuario_id']): ?>
                                <td>
                                    <a href="editarEntrada.php?id=<?= $entrada['id'] ?>">Editar</a>
                                    <a href="borrarEntrada.php?id=<?= $entrada['id'] ?>" onclick="return confirm('¿Quieres borrar esta entrada definitivamente?')">Borrar</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay entradas disponibles.</p>
        <?php endif; ?>
        </section>
    </main>
</body>
</html>