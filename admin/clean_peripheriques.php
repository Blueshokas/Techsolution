<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_POST && $_POST['action'] === 'clean_peripheriques') {
    try {
        $peripherique_types = ['Écran', 'Clavier', 'Souris', 'Casque Audio', 'Webcam', 'Tablette Graphique', 'Colorimètre', 'Scanner', 'Tapis de souris'];
        
        $deleted = 0;
        foreach ($peripherique_types as $type) {
            $stmt = $pdo->prepare("DELETE FROM pc_components WHERE component_id IN (SELECT id FROM components WHERE type = ?)");
            $stmt->execute([$type]);
            
            $stmt = $pdo->prepare("DELETE FROM components WHERE type = ?");
            $stmt->execute([$type]);
            $deleted += $stmt->rowCount();
        }
        
        $message = "$deleted périphériques supprimés des composants !";
        
    } catch(Exception $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}

// Compter les périphériques restants
$peripherique_types = ['Écran', 'Clavier', 'Souris', 'Casque Audio', 'Webcam', 'Tablette Graphique', 'Colorimètre', 'Scanner', 'Tapis de souris'];
$count = 0;
try {
    foreach ($peripherique_types as $type) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM components WHERE type = ?");
        $stmt->execute([$type]);
        $count += $stmt->fetchColumn();
    }
} catch(Exception $e) {
    $count = 0;
}
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Nettoyage Périphériques</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Nettoyage Périphériques</h1>
            <div>
                <a href="dashboard.php" class="admin-btn">← Dashboard</a>
            </div>
        </div>
    </header>

    <div class="admin-container">
        <?php if ($message): ?>
            <div class="admin-message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="form-section">
            <h2>Supprimer les périphériques des composants</h2>
            
            <div style="background: #fff3cd; padding: 1rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #ffc107;">
                <strong>Périphériques trouvés dans les composants :</strong> <?php echo $count; ?>
            </div>
            
            <?php if ($count > 0): ?>
                <p>Cette action va supprimer définitivement tous les périphériques de la table components :</p>
                <ul>
                    <li>Écrans, Claviers, Souris</li>
                    <li>Casques Audio, Webcams</li>
                    <li>Tablettes Graphiques, Colorimètres</li>
                    <li>Scanners, Tapis de souris</li>
                </ul>
                
                <form method="post">
                    <input type="hidden" name="action" value="clean_peripheriques">
                    <button type="submit" class="admin-btn btn-danger" onclick="return confirm('Supprimer tous les périphériques des composants ?')">
                        Nettoyer les périphériques
                    </button>
                </form>
            <?php else: ?>
                <div style="background: #d4edda; padding: 1rem; border-radius: 8px; border-left: 4px solid #28a745;">
                    ✅ <strong>Aucun périphérique trouvé</strong><br>
                    Les composants ne contiennent plus de périphériques.
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>