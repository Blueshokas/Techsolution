<?php
require_once '../config.php';

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: index.php');
    exit;
}

try {
    // Récupérer les PC
    $stmt = $pdo->query("SELECT * FROM pcs ORDER BY prix ASC");
    $pcs = $stmt->fetchAll();
    
    // Récupérer les périphériques par département
    $stmt = $pdo->query("SELECT * FROM peripheriques ORDER BY departement, type");
    $peripheriques = $stmt->fetchAll();
    
    // Grouper par département
    $periph_by_dept = [];
    foreach ($peripheriques as $periph) {
        $periph_by_dept[$periph['departement']][] = $periph;
    }
} catch(Exception $e) {
    $pcs = [];
    $periph_by_dept = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parc Informatique - TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">

</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h2>Parc Informatique</h2>
            <div>
                <a href="dashboard.php" class="admin-btn">Retour Dashboard</a>
                <a href="logout.php" class="admin-btn">Déconnexion</a>
            </div>
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
                        <div class="components">
                            <strong>Composants:</strong>
                            <ul>
                                <?php 
                                // Utiliser la description pour afficher les composants
                                $composants_list = explode(' | ', $pc['description']);
                                foreach ($composants_list as $composant): 
                                    if (trim($composant)):
                                ?>
                                <li><?php echo htmlspecialchars($composant); ?></li>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </ul>
                        </div>
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

    <section class="section section-gray">
        <div class="container">
            <h2>Périphériques par Département</h2>
            <div class="peripheriques-grid">
                <?php if ($periph_by_dept): ?>
                    <?php foreach ($periph_by_dept as $dept => $periphs): ?>
                    <div class="dept-card">
                        <h3><?php echo htmlspecialchars($dept); ?> (<?php echo $periphs[0]['quantite']; ?> postes)</h3>
                        <div class="peripherique-list">
                            <?php foreach ($periphs as $periph): ?>
                            <div class="peripherique-item">
                                <strong><?php echo htmlspecialchars($periph['type']); ?>:</strong> 
                                <?php echo htmlspecialchars($periph['nom']); ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun périphérique trouvé. <a href="http://localhost/TechSolutionVF/admin/create_peripheriques.php">Créer la table</a></p>
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