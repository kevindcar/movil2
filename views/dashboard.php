<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// // Ruta absoluta
$ruta_absoluta = $_SESSION['user_imagen'];
// echo ($ruta_absoluta);
// echo '<br>';
// // Convertir a ruta relativa
$ruta_relativa = str_replace('C:\xampp\htdocs\curso_php\mi-proyecto\views/', '', $ruta_absoluta);
// echo ($ruta_relativa);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
    <p>Tu rol es: <?php echo htmlspecialchars($_SESSION['user_role']); ?></p>
    <p>Tu correo es: <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>

    <p>Imagen de perfil:</p>
    <img src="<?php echo htmlspecialchars($ruta_relativa); ?>" alt="Imagen de usuario no funciona">
    
    <br>


    <a href="admin.php">Administración</a>
    <a href="../logout.php">Cerrar Sesión</a>
</body>
</html>