<?php
require_once '../config.php';

// 1. Créer les nouvelles tables
try {
    // Table des composants
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS components (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(255) NOT NULL,
            type ENUM('CPU', 'RAM', 'SSD', 'HDD', 'GPU', 'Carte Mère', 'Boîtier', 'Alimentation', 'Refroidissement', 'Ventilation', 'Écran', 'Clavier', 'Souris', 'Casque', 'Webcam', 'Tablette', 'Station', 'Scanner', 'Autre') NOT NULL,
            marque VARCHAR(100),
            modele VARCHAR(255),
            specifications TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Table de liaison PC-Composants
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS pc_components (
            id INT AUTO_INCREMENT PRIMARY KEY,
            pc_id INT NOT NULL,
            component_id INT NOT NULL,
            quantite INT DEFAULT 1,
            FOREIGN KEY (pc_id) REFERENCES pcs(id) ON DELETE CASCADE,
            FOREIGN KEY (component_id) REFERENCES components(id) ON DELETE CASCADE,
            UNIQUE KEY unique_pc_component (pc_id, component_id)
        )
    ");

    // Ajouter colonne actif à la table pcs si elle n'existe pas
    $pdo->exec("ALTER TABLE pcs ADD COLUMN IF NOT EXISTS actif TINYINT(1) DEFAULT 1");

    echo "✅ Tables créées avec succès !<br><br>";

    // 2. Récupérer les PC existants
    $pcs = $pdo->query("SELECT * FROM pcs")->fetchAll();

    foreach ($pcs as $pc) {
        echo "<strong>Migration PC: " . htmlspecialchars($pc['nom']) . "</strong><br>";
        
        // Parser la description pour extraire les composants
        $composants_text = explode(' | ', $pc['description']);
        
        foreach ($composants_text as $composant_line) {
            if (trim($composant_line)) {
                // Extraire type et nom du composant
                if (preg_match('/^([^:]+):\s*(.+)$/', trim($composant_line), $matches)) {
                    $type = trim($matches[1]);
                    $nom_complet = trim($matches[2]);
                    
                    // Mapper les types
                    $type_mapping = [
                        'CPU' => 'CPU',
                        'Carte Mère' => 'Carte Mère',
                        'RAM' => 'RAM',
                        'SSD' => 'SSD',
                        'HDD' => 'HDD',
                        'GPU' => 'GPU',
                        'Boîtier' => 'Boîtier',
                        'Refroidissement' => 'Refroidissement',
                        'Ventilation' => 'Ventilation',
                        'Alimentation' => 'Alimentation',
                        'Écran' => 'Écran',
                        'Écrans' => 'Écran',
                        'Clavier' => 'Clavier',
                        'Souris' => 'Souris',
                        'Casque' => 'Casque',
                        'Webcam' => 'Webcam',
                        'Tablette' => 'Tablette',
                        'Station' => 'Station',
                        'Scanner' => 'Scanner'
                    ];
                    
                    $type_final = $type_mapping[$type] ?? 'Autre';
                    
                    // Vérifier si le composant existe déjà
                    $stmt = $pdo->prepare("SELECT id FROM components WHERE nom = ? AND type = ?");
                    $stmt->execute([$nom_complet, $type_final]);
                    $existing_component = $stmt->fetch();
                    
                    if ($existing_component) {
                        $component_id = $existing_component['id'];
                        echo "&nbsp;&nbsp;- Composant existant: $type_final - $nom_complet<br>";
                    } else {
                        // Créer le nouveau composant
                        $stmt = $pdo->prepare("INSERT INTO components (nom, type) VALUES (?, ?)");
                        $stmt->execute([$nom_complet, $type_final]);
                        $component_id = $pdo->lastInsertId();
                        echo "&nbsp;&nbsp;+ Nouveau composant: $type_final - $nom_complet<br>";
                    }
                    
                    // Lier le composant au PC
                    try {
                        $stmt = $pdo->prepare("INSERT IGNORE INTO pc_components (pc_id, component_id) VALUES (?, ?)");
                        $stmt->execute([$pc['id'], $component_id]);
                    } catch (Exception $e) {
                        // Ignorer les doublons
                    }
                }
            }
        }
        echo "<br>";
    }

    echo "<h3>✅ Migration terminée !</h3>";
    echo "<p><a href='pc.php'>Voir le parc informatique</a> | <a href='dashboard.php'>Retour dashboard</a></p>";

} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage();
}
?>