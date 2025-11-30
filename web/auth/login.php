<?php
session_start();
require_once __DIR__ . '/../includes/json_connect.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomUsuari = trim($_POST['nom_usuari'] ?? '');
    $contrasenya = $_POST['contrasenya'] ?? '';

    if (!$nomUsuari || !$contrasenya) {
        $message = "Todos los campos son obligatorios.";
    } else {
        $users = read_users();
        foreach ($users as $user) {
            if ($user['nom_usuari'] === $nomUsuari && password_verify($contrasenya, $user['contrasenya'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                setcookie('user_id', $user['id'], time() + 3600, "/");
                header("Location: profile.php");
                exit;
            }
        }
        $message = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="../css/pp.css">
</head>
<body>
<h1>Iniciar sesión</h1>
<?php if($message) echo "<p style='color:red;'>$message</p>"; ?>
<?php if(isset($_GET['success'])) echo "<p style='color:green;'>Registro exitoso, inicia sesión.</p>"; ?>
<form method="POST">
    <input type="text" name="nom_usuari" placeholder="Nombre de usuario" required><br>
    <input type="password" name="contrasenya" placeholder="Contraseña" required><br>
    <button type="submit">Iniciar sesión</button>
</form>
<a href="register.php">¿No tienes cuenta? Regístrate</a>
</body>
</html>
