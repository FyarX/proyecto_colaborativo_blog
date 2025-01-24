<?php

function conseguirCategorias($conexion) {

    try {
        // Consulta para obtener las categorías
        $sql = "SELECT id, nombre FROM categorias ORDER BY nombre ASC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        // Devolver un array asoc
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener las categorías: " . $e->getMessage());
        return false;
    }
}

?>