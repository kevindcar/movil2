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
            <img class="animacion" src="../img/animacion.gif" alt="pantera rosa">
        </div>
        <form method="post">
            <h2>Inicio de Sesión</h2>

            <?php if (!empty($errores['error'])): ?>
                <p class="error"><?php echo $errores['error']; ?></p>
            <?php endif; ?>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password">

            <button type="submit">Iniciar Sesión</button>
        </form>

    </div>

    </div>
</body>

</html>