<?php
// Balise d'ouverture PHP
require_once 'config.php';
// Inclusion du fichier de configuration (connexion BDD + session)
// require_once garantit une seule inclusion du fichier

$message = '';
// Initialisation de la variable message (vide par défaut)
if ($_POST) {
    // Condition : vérifie si le formulaire a été soumis en POST
    // $_POST est un tableau contenant les données du formulaire
    $nom = trim($_POST['nom']);
    // Récupère le nom et supprime les espaces avant/après avec trim()
    $email = trim($_POST['email']);
    // Récupère l'email et supprime les espaces
    $message_text = trim($_POST['message']);
    // Récupère le message et supprime les espaces
    
    if ($nom && $email && $message_text && isset($_POST['rgpd_consent'])) {
        // Condition : vérifie que tous les champs sont remplis ET que la case RGPD est cochée
        // isset() vérifie si la variable existe
        try {
            // Bloc try pour gérer les erreurs d'insertion
            $stmt = $pdo->prepare("INSERT INTO contacts (nom, email, message) VALUES (?, ?, ?)");
            // Préparation de la requête SQL avec paramètres (?) pour éviter injection SQL
            // INSERT INTO ajoute une nouvelle ligne dans la table contacts
            $stmt->execute([$nom, $email, $message_text]);
            // Exécution de la requête avec les valeurs dans un tableau
            $message = "Votre message a été envoyé avec succès !";
            // Message de confirmation
        } catch(Exception $e) {
            // Bloc catch : capture les erreurs
            $message = "Erreur lors de l'envoi du message.";
            // Message d'erreur générique (sans détails pour la sécurité)
        }
    } else {
        // Sinon (champs manquants ou RGPD non accepté)
        $message = "Veuillez remplir tous les champs et accepter le traitement des données.";
        // Message d'erreur de validation
    }
}
?>
<!DOCTYPE html>
<!-- Déclaration du type de document HTML5 -->
<html lang="fr">
<!-- Langue du document en français -->
<head>
    <!-- En-tête du document -->
    <meta charset="UTF-8">
    <!-- Encodage UTF-8 pour les accents -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Configuration responsive -->
    <title>Contact - TechSolutions</title>
    <!-- Titre de la page -->
    <link rel="stylesheet" href="assets/style.css">
    <!-- Lien vers la feuille de style -->
