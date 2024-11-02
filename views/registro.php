<?php
session_start();
require_once '../inc/conexion.php';
require_once '../inc/funciones.php';

// Mensajes de error y éxito
$errores = [
    'nombre' => '',
    'email' => '',
    'password' => '',
    'rol' => '',
    'imagen' => '',
    'exito' => ''
];

// Datos iniciales
$nombre = '';
$email = '';
$password = '';
$rol = 'viewer'; // Rol predeterminado
$imagenPerfil = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = limpiar_dato($_POST['nombre']);
    $email = limpiar_dato($_POST['email']);
    $password = $_POST['password'];
    $rol = $_POST['rol'];  // Obtén el rol del formulario

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
    if ($rol !== 'admin' && $rol !== 'viewer') {
        $errores['rol'] = 'El rol seleccionado no es válido.';
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

    // Procesar la imagen de perfil
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $imagenPerfil = $_FILES['profile_image']['name'];
        $tmp_name = $_FILES['profile_image']['tmp_name'];
        $uploadDir = '../uploads/';
        $targetFile = $uploadDir . basename($imagenPerfil);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validar que el archivo es una imagen
        $check = getimagesize($tmp_name);
        if ($check === false) {
            $errores['imagen'] = 'El archivo no es una imagen válida.';
        }

        // Validar el tamaño del archivo (opcional, por ejemplo, 2MB máximo)
        if ($_FILES['profile_image']['size'] > 2097152) {
            $errores['imagen'] = 'El archivo es demasiado grande. Máximo 2MB.';
        }

        // Permitir solo ciertos formatos de imagen
        if ($imageFileType !== 'jpg' && $imageFileType !== 'png' && $imageFileType !== 'jpeg' && $imageFileType !== 'gif') {
            $errores['imagen'] = 'Solo se permiten archivos JPG, JPEG, PNG y GIF.';
        }

        // Si no hay errores, mover la imagen a la carpeta de destino
        if (empty($errores['imagen'])) {
            if (!move_uploaded_file($tmp_name, $targetFile)) {
                $errores['imagen'] = 'Error al subir la imagen.';
            }
        }
    }

    // Si no hay errores, proceder con el registro
    if (empty(array_filter($errores))) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Incluir la ruta de la imagen en la consulta
        $sql = "INSERT INTO usuarios (nombre, email, password, rol, imagen_perfil) 
                VALUES (:nombre, :email, :password, :rol, :imagen_perfil)";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':imagen_perfil', $targetFile);  // Guardar la ruta de la imagen

        if ($stmt->execute()) {
            $errores['exito'] = 'Usuario registrado exitosamente.';
        } else {
            echo "Error al registrar el usuario.";
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
    <link rel="stylesheet" href="CSS/estilos.css">
    <style>
        body {
            margin: 0%;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .header {
            display: flex;
            justify-content: flex-end;
            padding: 10px;
            background-color: white;
            border-bottom: 1px solid #ccc;
            margin: 0%;
        }
        .header a {
            color: black;
            margin-left: 15px;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }
        .form-box {
            padding: 30px;
            border-radius: 10px;
            width: 350px;
            padding-top: 100px;
        }
        h2 {
            text-align: center;
            margin-bottom: 18px;

        }
        .exito {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }
        label {
            display: block;
            height: 30px;
            padding-top: 15px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        .rol-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            padding-top: 20px;
        }
        .rol-label-box, .rol-select-box {
            flex: 1;
            border: 1px solid #ccc;
            padding: 3px;
            border-radius: 3%;
            display: flex;
            justify-content: center;
            
            align-items: center;
            height: 40px;
        }
        .rol-select-inner-box {
            border: 2px solid #000000;
            background-color: white;
            border-radius: 4px;
            padding: 0%;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 20px;
            width: 120px;
            margin: 0 auto;
        }
        .rol-select-inner-box select {
            width: 100%;
            border: none;
            background-color: transparent;
            outline: none;
            padding: 0;
            padding-right: 15px;
            text-align: left;
        }
        
        /* Contenedor para la sección de imagen de perfil */
        .file-container {
            display: flex;
            align-items: center;
            gap: 10px; /* Espacio entre las cajas */
            margin-bottom: 15px;
        }

        /* Caja para el label "Imagen de perfil" */
        .file-label-caja {
            flex: 1;
            border: 1px solid #ccc;
            padding: 3px;
            border-radius: 3px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 40px;
    
        }

        /* Caja para el botón de seleccionar archivo */
        .file-input-box {
            flex: 1;
            border: 1px solid #ccc;
            padding: 3px;
            border-radius: 3px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 40px;
            gap: 20px;
      
        }

        /* Personalización del input file para ocultar el texto "Sin archivo seleccionado" */
        .file-input-box input[type="file"] {
            opacity: 0;
            position: absolute;
            z-index: -1;
            width: 100%; 
            height: 100%; 
        }

        .file-input-text {
            border: 2px solid #000000;
            background-color: white;
            border-radius: 4px;
            padding: 0px;
            cursor: pointer; 
            text-align: center;
             font-size: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 20px;
            width: 100px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="header">
    <a href="#">Index</a>
    <a href="#">Login</a>
</div>

<div class="container">
    <div class="form-box">
        <form method="post" enctype="multipart/form-data">
            <h2>Registro de Usuario</h2>
            <?php if (!empty($errores['exito'])): ?>
                <p class="exito"><?php echo $errores['exito']; ?></p>
            <?php endif; ?>
    
            <label for="nombre" style="padding-top:0% ;">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required
            required style="border-radius: 3px;">
            <?php if (!empty($errores['nombre'])): ?>
                <p class="error"><?php echo $errores['nombre']; ?></p>
            <?php endif; ?>
        
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required
            required style="border-radius: 3px;">
            <?php if (!empty($errores['email'])): ?>
                <p class="error"><?php echo $errores['email']; ?></p>
            <?php endif; ?>
        
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password); ?>" required
            required style="border-radius: 3px;">
            <?php if (!empty($errores['password'])): ?>
                <p class="error"><?php echo $errores['password']; ?></p>
            <?php endif; ?>
            
            <div class="rol-container">
                <div class="rol-label-box">
                    <label for="rol">Rol:</label>
                </div>
                <div class="rol-select-box">
                    <div class="rol-select-inner-box">
                        <select name="rol" id="rol">
                            <option    value="viewer" <?php echo $rol === 'viewer' ? 'selected' : ''; ?> strong>Invitado</strong></option>
                            <option value="admin" <?php echo $rol === 'admin' ? 'selected' : ''; ?> strong>Administrador</strong></option>
                        </select>
                    </div>
                </div>
            </div>
            <?php if (!empty($errores['rol'])): ?>
                <p class="error"><?php echo $errores['rol']; ?></p>
            <?php endif; ?>

    
            <div class="file-container">
                <div class="file-label-caja">
                    <label for="profile_image">Imagen de perfil:</label>
                </div>
                <div class="file-input-box">
                    <input type="file" name="profile_image" id="profile_image" accept="image/*"
                    style="bottom: 0%;right:0%">
                    <span class="file-input-text">Elegir imagen</span> 
                </div>
            </div>
            <script>
    const fileInput = document.getElementById('profile_image');
    const fileInputText = document.querySelector('.file-input-text');

    fileInputText.addEventListener('click', function() {
        fileInput.click();
    });
</script>

            <button type="submit">Registrar</button>
        </form>
    </div>
</div>

</body>
</html>