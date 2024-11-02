<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos al Futuro</title>
    <style>
        /* Estilos básicos */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
            background: url('../miproyecto/img/animacion.gif') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            text-align: center;
            padding: 20px;
            max-width: 90%;
        }

        /* Título principal */
        h1 {
            font-size: 3em;
            margin-bottom: 20px;
            color: #4cafef;
            text-shadow: 0px 0px 10px rgba(0, 172, 255, 0.7);
        }

        /* Sección de imágenes */
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }

        .gallery-item {
            width: 200px;
            height: 200px;
            background-color: #1a1a40;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 172, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Estilo del header */
        header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            height: 50px;
            background-color: white;
            padding: 5px;
            position: fixed;
            top: 0;
            width: 100%;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Estilo de enlaces en el header */
        header a {
            color: #000;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }

        header a:hover {
            text-decoration: underline;
        }

        /* Ajuste de la página principal */
        .container {
            margin-top: 70px;
        }
    </style>
</head>
<body>

<header>
    <a href="../mi_proyecto/views/login.php">Login</a>
    <a href="../mi_proyecto/views/registro.php">Registrar</a>
</header>

<div class="container">
    <h1>BIENVENIDOS...</h1>
    <p>Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto.</p>

    <div class="gallery">
        <div class="gallery-item">
            <img src="img/gif.gif" alt="">
        </div>
        <div class="gallery-item">
            <img src="img/libros.jpg" alt="">
        </div>
        <div class="gallery-item">
            <img src="img/s1000rr.jpg" alt="">
        </div>
    </div>
</div>
</body>
</html>