<?php
define('SMTP_HOST', 'mail.infomaniak.com');
define('SMTP_PORT', 587);
define('SMTP_USER', getenv('REDIRECT_SMTP_USER'));
define('SMTP_PASS', getenv('REDIRECT_SMTP_PASS'));
define('SMTP_FROM', getenv('REDIRECT_SMTP_FROM') ?: SMTP_USER);
define('SMTP_TO', getenv('REDIRECT_SMTP_TO') ?: SMTP_USER);

define('RECAPTCHA_SECRET', getenv('REDIRECT_RECAPTCHA_SECRET'));

