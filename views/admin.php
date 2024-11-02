<?php
session_start();
require_once '../inc/funciones.php';

if (!verificar_rol('admin')) {
    echo "Acceso denegado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        /* Reset de márgenes y paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Estilo general */
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Estilo del contenedor principal */
        .caja {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        /* Encabezado */
        header {
            position: absolute;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: flex-end;
            padding: 15px 20px;
            background-color: #007bff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        header a {
            text-decoration: none;
            color: #fff;
            font-size: 18px;
        }

        header a:hover {
            text-decoration: underline;
        }

        /* Títulos y textos */
        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            color: #666;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <header>
        <a href="dashboard.php">Volver al Dashboard</a>
    </header>

    <div class="caja">
        <div>
            <h2>Área de Administración</h2>
            <p>Solo para administradores.</p>
            <p>ID: <?php echo htmlspecialchars($_SESSION['user_id']); ?></p>
        </div>
    </div>
</body>
</html>
