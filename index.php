<?php
// Iniciar sesión
session_start();

// Incluir conexión a la base de datos y funciones necesarias
require_once 'requires/conexion.php';
require_once 'listarEntradas.php';

// Obtener entradas
$entradas = conseguirUltimasEntradas($pdo);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog de Videojuegos</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
    <header>
        <h1>Blog de Videojuegos</h1>
        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Acción</a></li>
                <li><a href="#">Rol</a></li>
                <li><a href="#">Deportes</a></li>
                <li><a href="#">Responsabilidad</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <section class="content">
            <h2>Últimas entradas</h2>
            <?php if (!empty($entradas)): ?>
                <?php foreach ($entradas as $entrada): ?>
                    <article>
                        <h3><?= htmlspecialchars($entrada['titulo']) ?></h3>
                        <p><?= htmlspecialchars(substr($entrada['descripcion'], 0, 150)) ?>...</p>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay entradas disponibles.</p>
            <?php endif; ?>
            
            <a href="listarEntradas.php"><button>Ver todas las entradas</button></a>
        </section>
        
        <aside>
            <div class="search">
                <h3>Buscar</h3>
                <form method="GET" action="buscar.php">
                    <input type="text" name="busqueda" placeholder="Buscar...">
                    <button type="submit">Buscar</button>
                </form>
            </div>

            <?php if (!isset($_SESSION['loginExito']) || !$_SESSION['loginExito']): ?>
                <div class="login">
                    <h3>Identifícate</h3>
                    <?php if (!empty($_SESSION['errorPassLogin'])): ?>
                        <p class="error"><?= htmlspecialchars($_SESSION['errorPassLogin']) ?></p>
                    <?php endif; ?>
                    <form method="POST" action="login.php">
                        <input type="email" name="emailLogin" placeholder="Email" required>
                        <input type="password" name="passwordLogin" placeholder="Contraseña" required>
                        <label>
                            <input type="checkbox" name="rememberMe"> Recordarme
                        </label>
                        <button type="submit" name="botonLogin">Entrar</button>
                    </form>
                </div>

                <div class="register">
                    <h3>Regístrate</h3>
                    <?php if (!empty($_SESSION['success_message'])): ?>
                        <p class="success"><?= htmlspecialchars($_SESSION['success_message']) ?></p>
                    <?php endif; ?>
                    <form method="POST" action="registro.php">
                        <input type="text" name="nombreRegistro" placeholder="Nombre" required>
                        <input type="text" name="apellidosRegistro" placeholder="Apellidos" required>
                        <input type="email" name="emailRegistro" placeholder="Email" required>
                        <input type="password" name="passwordRegistro" placeholder="Contraseña" required>
                        <button type="submit" name="botonRegistro">Registrar</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="logout">
                    <form method="POST" action="logout.php">
                        <button type="submit" name="botonCerrarSesion">Cerrar Sesión</button>
                    </form>
                </div>
            <?php endif; ?>
        </aside>
    </main>
</body>
</html>
