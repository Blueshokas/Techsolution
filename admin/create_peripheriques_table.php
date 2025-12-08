<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_POST && $_POST['action'] === 'create_tables') {
    try {
        // Créer table périphériques
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS peripheriques (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(255) NOT NULL,
                type VARCHAR(100) NOT NULL,
                marque VARCHAR(100),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // Créer table pc_peripheriques
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS pc_peripheriques (
                id INT AUTO_INCREMENT PRIMARY KEY,
                pc_id INT NOT NULL,
                peripherique_id INT NOT NULL,
                FOREIGN KEY (pc_id) REFERENCES pcs(id) ON DELETE CASCADE,
                FOREIGN KEY (peripherique_id) REFERENCES peripheriques(id) ON DELETE CASCADE,
                UNIQUE KEY unique_pc_peripherique (pc_id, peripherique_id)
            )
        ");
        
        // Migrer les périphériques depuis components
        $peripherique_types = ['Écran', 'Clavier', 'Souris', 'Casque Audio', 'Webcam', 'Tablette Graphique', 'Colorimètre', 'Scanner', 'Tapis de souris'];
        
        $migrated = 0;
        foreach ($peripherique_types as $type) {
            $stmt = $pdo->prepare("SELECT * FROM components WHERE type = ?");
            $stmt->execute([$type]);
            $components = $stmt->fetchAll();
            
            foreach ($components as $component) {
                // Insérer dans périphériques
                try {
                    $marque = isset($component['marque']) ? $component['marque'] : null;
                    $stmt = $pdo->prepare("INSERT INTO peripheriques (nom, type, marque) VALUES (?, ?, ?)");
                    $stmt->execute([$component['nom'], $component['type'], $marque]);
                } catch(Exception $e) {
                    // Si colonne marque n'existe pas
                    $stmt = $pdo->prepare("INSERT INTO peripheriques (nom, type) VALUES (?, ?)");
                    $stmt->execute([$component['nom'], $component['type']]);
                }
                $peripherique_id = $pdo->lastInsertId();
                
                // Migrer les associations PC
                $stmt = $pdo->prepare("SELECT pc_id FROM pc_components WHERE component_id = ?");
                $stmt->execute([$component['id']]);
                $pc_associations = $stmt->fetchAll();
                
                foreach ($pc_associations as $assoc) {
                    $stmt = $pdo->prepare("INSERT IGNORE INTO pc_peripheriques (pc_id, peripherique_id) VALUES (?, ?)");
                    $stmt->execute([$assoc['pc_id'], $peripherique_id]);
                }
                
                $migrated++;
            }
        }
        
        // Supprimer les périphériques de components
        $types_str = "'" . implode("','", $peripherique_types) . "'";
        $pdo->exec("DELETE FROM pc_components WHERE component_id IN (SELECT id FROM components WHERE type IN ($types_str))");
        $pdo->exec("DELETE FROM components WHERE type IN ($types_str)");
        
        $message = "Tables créées et $migrated périphériques migrés avec succès !";
        
    } catch(Exception $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}

// Vérifier si les tables existent
$tables_exist = false;
try {
    $pdo->query("SELECT 1 FROM peripheriques LIMIT 1");
    $pdo->query("SELECT 1 FROM pc_peripheriques LIMIT 1");
    $tables_exist = true;
} catch(Exception $e) {
    $tables_exist = false;
}
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Création Tables Périphériques</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Séparation Périphériques</h1>
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
            <h2>Création du système périphériques séparé</h2>
            
            <?php if (!$tables_exist): ?>
                <p>Cette action va :</p>
                <ul>
                    <li>Créer la table <code>peripheriques</code></li>
                    <li>Créer la table <code>pc_peripheriques</code></li>
                    <li>Migrer les périphériques depuis <code>components</code></li>
                    <li>Supprimer les périphériques de <code>components</code></li>
                </ul>
                
                <form method="post">
                    <input type="hidden" name="action" value="create_tables">
                    <button type="submit" class="admin-btn" onclick="return confirm('Créer le système périphériques séparé ?')">
                        Créer et migrer
                    </button>
                </form>
            <?php else: ?>
                <div style="background: #d4edda; padding: 1rem; border-radius: 8px; border-left: 4px solid #28a745;">
                    ✅ <strong>Système périphériques déjà créé</strong><br>
                    Les tables <code>peripheriques</code> et <code>pc_peripheriques</code> existent.
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>