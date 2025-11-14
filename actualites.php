<?php
require_once 'config.php';

try {
    $actualites = $pdo->query("SELECT * FROM actualites WHERE actif = 1 ORDER BY date_publication DESC")->fetchAll();
} catch(Exception $e) {
    $actualites = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualités - TechSolutions</title>
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
            <h1>Nos Actualités</h1>
            
            <div class="actualites-grid">
                <?php if ($actualites): ?>
                    <?php foreach ($actualites as $actu): ?>
                    <div class="actualite-card">
                        <h3><?php echo htmlspecialchars($actu['titre']); ?></h3>
                        <div class="date"><?php echo date('d/m/Y', strtotime($actu['date_publication'])); ?></div>
                        <p><?php echo nl2br(htmlspecialchars($actu['contenu'])); ?></p>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="actualite-card">
                        <h3>Aucune actualité disponible</h3>
                        <p>Revenez bientôt pour découvrir nos dernières nouvelles !</p>
                    </div>
                <?php endif; ?>
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