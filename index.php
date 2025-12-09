<!DOCTYPE html>
<!-- Déclaration du type de document HTML5 -->
<html lang="fr">
<!-- Balise html avec attribut lang="fr" pour indiquer la langue française -->
<head>
    <!-- En-tête du document contenant les métadonnées -->
    <meta charset="UTF-8">
    <!-- Définit l'encodage des caractères en UTF-8 pour les accents -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Configuration responsive : largeur = largeur de l'écran, zoom initial = 1 -->
    <title>TechSolutions - Accueil</title>
    <!-- Titre affiché dans l'onglet du navigateur -->
    <link rel="stylesheet" href="assets/style.css">
    <!-- Lien vers la feuille de style CSS externe -->
</head>
<body>
    <!-- Corps du document contenant le contenu visible -->
    <header>
        <!-- En-tête de la page -->
        <div class="container">
            <!-- Conteneur pour centrer et limiter la largeur -->
            <nav>
                <!-- Barre de navigation -->
                <div class="logo">
                    <!-- Conteneur du logo -->
                    <a href="index.php"><img src="assets/logo.png" alt="TechSolutions"></a>
                    <!-- Lien vers l'accueil avec image du logo, alt pour l'accessibilité -->
                </div>
                <ul class="nav-center">
                    <!-- Liste non ordonnée pour le menu de navigation centré -->
                    <li><a href="index.php">Accueil</a></li>
                    <!-- Élément de liste avec lien vers la page d'accueil -->
                    <li><a href="actualites.php">Actualités</a></li>
                    <!-- Élément de liste avec lien vers la page actualités -->
                    <li><a href="contact.php">Contact</a></li>
                    <!-- Élément de liste avec lien vers la page contact -->
                </ul>
                <div class="nav-right">
                    <!-- Conteneur pour les éléments alignés à droite -->
                    <a href="admin/login.php" class="login-btn">Connexion</a>
                    <!-- Bouton de connexion vers l'interface admin -->
                </div>
            </nav>
            <!-- Fin de la navigation -->
        </div>
        <!-- Fin du conteneur -->
    </header>
    <!-- Fin de l'en-tête -->


    <section class="hero">
        <!-- Section hero (bannière principale) avec classe CSS -->
        <div class="container">
            <!-- Conteneur pour centrer le contenu -->

            <h1>TechSolutions</h1>
            <!-- Titre principal de niveau 1 -->
            <p>Services informatiques - Votre partenaire technologique</p>
            <!-- Slogan de l'entreprise -->
            <a href="contact.php" class="btn">Nous contacter</a>
            <!-- Bouton call-to-action vers la page contact -->
        </div>
        <!-- Fin du conteneur -->
    </section>
    <!-- Fin de la section hero -->


    <section class="section">
        <!-- Section de contenu avec classe CSS -->
        <div class="container">
            <!-- Conteneur pour centrer le contenu -->
            <h2>Présentation de l'entreprise</h2>
            <!-- Titre de niveau 2 pour la section -->
            <p class="presentation">
                <!-- Paragraphe avec classe CSS pour le style -->
                TechSolutions est une entreprise spécialisée dans les services informatiques, 
                offrant des solutions technologiques complètes pour les entreprises et particuliers. 
                Basée à Brive-la-Gaillarde, nous accompagnons nos clients dans leur transformation digitale.
            </p>
        </div>
        <!-- Fin du conteneur -->
    </section>
    <!-- Fin de la section présentation -->


    <section class="section section-gray">
        <!-- Section avec fond gris (classe section-gray) -->
        <div class="container">
            <!-- Conteneur pour centrer le contenu -->
            <h2>Nos Services</h2>
            <!-- Titre de niveau 2 pour la section services -->
            <div class="services">
                <!-- Conteneur pour la grille de services -->
                <div class="service-card">
                    <!-- Carte individuelle pour un service -->
                    <h3>Développement logiciel</h3>
                    <!-- Titre du service -->
                    <p>Création d'applications sur mesure et solutions logicielles personnalisées.</p>
                    <!-- Description du service -->
                </div>
                <!-- Fin de la première carte -->
                <div class="service-card">
                    <!-- Deuxième carte de service -->
                    <h3>Conseil</h3>
                    <!-- Titre du service -->
                    <p>Accompagnement et conseil pour vos projets informatiques.</p>
                    <!-- Description du service -->
                </div>
                <!-- Fin de la deuxième carte -->
            </div>
            <!-- Fin du conteneur services -->
        </div>
        <!-- Fin du conteneur -->
    </section>
    <!-- Fin de la section services -->


    <footer>
        <!-- Pied de page du site -->
        <div class="container">
            <!-- Conteneur pour centrer le contenu -->
            <p>&copy; 2024 TechSolutions. Tous droits réservés. | <a href="rgpd.php">RGPD</a></p>
            <!-- Paragraphe avec copyright (&copy; = ©) et lien vers la page RGPD -->
            <p>12 rue des Innovateurs, 19100 Brive-la-Gaillarde</p>
            <!-- Adresse de l'entreprise -->
        </div>
        <!-- Fin du conteneur -->
    </footer>
    <!-- Fin du pied de page -->
</body>
<!-- Fin du corps du document -->
</html>
<!-- Fin du document HTML -->