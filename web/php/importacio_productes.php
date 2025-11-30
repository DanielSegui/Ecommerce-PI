<?php
// importacio_productes.php
// Muestra formulario, recibe Excel, lo guarda en uploads, y llama al procesar_importacio.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_FILES['excel'])) {
        die("❌ No se ha subido ningún archivo.");
    }

    $file = $_FILES['excel'];

    // Tipos permitidos
    $allowed = [
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-excel',
        'text/csv'
    ];

    if (!in_array($file['type'], $allowed)) {
        die("❌ Formato no permitido. Usa XLSX, XLS o CSV.");
    }

    // Carpeta uploads (ruta absoluta)
    $uploadsDir = '/home/batoi/Escritorio/2ºDAW/Proyecto_Inter/Ecommerce-PI/uploads/';

    // Crear carpeta si no existe
    if (!is_dir($uploadsDir)) {
        if (!mkdir($uploadsDir, 0775, true)) {
            die("❌ No se pudo crear la carpeta uploads. Revisa permisos del directorio padre.");
        }
        @chown($uploadsDir, 'www-data');
        @chgrp($uploadsDir, 'www-data');
    }

    $filename = 'import_' . time() . '_' . basename($file['name']);
    $filepath = $uploadsDir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        die("❌ Error al guardar el archivo subido. Revisa permisos.");
    }

    // Pasar la ruta al script de procesamiento
    $_POST['uploaded_file_path'] = $filepath;

    // Script de procesamiento fuera de web
    $scriptReal = '/home/batoi/Escritorio/2ºDAW/Proyecto_Inter/Ecommerce-PI/php/procesar_importacio.php';

    if (!file_exists($scriptReal)) {
        die("❌ No se ha encontrado el script de procesamiento.");
    }

    require $scriptReal;
    exit;
}
?>

<!DOCTYPE html>

<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Importación de productos</title>
    <link rel="stylesheet" href="../css/estils2.css">
</head>
<body>
    <div class="container">
        <h1>Importar productos desde Excel</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="excel">Selecciona un archivo Excel (.xlsx, .xls, .csv):</label>
                <input type="file" name="excel" id="excel" required>
            </div>
            <button type="submit">Importar productos</button>
        </form>
    </div>
</body>
</html>
