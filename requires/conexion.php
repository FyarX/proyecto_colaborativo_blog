<?php
// Configuración de la conexión con PDO
    $dsn = "mysql:host=localhost;dbname=blogcolaborativo;charset=utf8mb4";
<<<<<<< HEAD
=======
    //19216810227
>>>>>>> a32720e8aae20cb429825fc6078dbe7124c15638
    $username = "root";
    $password = "";
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa<br>";
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}