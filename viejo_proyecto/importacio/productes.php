<?php
require __DIR__ . '/../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$message = ""; // Variable para mostrar mensaje al usuario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['excel']['tmp_name']) || !is_uploaded_file($_FILES['excel']['tmp_name'])) {
        $message = "❌ No se recibió la ruta del archivo subido.";
    } else {
        $filepath = "./../uploads/" . $_FILES['excel']['name'];
        move_uploaded_file($_FILES['excel']['tmp_name'], $filepath);

        try {
            $spreadsheet = IOFactory::load($filepath);
        } catch (Exception $e) {
            $message = "❌ Error al leer el archivo Excel: " . $e->getMessage();
        }

        if (empty($message)) {
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $header = array_map('strtolower', $rows[0]);
            $expected = ['sku', 'nom', 'descripcio', 'img', 'preu', 'estoc'];

            foreach ($expected as $col) {
                if (!in_array($col, $header)) {
                    $message = "❌ Falta la columna requerida: $col";
                    break;
                }
            }

            if (empty($message)) {
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

                $jsonDir = __DIR__ . '/../data/';
                if (!is_dir($jsonDir)) mkdir($jsonDir, 0775, true);
                $jsonPath = $jsonDir . 'products.json';
                $jsonData = json_encode(["productes" => $data], JSON_PRETTY_PRINT);
                if (file_put_contents($jsonPath, $jsonData) === false) {
                    $message = "❌ Error escribiendo JSON";
                } else {
                    $message = "✔ Importación completada. Total productos importados: " . count($data);
                }
            }
        }
    }
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

    <?php if (!empty($message)): ?>
        <div class="message" style="margin-top:20px; padding:10px; border:1px solid #ccc; background-color: green;">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
</div>


</body>
</html>
