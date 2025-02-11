<?php
//Se llama en la vista para obtener las entradas. Devuelve un array asociativo con los resultados o un array
//vacío en caso de error
function conseguirUltimasEntradas($conexion){
    try {
        $sql = "SELECT e.id AS id_entrada, e.titulo, e.descripcion, e.fecha, c.nombre AS categoria
            FROM entradas e INNER JOIN categorias c ON e.categoria_id = c.id
            ORDER BY e.id DESC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener las ultimas entradas: ". $e->getMessage());
        return [];
    }
    
}


?>