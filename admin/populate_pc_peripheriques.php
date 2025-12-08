<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$results = [];

try {
    // Récupérer tous les PC et périphériques
    $pcs = $pdo->query("SELECT * FROM pcs")->fetchAll(PDO::FETCH_ASSOC);
    $peripheriques = $pdo->query("SELECT * FROM peripheriques")->fetchAll(PDO::FETCH_ASSOC);
    
    // Créer un index des périphériques par nom
    $periph_index = [];
    foreach ($peripheriques as $p) {
        $periph_index[$p['nom']] = $p['id'];
    }
    
    // Configuration des périphériques par PC selon TechSolutions
    $pc_peripheriques_config = [
        'PC Développement' => [
            'Dell UltraSharp U2723DE 27"',
            'Logitech MX Keys',
            'Logitech MX Master 3S',
            'Logitech Zone Vibe 100'
        ],
        'PC Infrastructure' => [
            'Dell P2423DE 24"',
            'Logitech K270',
            'Logitech M185',
            'Logitech H390'
        ],
        'PC Design UX/UI' => [
            'BenQ SW272U 27"',
            'Logitech MX Keys',
            'Logitech MX Master 3S',
            'Wacom Intuos Pro M',
            'X-Rite i1Display Pro',
            'Logitech Brio 4K',
            'Logitech Zone Vibe 100'
        ],
        'PC Marketing' => [
            'Dell UltraSharp U2723DE 27"',
            'Logitech MX Keys',
            'Logitech MX Master 3S',
            'Logitech C920 HD Pro',
            'Logitech Zone Vibe 100'
        ],
        'PC Support Client' => [
            'Dell P2423DE 24"',
            'Logitech K270',
            'Logitech M185',
            'Logitech H390'
        ],
        'PC Support Handicap' => [
            'Dell P2423DE 24"',
            'Logitech K270',
            'Logitech M185',
            'Logitech H390'
        ],
        'PC RH Administration' => [
            'Dell P2423DE 24"',
            'Logitech K270',
            'Logitech M185',
            'Epson WorkForce DS-530',
            'Logitech H390'
        ],
        'PC Direction' => [
            'Dell UltraSharp U2723DE 27"',
            'Logitech MX Keys',
            'Logitech MX Master 3S',
            'Logitech Brio 4K',
            'Logitech Zone Vibe 100'
        ]
    ];
    
    // Supprimer les anciennes associations
    $pdo->exec("DELETE FROM pc_peripheriques");
    $results[] = "Anciennes associations supprimées";
    
    // Associer les périphériques aux PC
    $stmt = $pdo->prepare("INSERT INTO pc_peripheriques (pc_id, peripherique_id) VALUES (?, ?)");
    
    foreach ($pcs as $pc) {
        $pc_nom = $pc['nom'];
        if (isset($pc_peripheriques_config[$pc_nom])) {
            $count = 0;
            foreach ($pc_peripheriques_config[$pc_nom] as $periph_nom) {
                if (isset($periph_index[$periph_nom])) {
                    $stmt->execute([$pc['id'], $periph_index[$periph_nom]]);
                    $count++;
                }
            }
            $results[] = "$pc_nom: $count périphériques associés";
        }
    }
    
    $results[] = "<strong>✓ Association terminée avec succès!</strong>";
    
} catch(Exception $e) {
    $results[] = "Erreur: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Association PC-Périphériques - TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Association PC-Périphériques</h1>
            <div>
                <a href="dashboard.php" class="admin-btn">← Dashboard</a>
            </div>
        </div>
    </header>

    <div class="admin-container">
        <div class="form-section">
            <h2>Résultats</h2>
            <?php foreach ($results as $result): ?>
                <p><?php echo $result; ?></p>
            <?php endforeach; ?>
            <a href="pc.php" class="admin-btn" style="margin-top: 1rem;">Voir le parc</a>
        </div>
    </div>
</body>
</html>
