<?php
// procesar_importacio.php
// Procesa el Excel subido y genera JSON en data/products.json

require __DIR__ . '/../PhpSpreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if (!isset($_POST['uploaded_file_path'])) {
    die("❌ No se recibió la ruta del archivo subido.");
}

$filepath = $_POST['uploaded_file_path'];

// Leer Excel
try {
    $spreadsheet = IOFactory::load($filepath);
} catch (Exception $e) {
    die("❌ Error al leer el archivo Excel: " . $e->getMessage());
}

$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray();

// Validar columnas
$header = array_map('strtolower', $rows[0]);
$expected = ['sku', 'nom', 'descripcio', 'img', 'preu', 'estoc'];

foreach ($expected as $col) {
    if (!in_array($col, $header)) {
        die("❌ Falta la columna requerida: $col");
    }
}

// Procesar filas
$data = [];
$id = 1;

for ($i = 1; $i < count($rows); $i++) {
    $row = $rows[$i];
    if (empty($row) || empty($row[0])) continue;

    $data[] = [
        "id" => $id++,
        "sku" => $row[array_search('sku', $header)],
        "nom" => $row[array_search('nom', $header)],
        "descripcio" => $row[array_search('descripcio', $header)],
        "img" => $row[array_search('img', $header)],
        "preu" => floatval($row[array_search('preu', $header)]),
        "estoc" => intval($row[array_search('estoc', $header)])
    ];
}

// Guardar JSON
$jsonDir = __DIR__ . '/../data/';
if (!is_dir($jsonDir)) mkdir($jsonDir, 0775, true);

$jsonPath = $jsonDir . 'products.json';
$jsonData = json_encode(["productes" => $data], JSON_PRETTY_PRINT);
if (file_put_contents($jsonPath, $jsonData) === false) die("❌ Error escribiendo JSON");

// Mensaje final
echo "<h2>✔ Importación completada</h2>";
echo "<p>Total productos importados: " . count($data) . "</p>";
?>
