<?php
session_start();
require '../inc/conexion.php';
require '../inc/funciones.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM posts WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Posts</title>
</head>
<body>
    <h1>Mis Posts Creados</h1>
    <?php foreach ($posts as $post): ?>
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <p><?php echo htmlspecialchars($post['description']); ?></p>
        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Imagen del Post" style="max-width: 300px;"><br>
    <?php endforeach; ?>
</body>
</html>
