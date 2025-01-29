<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    // Redirige al login si no hay sesión activa
    header('Location: ../login.php');
    exit;
}

$usuario_id = $_SESSION['usuario']['id']; // Obtén el ID del usuario logueado


require_once '../blog2/requires/conexion.php';
require_once 'functions/conseguirCategorias.php';

// Variables iniciales
$titulo = '';
$descripcion = '';
$categoria_id = '';
$errores = [];

// Si estamos editando, cargamos los datos de la entrada
if (isset($_GET['id'])) {
    $id_entrada = (int)$_GET['id'];
    $sql = "SELECT * FROM entradas WHERE id = :id_entrada";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_entrada', $id_entrada, PDO::PARAM_INT);
    $stmt->execute();
    $entrada = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() === 0) {
        die("Error: Usuario no válido.");
    }

    if ($entrada) {
        $titulo = $entrada['titulo'];
        $descripcion = $entrada['descripcion'];
        $categoria_id = $entrada['categoria_id'];
    }
}

// Procesar el formulario al enviarlo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $categoria_id = (int)($_POST['categoria'] ?? 0);

    // Validar campos
    if (empty($titulo)) {
        $errores['titulo'] = 'El título es obligatorio.';
    }
    if (empty($descripcion)) {
        $errores['descripcion'] = 'La descripción es obligatoria.';
    }
    if ($categoria_id <= 0) {
        $errores['categoria'] = 'Selecciona una categoría válida.';
    }

    // Si no hay errores, insertar o actualizar en la base de datos
    if (empty($errores)) {
        try {
            if (isset($id_entrada)) {
                // Actualizar entrada existente
                $sql = "UPDATE entradas 
                        SET titulo = :titulo, descripcion = :descripcion, categoria_id = :categoria 
                        WHERE id = :id_entrada";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id_entrada', $id_entrada, PDO::PARAM_INT);
            } else {
                // Insertar nueva entrada
                $sql = "INSERT INTO entradas (titulo, descripcion, categoria_id, usuario_id, fecha) 
                        VALUES (:titulo, :descripcion, :categoria, :usuario_id, NOW())";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT); // Usuario logueado
            }
    
            $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':categoria', $categoria_id, PDO::PARAM_INT);
            $stmt->execute();
    
            // Redirigir con mensaje de éxito
            echo "<script>
                //alert('Entrada guardada con éxito.');
                setTimeout(() => { window.location.href = '../index.php'; }, 2000);
            </script>";
            exit;
        } catch (PDOException $e) {
            $errores['general'] = 'Error al guardar la entrada: ' . $e->getMessage();
        }
    }
    
}

// Obtener las categorías disponibles
$categorias = conseguirCategorias($db);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= isset($id_entrada) ? 'Editar Entrada' : 'Nueva Entrada' ?></title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>
<body>
<?php require_once '../requires/header.php'; ?>
    <div class="container">
        <h1><?= isset($id_entrada) ? 'Editar Entrada' : 'Crear Nueva Entrada' ?></h1>
        <form action="crearEntrada.php<?= isset($id_entrada) ? '?id=' . $id_entrada : '' ?>" method="POST">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($titulo) ?>" placeholder="Título de la entrada">
            <?php if (!empty($errores['titulo'])): ?>
                <p class="error"><?= htmlspecialchars($errores['titulo']) ?></p>
            <?php endif; ?>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" placeholder="Descripción de la entrada"><?= htmlspecialchars($descripcion) ?></textarea>
            <?php if (!empty($errores['descripcion'])): ?>
                <p class="error"><?= htmlspecialchars($errores['descripcion']) ?></p>
            <?php endif; ?>

            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria">
                <option value="0">-- Seleccionar Categoría --</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id'] ?>" <?= $categoria_id == $categoria['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($categoria['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errores['categoria'])): ?>
                <p class="error"><?= htmlspecialchars($errores['categoria']) ?></p>
            <?php endif; ?>

            <button type="submit"><?= isset($id_entrada) ? 'Actualizar' : 'Guardar' ?></button>
        </form>

        <?php if (!empty($errores['general'])): ?>
            <p class="error"><?= htmlspecialchars($errores['general']) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>