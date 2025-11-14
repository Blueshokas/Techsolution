<?php
require_once 'config.php';

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: index.php');
    exit;
}

try {
    // Récupérer les PC avec leurs composants
    $stmt = $pdo->query("
        SELECT p.*, 
               GROUP_CONCAT(DISTINCT CONCAT(c.nom, ' (', c.type, ')') SEPARATOR ', ') as composants
        FROM pcs p
        LEFT JOIN pc_components pc ON p.id = pc.pc_id
        LEFT JOIN components c ON pc.component_id = c.id
        WHERE p.actif = 1
        GROUP BY p.id
        ORDER BY p.prix ASC
    ");
    $pcs = $stmt->fetchAll();
} catch(Exception $e) {
    $pcs = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parc Informatique - TechSolutions</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <a href="admin/dashboard.php"><img src="assets/logo.png" alt="TechSolutions"></a>
                </div>
                <ul class="nav-center">
                    <li><a href="admin/dashboard.php">Dashboard</a></li>
                    <li><a href="pc.php">Parc Informatique</a></li>
                </ul>
                <div class="nav-right">
                    <a href="admin/logout.php" class="login-btn">Déconnexion</a>
                </div>
            </nav>
        </div>
    </header>

    <section class="section">
        <div class="container">
            <h1>Parc Informatique</h1>
            <p style="text-align: center; margin-bottom: 2rem; color: #666;">Gestion du parc informatique de l'entreprise par poste de travail</p>
            <div class="pc-grid">
                <?php if ($pcs): ?>
                    <?php foreach ($pcs as $pc): ?>
                    <div class="pc-card">
                        <h3><?php echo htmlspecialchars($pc['nom']); ?></h3>
                        <p><?php echo htmlspecialchars($pc['description']); ?></p>
                        <?php if ($pc['composants']): ?>
                            <div class="components">
                                <strong>Composants:</strong>
                                <ul>
                                    <?php 
                                    $composants_list = explode(', ', $pc['composants']);
                                    foreach ($composants_list as $composant): 
                                    ?>
                                    <li><?php echo htmlspecialchars($composant); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="stock">Parc: <?php echo $pc['stock']; ?> unités</div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="pc-card">
                        <h3>Aucun PC disponible</h3>
                        <p>Revenez bientôt pour découvrir nos nouveaux modèles !</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2024 TechSolutions. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>