<?php
$origin = $_GET['origin'] ?? 'default';
$allowedOrigins = ['photo','beer','meow'];
if (!in_array($origin, $allowedOrigins)) {
    $origin = 'default';
}
$redirectUrls = [
    'default' => 'https://brendanfleurdelys.ch',
    'photo' => 'https://photographie.brendanfleurdelys.ch',
    'beer' => 'https://horaire.brendanfleurdelys.ch/',
    'meow' => 'https://meow.brendanfleurdelys.ch'
];

$returnUrl = $redirectUrls[$origin];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - <?= htmlspecialchars($origin) ?></title>
    <meta name="description" content="Formulaire de contact">
    <meta name="author" content="Brendan Fleurdelys">
    <link rel="icon" href="assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body class="theme-<?= $origin ?>">
    <a href="<?= $returnUrl ?>"><img src="assets/logo.png" alt="logo" class="logo"></a>
    <form method="POST" action="php/send.php">
        <h1>Formulaire de contact</h1>
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="confirmation">
                <p>✅ Votre message a bien été envoyé. Merci !</p>
                <a href="<?= $returnUrl ?>">Retour au site</a>
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
                        echo "❌ Échec de la vérification reCAPTCHA.<br> Merci de réessayer.";
                        break;
                    default:
                        echo "❌ Une erreur est survenue.<br> Merci de réessayer.";
                }
                ?>
            </div>
        <?php endif; ?>
        <select name="sujet" id="sujet" required>
            <option value="" disabled selected>-- Choisissez un sujet --</option>
            <option value="Demande générale">Demande générale</option>
            <option value="Problème technique">Problème technique</option>
            <option value="Proposition de collaboration">Proposition de collaboration</option>
            <option value="Autre">Autre</option>
        </select>
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" required value="<?= htmlspecialchars($_GET['name'] ?? '') ?>">

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">

        <label for="message">Message :</label>
        <textarea id="message" name="message" required value="<?= htmlspecialchars($_GET['message'] ?? '') ?>"></textarea>
        <input type="hidden" name="origin" value="<?= htmlspecialchars($origin) ?>">
        <input type="text" name="hp_field" class="visually-hidden" tabindex="-1" autocomplete="off">
        <div class="g-recaptcha" data-sitekey="6LfyrCkrAAAAAPOI-RRG2m-3oEe8AriV9YYMjFfa"></div>
        <button type="submit">Envoyer</button>
    </form>
<footer><p>© 2025 Brendan Fleurdelys</p></footer>
</body>

</html>