<?php
session_start();

// Incluimos las funciones para leer/escribir usuarios
require_once __DIR__ . '/../includes/json_connect.php';

// Verificar que users.json exista
if (!file_exists(USERS_FILE)) {
    file_put_contents(USERS_FILE, json_encode(['usuaris' => []], JSON_PRETTY_PRINT));
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomUsuari = trim($_POST['nom_usuari'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contrasenya = trim($_POST['contrasenya'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $cognoms = trim($_POST['cognoms'] ?? '');

    // Validaciones básicas
    if (!$nomUsuari || !$email || !$contrasenya) {
        $message = 'Por favor rellena todos los campos obligatorios.';
    } else {
        $users = read_users();

        // Comprobar si el nombre de usuario ya existe
        $exists = false;
        foreach ($users as $u) {
            if ($u['nom_usuari'] === $nomUsuari) {
                $exists = true;
                break;
            }
        }

        if ($exists) {
            $message = 'Este nombre de usuario ya existe.';
        } else {
            // Crear nuevo usuario
            $newUser = [
                'id' => count($users) + 1,
                'nom_usuari' => $nomUsuari,
                'contrasenya' => password_hash($contrasenya, PASSWORD_DEFAULT),
                'email' => $email,
                'nom' => $nom,
                'cognoms' => $cognoms,
                'data_registre' => date('c')
            ];

            $users[] = $newUser;
            write_users($users);

            $message = '✅ Usuario registrado correctamente. Puedes iniciar sesión.';
        }
    }
}
?>

<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de usuario</title>
    <link rel="stylesheet" href="../css/user_form.css">
</head>
<body>
<form action="" method="POST">
    <h1>Registro de usuario</h1>
    <input type="text" name="nom_usuari" placeholder=" Nombre Usuario"><br><br>

    <input type="email" name="email" placeholder=" Email"><br><br>

    <input type="password" name="contrasenya" placeholder=" Contraseña" required><br><br>

    <input type="text" name="nom" placeholder=" Nombre"><br><br>

    <input type="text" name="cognoms" placeholder=" Apellidos"><br><br>

    <button type="submit">Registrarse</button>
    <button class="button" onclick="window.location.href='login.php'">
    ¿Ya tienes cuenta? Inicia sesión aquí
    </button>
    <button type="button" onclick="window.location.href='../index.html'">
        Volver al inicio
    </button>
    <?php if ($message) echo "<p>$message</p>"; ?>
</form>
</body>
</html>
