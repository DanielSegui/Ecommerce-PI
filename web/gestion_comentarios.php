<?php
session_start(); // Necesario para identificar al usuario
header('Content-Type: application/json');
$archivo = 'comentarios.json';

$comentarios = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];

// Simulamos un usuario si no ha iniciado sesión (para que no falle)
$usuarioActual = $_SESSION['usuario'] ?? 'Invitado_' . substr(session_id(), 0, 4);

// --- ACCIÓN: CREAR ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'crear') {
    $nuevo = [
        'id' => uniqid(),
        'usuario' => $usuarioActual, // Guardamos quién lo escribió
        'texto' => htmlspecialchars($_POST['texto']),
        'estrellas' => (int)$_POST['estrellas'], // Guardamos la valoración
        'vehiculo' => $_POST['vehiculo'],
        'fecha' => date("d/m/Y H:i")
    ];
    array_unshift($comentarios, $nuevo);
    file_put_contents($archivo, json_encode($comentarios, JSON_PRETTY_PRINT));
    echo json_encode(['success' => true]);
    exit;
}

// --- ACCIÓN: BORRAR (Protegida) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'borrar') {
    $idABorrar = $_POST['id'];
    
    // Buscamos el comentario para verificar el autor
    foreach ($comentarios as $index => $c) {
        if ($c['id'] === $idABorrar) {
            if ($c['usuario'] === $usuarioActual) { // SOLO SI ES EL DUEÑO
                unset($comentarios[$index]);
                file_put_contents($archivo, json_encode(array_values($comentarios), JSON_PRETTY_PRINT));
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No tienes permiso']);
            }
            exit;
        }
    }
}

// --- ACCIÓN: CARGAR ---
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $vId = $_GET['vehiculo'] ?? '';
    $filtrados = array_values(array_filter($comentarios, function($c) use ($vId) {
        return $c['vehiculo'] === $vId;
    }));
    // Enviamos también quién es el usuario actual para que el JS sepa si mostrar el botón borrar
    echo json_encode(['comentarios' => $filtrados, 'usuarioSesion' => $usuarioActual]);
    exit;
}
?>