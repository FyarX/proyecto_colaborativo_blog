<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['botonCrearEntrada']) && isset($_POST['tituloCategoria'])) {
    require_once 'requires/conexion.php';

    $tituloCategoria = filter_var(trim($_POST['tituloCategoria']));
   
    $sql = "SELECT nombre FROM categorias";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $categoriaExiste = false;
    foreach ($categorias as $categoria) {
        if ($categoria['nombre'] == $tituloCategoria) {
            $categoriaExiste = true;
            break;
        }
    }

    if ($categoriaExiste) {
        echo "La categoría ya existe.<br>";
    } else {
        
        $sql = "INSERT INTO categorias (nombre) VALUES (:titulo)";
        $stmt = $pdo->prepare($sql);        
        if ($stmt->execute()) {
            echo "Categoría creada correctamente.<br>";
        } else {
            echo "Error al crear la categoría.<br>";
        }
    }

    
    header("refresh:1;url=index.php");
    exit();
} else {
    echo "Error en la solicitud POST<br>";
}
?>