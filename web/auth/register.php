<?php
session_start();

// Incluimos las funciones para leer/escribir usuarios
require_once __DIR__ . '/../includes/json_connect.php';


// Verificar que la carpeta data exista
$dataDir = __DIR__ . '/../../data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
}

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
        $message = '❌ Por favor rellena todos los campos obligatorios.';
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
            $message = '❌ Este nombre de usuario ya existe.';
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
    <link rel="stylesheet" href="../css/user_forms.css">
</head>
<body>
    <h1>Registro de usuario</h1>
<?php if ($message) echo "<p>$message</p>"; ?>

<form action="" method="POST">
    <label>Nombre de usuario*</label><br>
    <input type="text" name="nom_usuari" required><br><br>

    <label>Email*</label><br>
    <input type="email" name="email" required><br><br>

    <label>Contraseña*</label><br>
    <input type="password" name="contrasenya" required><br><br>

    <label>Nombre</label><br>
    <input type="text" name="nom"><br><br>

    <label>Apellidos</label><br>
    <input type="text" name="cognoms"><br><br>

    <button type="submit">Registrarse</button>
</form>

<p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>

</body>
</html>
