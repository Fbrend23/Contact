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
    <h1>Formulaire de contact - <?= htmlspecialchars($origin) ?></h1>
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="confirmation">
        ✅ Votre message a bien été envoyé. Merci !
    </div>
<?php endif; ?>

    <form method="POST" action="php/send.php">
        
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        
        <label for="sujet">Sujet :</label>
        <input type="text" id="sujet" name="sujet" required>
        
        <label for="message">Message :</label>
        <textarea id="message" name="message" required></textarea>
        <input type="hidden" name="origin" value="<?= htmlspecialchars($origin) ?>">
        <div class="g-recaptcha" data-sitekey="6LfyrCkrAAAAAPOI-RRG2m-3oEe8AriV9YYMjFfa"></div>
    <button type="submit">Envoyer</button>
</form>

</body>
</html>
