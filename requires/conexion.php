<?php
// Configuración de la conexión con PDO
    $dsn = "mysql:host=locahost;dbname=blog;charset=utf8mb4";
    //19216810227
    $username = "root";
    $password = "";
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa<br>";
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}