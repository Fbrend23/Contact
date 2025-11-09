## Contact — Formulaire de contact multi-site (PHP)

Formulaire de contact centralisé, pensé pour être hébergé sur un sous-domaine dédié et réutilisé par plusieurs sites. Architecture simple (PHP + CSS), validation côté serveur, honeypot, reCAPTCHA, envoi via SMTP. 

---

## Fonctionnalités
- Multi-site : un même backend pour plusieurs frontaux (domaines différents).
- Envoi d’e-mails via SMTP (PHPMailer).
- Anti-spam : reCAPTCHA v2/v3 + champ honeypot.
- Validation serveur (tous champs critiques).
- Réponses JSON prêtes à consommer côté front.
- Config par variables d’environnement (clés SMTP, reCAPTCHA, origines autorisées).
