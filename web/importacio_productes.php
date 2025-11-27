<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Importació de productes</title>
    <link rel="stylesheet" href="css/estils2.css">
</head>
<body>

<div class="container">
    <h1>Importar productes des d'Excel</h1>

    <form action="../php/procesar_importacio.php" 
          method="POST" 
          enctype="multipart/form-data">

        <div class="form-group">
            <label for="excel">Selecciona un fitxer Excel (.xlsx, .xls, .csv):</label>
            <input type="file" name="excel" id="excel" required>
        </div>

        <button type="submit">Importar productes</button>
    </form>
</div>

</body>
</html>
