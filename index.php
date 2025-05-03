<?php
$origin = $_GET['origin'] ?? 'default';
$allowedOrigins = ['photo', 'site2'];
if (!in_array($origin, $allowedOrigins)) {
    $origin = 'default';
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Contact - <?= htmlspecialchars($origin) ?></title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="theme-<?= $origin ?>">
    <form method="POST" action="php/send.php">
    <h1>Formulaire de contact</h1>
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="confirmation">
                ✅ Votre message a bien été envoyé. Merci !
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="error">
                <?php
                switch ($_GET['error']) {
                    case 'missing_fields':
                        echo "❌ Veuillez remplir tous les champs du formulaire.";
                        break;
                    case 'recaptcha_failed':
                        echo "❌ Échec de la vérification reCAPTCHA. Merci de réessayer.";
                        break;
                    default:
                        echo "❌ Une erreur est survenue. Merci de réessayer.";
                }
                ?>
            </div>
        <?php endif; ?>
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" required value="<?= htmlspecialchars($_GET['name'] ?? '') ?>">

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">

        <label for="sujet">Sujet :</label>
        <input type="text" id="sujet" name="sujet" required value="<?= htmlspecialchars($_GET['sujet'] ?? '') ?>">

        <label for="message">Message :</label>
        <textarea id="message" name="message" required value="<?= htmlspecialchars($_GET['message'] ?? '') ?>"></textarea>
        <input type="hidden" name="origin" value="<?= htmlspecialchars($origin) ?>">
        <div class="g-recaptcha" data-sitekey="6LfyrCkrAAAAAPOI-RRG2m-3oEe8AriV9YYMjFfa"></div>
        <button type="submit">Envoyer</button>
    </form>

</body>

</html>