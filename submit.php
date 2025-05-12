<?php
$validAnreden = ['Herr', 'Frau', 'Divers'];

$anrede   = trim($_POST['anrede'] ?? '');
$vorname  = trim($_POST['vorname'] ?? '');
$nachname = trim($_POST['nachname'] ?? '');
$email    = trim($_POST['email'] ?? '');
$message  = trim($_POST['message'] ?? '');

if (
    empty($anrede) || empty($vorname) || empty($nachname) ||
    empty($email) || empty($message) ||
    !in_array($anrede, $validAnreden) ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
    $error = "Bitte füllen Sie alle Felder korrekt aus.";
} else {
    // Datenbankverbindung mit SQLite
    $dbPath = __DIR__ . '/kontakt.db';
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Eintrag speichern
    $stmt = $pdo->prepare("
        INSERT INTO kontakt (anrede, vorname, nachname, email, nachricht)
        VALUES (:anrede, :vorname, :nachname, :email, :nachricht)
    ");
    $stmt->execute([
        ':anrede'   => $anrede,
        ':vorname'  => $vorname,
        ':nachname' => $nachname,
        ':email'    => $email,
        ':nachricht'=> $message
    ]);

    $safeVorname = htmlspecialchars($vorname);
    $success = "Vielen Dank, $safeVorname, wir haben deine Nachricht erhalten.";
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Formular Rückmeldung</title>
    <style>
        .box {
            margin: 20px;
            padding: 15px;
            border-radius: 8px;
            font-family: sans-serif;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <?php if (!empty($error)): ?>
        <div class="box error"><?= htmlspecialchars($error) ?></div>
    <?php elseif (!empty($success)): ?>
        <div class="box success"><?= $success ?></div>
    <?php endif; ?>
</body>
</html>
