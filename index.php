<?php

// Inicio de sesión
session_start();


// Llamada a los otros ficheros
require_once  'requires/conexion.php';
require_once 'listarCategorias.php';

$_SESSION['loginExito'] = $_SESSION['loginExito'] ?? false;


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
                <?php if (!empty($categorias)): ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <li><a href="entradasCategoria.php?id=<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nombre']) ?></a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><a href="#">Sin categorías</a></li>
                <?php endif; ?>
                <li><a href="#">Responsabilidad</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="content">
            <h2>Últimas entradas</h2>
            <article>
                <h3>Título de mi entrada</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat est sit amet sapien sodales, ac lacinia est vehicula. Sed luctus sit amet mi vitae lobortis.</p>
            </article>
            <article>
                <h3>Título de mi entrada</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat est sit amet sapien sodales, ac lacinia est vehicula. Sed luctus sit amet mi vitae lobortis.</p>
            </article>
            <article>
                <h3>Título de mi entrada</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat est sit amet sapien sodales, ac lacinia est vehicula. Sed luctus sit amet mi vitae lobortis.</p>
            </article>
            <article>
                <h3>Título de mi entrada</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat est sit amet sapien sodales, ac lacinia est vehicula. Sed luctus sit amet mi vitae lobortis.</p>
            </article>
            <button>Ver todas las entradas</button>
        </section>
        <aside>

            <?php if (!$_SESSION['loginExito']) { ?>
                <div class="login">
                    <h3>Identificate</h3>

                    <form method="POST" action="login.php">
                        <input type="email" name="emailLogin" placeholder="Email">
                        <input type="password" name="passwordLogin" placeholder="Contraseña">
                        <?php if (isset($_SESSION['errorPassLogin'])) { ?>
                            <span style="color: red;"><?php echo $_SESSION['errorPassLogin']; ?></span>
                        <?php } ?>
                        <button type="submit" name="botonLogin">Entrar</button>
                    </form>
                </div>
                <div class="register">
                    <h3>Registrate</h3>
                    <?php if (isset($_SESSION['success_message']))
                        echo $_SESSION['success_message']; ?>
                    <form method="POST" action="registro.php">
                        <input type="text" name="nombreRegistro" placeholder="Nombre">
                        <input type="text" name="apellidosRegistro" placeholder="Apellidos">
                        <input type="email" name="emailRegistro" placeholder="Email">
                        <input type="password" name="passwordRegistro" placeholder="Contraseña">
                        <button type="submit" name="botonRegistro">Registrar</button>
                    </form>
                </div>
            <?php } else { ?>
                <div>

                    <form action="crearEntrada.php" method="post">
                        <button type="submit" name="crearEntrada">Crear entrada</button>
                    </form>
                    <form method="POST" action="logout.php">
                        <button type="submit" name="botonCerrarSesion">Cerrar Sesión</button>
                    </form>
                    <form method="POST" action="actualizarDatosUsuario.php">
                        <button type="submit" name="botonCerrarSesion">Actualizar Datos</button>
                    </form>
                    <div class="search">
                        <form action="aniade_buscador.php" method="GET" style="display: inline;">
                            <label for="query">Buscar Entradas:</label>
                            <input type="text" id="query" name="query" placeholder="Buscar por título" required>
                            <button type="submit">Buscar</button>
                        </form>



                    </div>
                </div>
            <?php } ?>

        </aside>
    </main>
</body>

</html>
<?php
// Iniciar sesión
session_start();

// Incluir conexión a la base de datos y funciones necesarias
require_once 'requires/conexion.php';
require_once 'listarEntradas.php';
require_once 'listarCategorias.php';

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
                <?php if (!empty($categorias)): ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <li><a href="entradasCategoria.php?id=<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nombre']) ?></a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><a href="#">Sin categorías</a></li>
                <?php endif; ?>
                <li><a href="#">Responsabilidad</a></li>
                <li><a href="contacto.php">Contacto</a></li>
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
            <button>Ver todas las entradas</button>
        </section>

        <aside>
            <div class="search">
                <h3>Buscar</h3>
                <form method="GET" action="aniade_buscador">
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



                    <form action="crearEntrada.php" method="post">
                        <button type="submit" name="crearEntrada">Crear entrada</button>
                    </form>
                    <form method="POST" action="logout.php">
                        <button type="submit" name="botonCerrarSesion">Cerrar Sesión</button>
                    </form>
                    <form method="POST" action="actualizarDatosUsuario.php">
                        <button type="submit" name="botonCerrarSesion">Actualizar Datos</button>
                    </form>
                    <div class="search">
                        <form action="aniade_buscador.php" method="GET" style="display: inline;">
                            <label for="query">Buscar Entradas:</label>
                            <input type="text" id="query" name="query" placeholder="Buscar por título" required>
                            <button type="submit">Buscar</button>
                        </form>
                    </div>

                   


                <?php else: ?>
                    <div class="logout">
                        <form method="POST" action="logout.php">
                            <button type="submit" name="botonCerrarSesion">Cerrar Sesión</button>
                        </form>
                    </div>

                    <form action="crearCategoria.php" method="POST">
                        <label for="tituloCategoria">Introduce tu categoria</label>
                        <input type="text" name="tituloCategoria" id="tituloCategoria">
                        <input type="submit" name="botonCrearEntrada" value="Crear Categoria">
                    </form>

                    <form action="verEntrada.php" method="POST">
                        <label for="tituloCategoria">Introduce tu entrada</label>
                        <input type="text" name="tituloEntrada" id="tituloEntrada">
                        <input type="submit" name="botonVerEntrada" value="Crear Entrada">
                    </form>
                <?php endif; ?>
        </aside>
    </main>
</body>

</html>
>>>>>>> a32720e8aae20cb429825fc6078dbe7124c15638