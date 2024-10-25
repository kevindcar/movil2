<?php
session_start();
require_once '../inc/conexion.php';
require_once '../inc/funciones.php';

$errores = [
    'nombre' => '',
    'email' => '',
    'password' => '',
    'exito' => ''
];

$nombre = '';
$email = '';
$password = '';
$rol = '';
$image = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = limpiar_dato($_POST['nombre']);
    $email = limpiar_dato($_POST['email']);
    $password = $_POST['password'];

    // Validaciones
    if (empty($nombre)) {
        $errores['nombre'] = 'El nombre es obligatorio.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'El email no es válido.';
    }
    if (strlen($password) < 6) {
        $errores['password'] = 'La contraseña debe tener al menos 6 caracteres.';
    }

    // Verificar si el email ya existe en la base de datos
    $sqlVerificacion = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
    $stmtVerificacion = $conexion->prepare($sqlVerificacion);
    $stmtVerificacion->bindParam(':email', $email);
    $stmtVerificacion->execute();
    $emailExiste = $stmtVerificacion->fetchColumn();

    if ($emailExiste) {
        $errores['email'] = 'El correo electrónico ya está registrado.';
    }

    $errores['imagen'] = '';
    $imagenPerfilPath = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Existing validations...

        // Handle image upload
        if (isset($_FILES['imagen_perfil']) && $_FILES['imagen_perfil']['error'] === 0) {
            $image = $_FILES['imagen_perfil'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            // Check if the file is an image
            if (!in_array($image['type'], $allowedTypes)) {
                $errores['imagen'] = 'Solo se permiten archivos JPEG, PNG o GIF.';
            } else {
                // Move the file to the desired directory (e.g., 'uploads/')
                $uploadDir = '../uploads/';
                $imagenPerfilPath = $uploadDir . basename($image['name']);

                if (!move_uploaded_file($image['tmp_name'], $imagenPerfilPath)) {
                    $errores['imagen'] = 'Error al subir la imagen.';
                }
            }
        } else {
            $errores['imagen'] = 'Debe seleccionar una imagen.';
        }

        // If there are no errors, proceed to save the user information
        if (empty(array_filter($errores))) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nombre, email, password, rol, imagen_perfil) VALUES (:nombre, :email, :password , :rol, :imagen_perfil)";
            $stmt = $conexion->prepare($sql);

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $passwordHash);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':imagen_perfil', $imagenPerfilPath);

            if ($stmt->execute()) {
                $errores['exito'] = 'Usuario registrado exitosamente.';
            } else {
                echo "Error al registrar el usuario.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        body {
            margin: 0;
            /* Elimina márgenes por defecto */

        }

        .caja {
            display: grid;
            /* Activa el modo de grid */
            place-items: center;
            /* Centra el contenido horizontal y verticalmente */
            min-height: 100vh;
            /* Asegura que el body tenga al menos la altura completa de la pantalla */
            background-color: #f0f0f0;
            /* Color de fondo opcional */
        }

        header {
            display: flex;
            /* Activa el modo flexbox */
            justify-content: flex-end;
            /* Alinea horizontalmente el contenido a la derecha */
            align-items: center;
            /* Centra verticalmente el contenido dentro del header */
            height: 50px;
            /* background-color: red; */
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
        }

        h2 {
            text-align: center;
        }

        .exito {
            text-align: center;
            color: green;
            font-weight: bold;
        }

        input {
            width: -webkit-fill-available;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }

        .rol-container {
            display: flex;
            text-align: center;
            /* Centra verticalmente los elementos */
            justify-content: flex-start;
            /* Alinea horizontalmente al inicio */
            margin-left: 10px;
            /* Espacio superior */
            margin-bottom: 4px;
        }

        .rol-container label {
            margin-right: 10px;
            /* Hace el texto del label más destacado */
            font-size: 1rem;
            /* Tamaño del texto */
        }


        .grupo {
            display: flex;
            text-align: center;
            /* Centra verticalmente los elementos */
            justify-content: flex-start;
            /* Alinea horizontalmente al inicio */
            margin-top: 10px;
            /* Espacio superior */
            margin-bottom: 4px;
        }

        .grupo label {
            font-size: 1rem;
            margin-bottom: 4px;

        }


        .boton {
            display: inline-block;
            padding: 10px 20px;
            background-color: white;
            color: black;
            border-radius: 5px;
            cursor: pointer;
            border: 1px solid #ccc;
            /* Añadir un borde si es necesario */
        }

        .boton:hover {
            background-color: #f0f0f0;
            /* Cambiar color al pasar el mouse */
        }

        /* Espacio entre el label y el botón */
        .grupo label {
            display: flex;
            margin-right: 50px;
            margin-left: 10%;
        }

        /* Oculta el input file original */
        input[type="file"] {
            display: none;
        }

        /* Estilo para el botón personalizado */
        .custom-file-upload label {
            padding: 2% 10px;
            background-color: white;
            color: black;
            border-radius: 5px;
            text-align: center;
            border: 1px solid black;
        }

        /* Estilo para el texto que muestra el nombre del archivo */
        #nombreArchivo {
            margin-left: 10px;
            font-style: italic;
        }
    </style>
</head>

<body>
    <header>
        <a href="../index.php">Index</a>
        <a href="login.php">Login</a>
    </header>

    <div class="caja">
        <form method="post">

            <h2>Registro de Usuario</h2>
            <?php if (!empty($errores['exito'])): ?>
                <p class="exito"><?php echo $errores['exito']; ?></p>
            <?php endif; ?>


            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>">

            <?php if (!empty($errores['nombre'])): ?>
                <p class="error"><?php echo $errores['nombre']; ?></p>
            <?php endif; ?>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>">
            <?php if (!empty($errores['email'])): ?>
                <p class="error"><?php echo $errores['email']; ?></p>
            <?php endif; ?>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password">
            <?php if (!empty($errores['password'])): ?>
                <p class="error"><?php echo $errores['password']; ?></p>
            <?php endif; ?>

            <div class="rol-container">
                <button class="boton">
                    <label for="rol">Rol:</label>
                </button>
                <button class="boton">
                    <select name="rol" id="rol">
                        <option value="invitado" <?php if ($rol === 'invitado') echo 'selected'; ?>>invitado</option>
                        <option value="editor" <?php if ($rol === 'editor') echo 'selected'; ?>>Editor</option>
                        <option value="admin" <?php if ($rol === 'admin') echo 'selected'; ?>>Admin</option>
                    </select>
                </button>
                <?php if (!empty($errores['rol'])): ?>
                    <p class="error"><?php echo $errores['rol']; ?></p>
                <?php endif; ?>
            </div>
            <div class="grupo">
                <button class="boton">
                    <label for="imagen_perfil">Imagen de perfil:</label>
                </button>
                <div class="custom-file-upload">
                    <button class="boton">
                        <label for="imagen_perfil">Elegir archivo</label>
                    </button>
                    <input type="file" name="imagen_perfil" id="imagen_perfil" accept="image/*" onchange="mostrarNombreArchivo()">
                </div>
                <span id="nombreArchivo"></span>
            </div>

            <button type="submit">Registrar</button>
        </form>
    </div>
</body>

</html>