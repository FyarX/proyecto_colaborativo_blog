<?php
function conseguirUltimasEntradas($conexion, $limit=5){
    try {
        $sql = "SELECT e.id AS id_entrada, e.titulo, e.descripcion, e.fecha, c.nombre AS categoria
            FROM entradas e INNER JOIN categorias c ON e.categoria_id = c.id
            ORDER BY e.id DESC
            LIMIT :limit";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener las ultimas entradas: ". $e->getMessage());
        return [];
    }
    
}


?>