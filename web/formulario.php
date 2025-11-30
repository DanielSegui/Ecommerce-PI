<?php
// Comprovar que es rep un POST
$errors = [];
//$fitxer = __DIR__ . "/database/dades.txt";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recuperar i netejar dades
    $nom = isset($_POST['nom']) ? htmlspecialchars(trim($_POST['nom'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $edat = isset($_POST['edat']) ? intval($_POST['edat']) : 0;
    $telefon = isset($_POST['telefon']) ? htmlspecialchars(trim($_POST['telefon'])) : '';
    $consentiment = isset($_POST['consentiment']) ? "Sí" : "No";

    // Validació bàsica al servidor
    if (strlen($nom) < 3) {
        $errors[] = "El nom ha de tindre almenys 3 caràcters.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El correu no és vàlid.";
    }

    if (!preg_match('/^[0-9]{9}$/', $telefon)) {
        $errors[] = "El telèfon ha de tindre exactament 9 dígits.";
    }

    if ($edat < 18 || $edat > 99) {
        $errors[] = "L'edat ha d'estar entre 18 i 99 anys.";
    }

    if ($consentiment !== "Sí") {
        $errors[] = "Has d'acceptar el tractament de les teves dades.";
    }

    // Si no hi ha errors → guardar dades
    if (empty($errors)) {

        // Guardar les dades en un fitxer (append)
        $fitxer = "database/dades.txt";
        $dades = "Nom: $nom | Email: $email | Edat: $edat | Telèfon: $telefon | Consentiment: $consentiment\n";
        file_put_contents( $fitxer,$dades, FILE_APPEND | LOCK_EX);

        // Missatge de confirmació
        echo "<h2>Dades enviades correctament!</h2>";
        echo "<p>Gràcies per contactar amb nosaltres, $nom.</p>";
        echo "<a href='index.html'>Tornar a la pàgina principal</a>";

        exit; // Evita que es torne a mostrar el formulari
    }
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <title>Formulari de contacte</title>
  <link rel="icon" type="image/png" href="./imgs/logoPest.png">
  <link rel="stylesheet" href="./css/estils.css">
</head>
<body>
  <div class="container">
    <h1>Contacta amb nosaltres</h1>

    <!-- FORMULARI AMB POST -->
    <form id="formContacte" action="formulario.php" method="POST">
      <div class="form-group">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo isset($nom) ? $nom : ''; ?>">
      </div>

      <div class="form-group">
        <label for="email">Correu:</label>
        <input type="text" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
      </div>

      <div class="form-group">
        <label for="edat">Edat:</label>
        <input type="text" id="edat" name="edat" value="<?php echo isset($edat) ? $edat : ''; ?>">
      </div>

      <div class="form-group">
        <label for="telefon">Telèfon:</label>
        <input type="tel" id="telefon" name="telefon" pattern="[0-9]{9}" placeholder="Ex: 600123456" value="<?php echo isset($telefon) ? $telefon : ''; ?>">
      </div>

      <div class="form-group simple-checkbox">
        <input type="checkbox" id="consentiment" name="consentiment" <?php if(isset($consentiment) && $consentiment === "Sí") echo "checked"; ?>>
        <label for="consentiment">Accepte el tractament de les meves dades</label>
      </div>

      <button type="submit">Enviar</button>
    </form>

    <!-- Mostrar errors si n’hi ha -->
    <?php
      if (!empty($errors)) {
          echo "<div class='error-list'><ul>";
          foreach ($errors as $error) {
              echo "<li>" . $error . "</li>";
          }
          echo "</ul>";
      }
    ?>
  </div>
  <script src="js/validacio.js"></script>
</body>
</html>
