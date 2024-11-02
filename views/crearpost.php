<?php
session_start();
require '../inc/conexion.php';
require '../inc/funciones.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];
    $image = $_FILES['image'];

    if (empty($title) || empty($description) || empty($image['name'])) {
        echo "Todos los campos son obligatorios!";
    } else {
        $imagePath = '../img/' . basename($image['name']);
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            $sql = "INSERT INTO posts (title, description, image, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([$title, $description, $imagePath, $user_id])) {
                header("Location: postCreados.php");
                exit;
            } else {
                echo "Error: No se pudieron guardar los datos.";
            }
        } else {
            echo "Error al subir la imagen.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área de Administración</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 500px;
            width: 100%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            color: #666;
            font-size: 14px;
        }
        label {
            display: block;
            color: #333;
            font-size: 16px;
            margin-top: 10px;
            text-align: left;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        input[type="file"] {
            margin: 10px 0;
            font-size: 14px;
        }
        .btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 15px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .nav-links {
            margin-bottom: 20px;
        }
        .nav-links a {
            color: #007bff;
            text-decoration: none;
            margin-right: 10px;
            font-size: 14px;
        }
        .nav-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-links">
            <a href="dashboard.php">Volver al Dashboard</a>
            <a href="postCreados.php">Post creados</a>
        </div>
        <h1>Área de Administración</h1>
        <p>Formulario para la creación de un post asociado al ID: <?php echo $_SESSION['user_id']; ?>, con conexión activa.</p>
        <form action="crearPost.php" method="POST" enctype="multipart/form-data">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Descripción:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="image">Imagen:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit" class="btn">Crear</button>
        </form>
    </div>
</body>
</html>
