<?php
    
?>

<!DOCTYPE html>
< lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        body{
            margin: 0; /* Elimina márgenes por defecto */

        }
        .caja{
            display: grid; /* Activa el modo de grid */
            place-items: center; /* Centra el contenido horizontal y verticalmente */
            min-height: 100vh; /* Asegura que el body tenga al menos la altura completa de la pantalla */
            background-color: #f0f0f0; /* Color de fondo opcional */
        }

        header{
            display: flex; /* Activa el modo flexbox */
            justify-content: flex-end; /* Alinea horizontalmente el contenido a la derecha */
            align-items: center; /* Centra verticalmente el contenido dentro del header */
            height: 50px;
        }

        a{
            padding-right: 20px;
            text-decoration: none; /* Elimina el subrayado del enlace */
            color: black;
            font-size: 27px;
        }
        
        h2{
            text-align: center;
        }

    </style>
</head>
<>

    <header>
        <a href="./views/login.php">Login</a>
        <a href="./views/Registro.php">Registrar</a>
    </header>
    <div class="welcome-container">
    <!-- Capa de fondo oscura -->
    <div class="overlay"></div>

    <!-- Contenido principal de la bienvenida -->
    <div class="content">
        <h1>¡Bienvenido, <?php echo $_SESSION['user_name']; ?>!</h1>
        <p>Disfruta de nuestra plataforma personalizada para ti</p>

        <!-- Imagen de perfil del usuario -->
        <div class="profile-image">
            <img src="../ruta/de/imagenes/<?php echo $_SESSION['user_imagen']; ?>" alt="Imagen de perfil">
        </div>

        <!-- Botón para ir al dashboard -->
        <a href="dashboard.php">
            <button class="start-button">Comenzar</button>
        </a>
    </div>
</div>

</body>
</html>
