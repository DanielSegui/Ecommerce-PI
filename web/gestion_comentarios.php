<?php
header('Content-Type: application/json');
$archivo = 'comentarios.json';

// Si el archivo no existe, lo creamos vacío
if (!file_exists($archivo)) {
    file_put_contents($archivo, json_encode([]));
}

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

// ACCIÓN: CARGAR (Al entrar en la página)
if ($accion === 'cargar') {
    $comentarios = json_decode(file_get_contents($archivo), true);
    echo json_encode($comentarios);
    exit;
}

// ACCIÓN: CREAR
if ($accion === 'crear') {
    $comentarios = json_decode(file_get_contents($archivo), true);
    
    $nuevo = [
        'id' => time(), // Usamos el tiempo como ID único
        'texto' => htmlspecialchars($_POST['texto']),
        'estrellas' => (int)$_POST['estrellas'],
        'usuario' => 'Cliente VIP' // Aquí podrías poner el nombre de sesión
    ];
    
    array_unshift($comentarios, $nuevo); // Añadir al principio
    file_put_contents($archivo, json_encode($comentarios));
    
    echo json_encode(['success' => true, 'comentario' => $nuevo]);
    exit;
}

// ACCIÓN: BORRAR
if ($accion === 'borrar') {
    $id = $_POST['id'];
    $comentarios = json_decode(file_get_contents($archivo), true);
    
    $comentariosFiltrados = array_filter($comentarios, function($c) use ($id) {
        return $c['id'] != $id;
    });
    
    file_put_contents($archivo, json_encode(array_values($comentariosFiltrados)));
    echo json_encode(['success' => true]);
    exit;
}