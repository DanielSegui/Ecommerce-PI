<?php
session_start();
require_once __DIR__ . '/../includes/json_connect.php';

$user_id = $_SESSION['user_id'] ?? $_COOKIE['user_id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit;
}

$users = read_users();
$user = null;
foreach ($users as $u) {
    if ($u['id'] == $user_id) {
        $user = $u;
        break;
    }
}
if (!$user) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Perfil</title>
<link rel="stylesheet" href="../css/user_forms.css">
</head>
<body>
<h1>Perfil de usuario</h1>
<p>Nombre de usuario: <?php echo htmlspecialchars($user['nom_usuari']); ?></p>
<p>Nombre: <?php echo htmlspecialchars($user['nom']); ?></p>
<p>Apellidos: <?php echo htmlspecialchars($user['cognoms']); ?></p>
<p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
<p>Fecha de registro: <?php echo htmlspecialchars($user['data_registre']); ?></p>
<a href="logout.php">Cerrar sesión</a>
<div style="margin-top: 15px;">
    <button type="button" onclick="window.location.href='../index.html'">
        Volver al inicio
    </button>
</div>
</body>
</html>
