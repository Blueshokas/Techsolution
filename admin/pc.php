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
    

    
    // Récupérer les périphériques par PC
    $peripheriques_by_pc = [];
    try {
        foreach ($pcs as $pc) {
            $stmt = $pdo->prepare("
                SELECT p.nom, p.type 
                FROM peripheriques p 
                JOIN pc_peripheriques pp ON p.id = pp.peripherique_id 
                WHERE pp.pc_id = ?
                ORDER BY p.type, p.nom
            ");
            $stmt->execute([$pc['id']]);
            $peripheriques_by_pc[$pc['nom']] = $stmt->fetchAll();
        }
    } catch(Exception $e) {
        // Si les tables n'existent pas encore
        $peripheriques_by_pc = [];
    }
    
} catch(Exception $e) {
    $pcs = [];
    $peripheriques_by_pc = [];
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
                                try {
                                    $stmt = $pdo->prepare("
                                        SELECT c.nom, c.type 
                                        FROM components c 
                                        JOIN pc_components pc ON c.id = pc.component_id 
                                        WHERE pc.pc_id = ?
                                        ORDER BY c.type, c.nom
                                    ");
                                    $stmt->execute([$pc['id']]);
                                    $composants = $stmt->fetchAll();
                                    
                                    if ($composants):
                                        foreach ($composants as $composant):
                                ?>
                                <li><?php echo htmlspecialchars($composant['type'] . ': ' . $composant['nom']); ?></li>
                                <?php 
                                        endforeach;
                                    else:
                                ?>
                                <li>Aucun composant assigné</li>
                                <?php 
                                    endif;
                                } catch(Exception $e) {
                                ?>
                                <li>Erreur de chargement</li>
                                <?php } ?>
                            </ul>
                            
                            <strong>Périphériques:</strong>
                            <ul>
                                <?php 
                                try {
                                    $stmt = $pdo->prepare("
                                        SELECT p.nom, p.type 
                                        FROM peripheriques p 
                                        JOIN pc_peripheriques pp ON p.id = pp.peripherique_id 
                                        WHERE pp.pc_id = ?
                                        ORDER BY p.type, p.nom
                                    ");
                                    $stmt->execute([$pc['id']]);
                                    $periphs = $stmt->fetchAll();
                                    
                                    if ($periphs):
                                        foreach ($periphs as $periph):
                                            $display = !empty($periph['type']) ? $periph['type'] . ': ' . $periph['nom'] : $periph['nom'];
                                ?>
                                <li><?php echo htmlspecialchars($display); ?></li>
                                <?php 
                                        endforeach;
                                    else:
                                ?>
                                <li>Aucun périphérique assigné</li>
                                <?php 
                                    endif;
                                } catch(Exception $e) {
                                ?>
                                <li>Erreur de chargement</li>
                                <?php } ?>
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



    <footer>
        <div class="container">
            <p>&copy; 2024 TechSolutions. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>