<?php
// Comprovar que es rep un POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recuperar i netejar dades
    $nom = isset($_POST['nom']) ? htmlspecialchars(trim($_POST['nom'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $edat = isset($_POST['edat']) ? htmlspecialchars(trim($_POST['edat'])) : '';
    $telefon = isset($_POST['telefon']) ? htmlspecialchars(trim($_POST['telefon'])) : '';
    $consentiment = isset($_POST['consentiment']) ? "Sí" : "No";

    // Validació bàsica al servidor
    $errors = [];

    if (strlen($nom) < 3) {
        $errors[] = "El nom ha de tindre almenys 3 caràcters.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El correu no és vàlid.";
    }

    if (!preg_match('/^[0-9]{9}$/', $telefon)) {
        $errors[] = "El telèfon ha de tindre exactament 9 dígits.";
    }

    if ($edat) {
        if ($edat < 18 || $edat > 99) {
            $errors[] = "L'edat ha d'estar entre 18 i 99 anys.";
        }
    }

    if ($consentiment !== "Sí") {
        $errors[] = "Has d'acceptar el tractament de les teves dades.";
    }

    // Si hi ha errors, mostrar-los
    if (!empty($errors)) {
        echo "<h2>Hi ha errors en el formulari:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>" . $error . "</li>";
        }
        echo "</ul><a href='../frontend/index.html'>Tornar al formulari</a>";
        exit;
    }

    // Guardar les dades en un fitxer (append)
    $fitxer = "../database/dades.txt";
    $dades = "Nom: $nom | Email: $email | Edat: $edat | Telèfon: $telefon | Consentiment: $consentiment\n";
    file_put_contents($fitxer, $dades, FILE_APPEND | LOCK_EX);

    // Missatge de confirmació
    echo "<h2>Dades enviades correctament!</h2>";
    echo "<p>Gràcies per contactar amb nosaltres, $nom.</p>";
    echo "<a href='../frontend/index.html'>Tornar al formulari</a>";

} else {
    // Si s’accedeix directament per GET
    echo "<p>Forma d'enviament incorrecta.</p>";
    echo "<a href='../frontend/index.html'>Tornar al formulari</a>";
}
?>
