<?php
session_start();
require_once __DIR__ . '/../includes/json_connect.php';

$user_id = $_SESSION['user_id'] ?? $_COOKIE['user_id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit;
}

$users = read_users();
$userIndex = null;

// Buscar usuario por ID
foreach ($users as $i => $u) {
    if ($u['id'] == $user_id) {
        $userIndex = $i;
        break;
    }
}

if ($userIndex === null) {
    header("Location: login.php");
    exit;
}

$user = $users[$userIndex];
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $users[$userIndex]['nom_usuari'] = trim($_POST['nom_usuari']);
    $users[$userIndex]['email'] = trim($_POST['email']);
    $users[$userIndex]['nom'] = trim($_POST['nom']);
    $users[$userIndex]['cognoms'] = trim($_POST['cognoms']);

    write_users($users);

    $message = "✅ Datos actualizados correctamente";
    $user = $users[$userIndex]; // refrescar datos
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar perfil</title>
<link rel="stylesheet" href="../css/user_formulari.css">
</head>
<body>

<form action="" method="POST">
    <h1>Editar perfil</h1>

    <?php if ($message) echo "<p>$message</p>"; ?>

    <input type="text" name="nom_usuari" value="<?php echo htmlspecialchars($user['nom_usuari']); ?>" required><br><br>

    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

    <input type="text" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>"><br><br>

    <input type="text" name="cognoms" value="<?php echo htmlspecialchars($user['cognoms']); ?>"><br><br>

    <button type="submit">Guardar cambios</button>

    <button type="button" onclick="window.location.href='profile.php'">Volver</button>
</form>

</body>
</html>
