<?php
require_once 'config.php';

$message = '';
if ($_POST) {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $message_text = trim($_POST['message']);
    
    if ($nom && $email && $message_text && isset($_POST['rgpd_consent'])) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (nom, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$nom, $email, $message_text]);
            $message = "Votre message a été envoyé avec succès !";
        } catch(Exception $e) {
            $message = "Erreur lors de l'envoi du message.";
        }
    } else {
        $message = "Veuillez remplir tous les champs et accepter le traitement des données.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - TechSolutions</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <a href="index.php"><img src="assets/logo.png" alt="TechSolutions"></a>
                </div>
                <ul class="nav-center">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="actualites.php">Actualités</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
                <div class="nav-right">
                    <a href="admin/login.php" class="login-btn">Connexion</a>
                </div>
            </nav>
        </div>
    </header>

    <section class="section">
        <div class="container">
            <h1>Contactez-nous</h1>
            
            <?php if ($message): ?>
                <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <div class="contact-content">
                <div class="contact-info">
                    <h3>Nos coordonnées</h3>
                    <div class="contact-item">
                        <strong>Adresse :</strong>
                        12 rue des Innovateurs<br>
                        19100 Brive-la-Gaillarde, France
                    </div>
                    <div class="contact-item">
                        <strong>Contact :</strong>
                        Mme Anna LISE<br>
                    </div>
                    <div class="contact-item">
                        <strong>Email :</strong>
                        contact@techsolutions.com
                    </div>
                    <div class="contact-item">
                        <strong>Horaires :</strong>
                        Lundi - Vendredi : 9h00 - 18h00<br>
                        Samedi : 10h00 - 16h00
                    </div>
                </div>
                
                <form class="contact-form" method="post">
                    <h3>Envoyez-nous un message</h3>
                    <div class="form-group">
                        <label for="nom">Nom complet *</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" required placeholder="Décrivez votre demande..."></textarea>
                    </div>
                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: normal;">
                            <input type="checkbox" name="rgpd_consent" required>
                            J'accepte le traitement de mes données *
                        </label>
                    </div>
                    <p style="font-size: 0.9rem; color: #666; margin-bottom: 1rem;">
                        <a href="rgpd.php" target="_blank">Politique de confidentialité</a>
                    </p>
                    <button type="submit" class="btn">Envoyer le message</button>
                </form>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2024 TechSolutions. Tous droits réservés. | <a href="rgpd.php" style="color: #ccc;">RGPD</a></p>
        </div>
    </footer>
</body>
</html>