</head>
<body>
    <!-- Corps du document -->
    <header>
        <!-- En-tête de la page -->
        <div class="container">
            <!-- Conteneur -->
            <nav>
                <!-- Barre de navigation -->
                <div class="logo">
                    <!-- Conteneur du logo -->
                    <a href="index.php"><img src="assets/logo.png" alt="TechSolutions"></a>
                    <!-- Lien vers l'accueil avec logo -->
                </div>
                <ul class="nav-center">
                    <!-- Menu de navigation -->
                    <li><a href="index.php">Accueil</a></li>
                    <!-- Lien Accueil -->
                    <li><a href="actualites.php">Actualités</a></li>
                    <!-- Lien Actualités -->
                    <li><a href="contact.php">Contact</a></li>
                    <!-- Lien Contact (page actuelle) -->
                </ul>
                <div class="nav-right">
                    <!-- Conteneur droite -->
                    <a href="admin/login.php" class="login-btn">Connexion</a>
                    <!-- Bouton de connexion -->
                </div>
            </nav>
            <!-- Fin navigation -->
        </div>
        <!-- Fin conteneur -->
    </header>
    <!-- Fin en-tête -->


    <section class="section">
        <!-- Section principale -->
        <div class="container">
            <!-- Conteneur -->
            <h1>Contactez-nous</h1>
            <!-- Titre principal -->
            
            <?php if ($message): ?>
                <!-- Condition PHP : si un message existe -->
                <div class="message"><?php echo htmlspecialchars($message); ?></div>
                <!-- Affichage du message avec échappement HTML pour sécurité -->
            <?php endif; ?>
            <!-- Fin de la condition -->
            
            
            <div class="contact-content">
                <!-- Conteneur pour le contenu contact (grille 2 colonnes) -->
                <div class="contact-info">
                    <!-- Colonne gauche : informations de contact -->
                    <h3>Nos coordonnées</h3>
                    <!-- Titre de la section -->
                    <div class="contact-item">
                        <!-- Bloc d'information -->
                        <strong>Adresse :</strong>
                        <!-- Libellé en gras -->
                        12 rue des Innovateurs<br>
                        <!-- Adresse avec saut de ligne (<br>) -->
                        19100 Brive-la-Gaillarde, France
                    </div>
                    <div class="contact-item">
                        <!-- Bloc contact -->
                        <strong>Contact :</strong>
                        Mme Anna LISE<br>
                        <!-- Nom du contact -->
                    </div>
                    <div class="contact-item">
                        <!-- Bloc email -->
                        <strong>Email :</strong>
                        contact@techsolutions.com
                    </div>
                    <div class="contact-item">
                        <!-- Bloc horaires -->
                        <strong>Horaires :</strong>
                        Lundi - Vendredi : 9h00 - 18h00<br>
                        Samedi : 10h00 - 16h00
                    </div>
                </div>
                <!-- Fin des informations de contact -->
                
                
                <form class="contact-form" method="post">
                    <!-- Formulaire de contact avec méthode POST -->
                    <h3>Envoyez-nous un message</h3>
                    <!-- Titre du formulaire -->
                    <div class="form-group">
                        <!-- Groupe de champ formulaire -->
                        <label for="nom">Nom complet *</label>
                        <!-- Étiquette liée au champ nom, * = obligatoire -->
                        <input type="text" id="nom" name="nom" required>
                        <!-- Champ texte pour le nom, required = obligatoire en HTML5 -->
                    </div>
                    <div class="form-group">
                        <!-- Groupe email -->
                        <label for="email">Email *</label>
                        <!-- Étiquette email -->
                        <input type="email" id="email" name="email" required>
                        <!-- Champ email avec validation HTML5 -->
                    </div>
                    <div class="form-group">
                        <!-- Groupe message -->
                        <label for="message">Message *</label>
                        <!-- Étiquette message -->
                        <textarea id="message" name="message" required placeholder="Décrivez votre demande..."></textarea>
                        <!-- Zone de texte multiligne avec placeholder (texte indicatif) -->
                    </div>
                    <div class="form-group">
                        <!-- Groupe consentement RGPD -->
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: normal;">
                            <!-- Label avec style inline : flexbox, aligné au centre, espacement 0.5rem -->
                            <input type="checkbox" name="rgpd_consent" required>
                            <!-- Case à cocher obligatoire pour le consentement RGPD -->
                            J'accepte le traitement de mes données *
                        </label>
                    </div>
                    <p style="font-size: 0.9rem; color: #666; margin-bottom: 1rem;">
                        <!-- Paragraphe avec style inline : taille 0.9rem, couleur grise -->
                        <a href="rgpd.php" target="_blank">Politique de confidentialité</a>
                        <!-- Lien vers la page RGPD, target="_blank" = nouvel onglet -->
                    </p>
                    <button type="submit" class="btn">Envoyer le message</button>
                    <!-- Bouton de soumission du formulaire -->
                </form>
                <!-- Fin du formulaire -->
            </div>
            <!-- Fin du conteneur contact-content -->
        </div>
        <!-- Fin du conteneur -->
    </section>
    <!-- Fin de la section -->


    <footer>
        <!-- Pied de page -->
        <div class="container">
            <!-- Conteneur -->
            <p>&copy; 2024 TechSolutions. Tous droits réservés. | <a href="rgpd.php" style="color: #ccc;">RGPD</a></p>
            <!-- Copyright avec lien RGPD en couleur grise (#ccc) -->
        </div>
    </footer>
    <!-- Fin footer -->
</body>
<!-- Fin body -->
</html>
<!-- Fin HTML -->