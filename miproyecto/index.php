<?php
session_start();
require_once '../inc/conexion.php';
require_once '../inc/funciones.php';

$errores = [
    'error' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = limpiar_dato($_POST['email']);
    $password = $_POST['password'];

    // Consultamos si el email existe
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['nombre'];
        $_SESSION['user_role'] = $usuario['rol'];
        $_SESSION['user_email'] = $usuario['email'];
        // Reto imagen
        $_SESSION['user_imagen'] = $usuario['imagen'];

        header("Location: dashboard.php");
        exit;
    } else {
        // echo "Email o contraseña incorrectos.";
        $errores['error'] = 'Email o contraseña incorrectos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        body {
            margin: 0;
            /* Elimina márgenes por defecto */

        }

        .caja {
            display: grid;
            place-items: center;
            min-height: 100vh;
            width: 100%;
            background-color: rgba(240, 240, 240, 0.5);
            /* Fondo color gris claro */
            background-image: url('../img/gif.gif');
            background-size: cover;
            background-position: center;
        }


        header {
            display: flex;
            /* Activa el modo flexbox */
            justify-content: flex-end;
            /* Alinea horizontalmente el contenido a la derecha */
            align-items: center;
            /* Centra verticalmente el contenido dentro del header */
            height: 50px;
        }

        a {
            padding-right: 20px;
            text-decoration: none;
            /* Elimina el subrayado del enlace */
            color: black;
            font-size: 27px;
        }

        form {
            width: 100%;
            border: 2px solid red;
            /* Borde rojo */
            padding: 20px;
            /* Espacio interno */
            border-radius: 0 20px 0 20px;
            /* Esquinas redondeadas */
            background-color: #ffffff40;
            /* Fondo blanco opcional */
        }

        h2 {
            text-align: center;
        }

        input {
            width: -webkit-fill-available;
        }

        .error {
            text-align: center;
            color: red;
            font-weight: bold;
            font-size: 0.9em;
        }

        .animacion {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <header>
        <a href="../index.php">Index</a>
        <a href="Registro.php">Registrar</a>
    </header>


    <div class="caja">
        <div>
            <img class="animacion" src="../img/animacion.gif" alt="">
        </div>
        <form method="post">
            <h2>Inicio de Sesión</h2>

            <?php if (!empty($errores['error'])): ?>
                <p class="error"><?php echo $errores['error']; ?></p>
            <?php endif; ?>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Iniciar Sesión</button>
            <div class="error"></div> <!-- Para mostrar errores -->
        </form>
        <div class="container">
            <div class="book" onclick="openModal('ruta/a/libro1.jpg', 'Descripción del libro 1', '$10.00')">
                <img src="ruta/a/libro1.jpg" alt="Libro 1">
                <div class="title">Título del Libro 1</div>
            </div>
            <div class="book" onclick="openModal('ruta/a/libro2.jpg', 'Descripción del libro 2', '$12.00')">
                <img src="ruta/a/libro2.jpg" alt="Libro 2">
                <div class="title">Título del Libro 2</div>
            </div>
            <div class="book" onclick="openModal('ruta/a/libro3.jpg', 'Descripción del libro 3', '$15.00')">
                <img src="ruta/a/libro3.jpg" alt="Libro 3">
                <div class="title">Título del Libro 3</div>
            </div>
            <div class="book" onclick="openModal('ruta/a/libro4.jpg', 'Descripción del libro 4', '$8.00')">
                <img src="ruta/a/libro4.jpg" alt="Libro 4">
                <div class="title">Título del Libro 4</div>
            </div>
            <div class="book" onclick="openModal('ruta/a/libro5.jpg', 'Descripción del libro 5', '$9.00')">
                <img src="ruta/a/libro5.jpg" alt="Libro 5">
                <div class="title">Título del Libro 5</div>
            </div>
            <div class="book" onclick="openModal('ruta/a/libro6.jpg', 'Descripción del libro 6', '$11.00')">
                <img src="ruta/a/libro6.jpg" alt="Libro 6">
                <div class="title">Título del Libro 6</div>
            </div>
            <div class="book" onclick="openModal('ruta/a/libro7.jpg', 'Descripción del libro 7', '$14.00')">
                <img src="ruta/a/libro7.jpg" alt="Libro 7">
                <div class="title">Título del Libro 7</div>
            </div>
            <div class="book" onclick="openModal('ruta/a/libro8.jpg', 'Descripción del libro 8', '$13.00')">
                <img src="ruta/a/libro8.jpg" alt="Libro 8">
                <div class="title">Título del Libro 8</div>
            </div>
            <div class="book" onclick="openModal('ruta/a/libro9.jpg', 'Descripción del libro 9', '$7.00')">
                <img src="ruta/a/libro9.jpg" alt="Libro 9">
                <div class="title">Título del Libro 9</div>
            </div>
            <div class="book" onclick="openModal('ruta/a/libro10.jpg', 'Descripción del libro 10', '$20.00')">
                <img src="ruta/a/libro10.jpg" alt="Libro 10">
                <div class="title">Título del Libro 10</div>
            </div>
            <div class="book" onclick="openModal('ruta/a/libro11.jpg', 'Descripción del libro 11', '$18.00')">
                <img src="ruta/a/libro11.jpg" alt="Libro 11">
                <div class="title">Título del Libro 11</div>
            </div>
            <div class="book" onclick="openModal('ruta/a/libro12.jpg', 'Descripción del libro 12', '$22.00')">
                <img src="ruta/a/libro12.jpg" alt="Libro 12">
                <div class="title">Título del Libro 12</div>
            </div>
        </div>
        </form>

    </div>

    </div>
</body>

</html>