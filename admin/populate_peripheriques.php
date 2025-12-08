<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

// Périphériques du document TechSolutions
$peripheriques_data = [
    ['nom' => 'iiyama 27" LED – G-Master GB2745QSU-B2 Black Hawk', 'type' => 'Écran', 'marque' => 'iiyama'],
    ['nom' => 'Logitech K120 for Business', 'type' => 'Clavier', 'marque' => 'Logitech'],
    ['nom' => 'INOVU EG200V', 'type' => 'Souris', 'marque' => 'INOVU'],
    ['nom' => 'Altyk Tapis de souris Taille M', 'type' => 'Tapis de souris', 'marque' => 'Altyk'],
    ['nom' => 'LG 27UP850-W – 27" 4K', 'type' => 'Écran', 'marque' => 'LG'],
    ['nom' => 'Logitech K280e Pro', 'type' => 'Clavier', 'marque' => 'Logitech'],
    ['nom' => 'Logitech MX Master 3S', 'type' => 'Souris', 'marque' => 'Logitech'],
    ['nom' => 'SteelSeries QcK Heavy XXL', 'type' => 'Tapis de souris', 'marque' => 'SteelSeries'],
    ['nom' => 'BenQ SW272U 27" 4K IPS Professionnel', 'type' => 'Écran', 'marque' => 'BenQ'],
    ['nom' => 'Wacom Intuos Pro Large PTH-860', 'type' => 'Tablette Graphique', 'marque' => 'Wacom'],
    ['nom' => 'Calibrite Display Pro HL', 'type' => 'Colorimètre', 'marque' => 'Calibrite'],
    ['nom' => 'Razer Strider XXL Hybrid', 'type' => 'Tapis de souris', 'marque' => 'Razer'],
    ['nom' => 'ASUS VA24EHF 24" Full HD IPS', 'type' => 'Écran', 'marque' => 'ASUS'],
    ['nom' => 'Logitech K270 Wireless Keyboard', 'type' => 'Clavier', 'marque' => 'Logitech'],
    ['nom' => 'Logitech M330 Silent Plus Wireless', 'type' => 'Souris', 'marque' => 'Logitech'],
    ['nom' => 'Logitech USB Headset H390', 'type' => 'Casque Audio', 'marque' => 'Logitech'],
    ['nom' => 'Logitech C270 HD 720p', 'type' => 'Webcam', 'marque' => 'Logitech'],
    ['nom' => 'Fox Spirit S-Pad', 'type' => 'Tapis de souris', 'marque' => 'Fox Spirit'],
    ['nom' => 'Dell P2422H 24" Full HD IPS', 'type' => 'Écran', 'marque' => 'Dell'],
    ['nom' => 'Logitech K120 USB Filaire', 'type' => 'Clavier', 'marque' => 'Logitech'],
    ['nom' => 'Logitech B100 USB Optique', 'type' => 'Souris', 'marque' => 'Logitech'],
    ['nom' => 'Clavier rétroéclairé à gros caractères pour PC', 'type' => 'Clavier', 'marque' => 'Générique'],
    ['nom' => 'Contour RollerMouse Red Plus', 'type' => 'Souris', 'marque' => 'Contour'],
    ['nom' => 'iiyama 23.8" LED - ProLite XUB2491H-B1', 'type' => 'Écran', 'marque' => 'iiyama'],
    ['nom' => 'Logitech H390 USB', 'type' => 'Casque Audio', 'marque' => 'Logitech'],
    ['nom' => 'Epson WorkForce ES-50', 'type' => 'Scanner', 'marque' => 'Epson'],
    ['nom' => 'iiyama 31.5" LED - ProLite XUB3293UHSN-B5', 'type' => 'Écran', 'marque' => 'iiyama'],
    ['nom' => 'Logitech MX Keys S Combo', 'type' => 'Clavier', 'marque' => 'Logitech'],
    ['nom' => 'SteelSeries Arctis Nova Pro', 'type' => 'Casque Audio', 'marque' => 'SteelSeries'],
    ['nom' => 'Logitech BRIO 4K B2C', 'type' => 'Webcam', 'marque' => 'Logitech'],
    ['nom' => 'Razer Pro Glide XXL', 'type' => 'Tapis de souris', 'marque' => 'Razer']
];

if ($_POST && $_POST['action'] === 'populate') {
    try {
        $pdo->beginTransaction();
        
        $inserted = 0;
        $duplicates = 0;
        
        foreach ($peripheriques_data as $periph) {
            $check = $pdo->prepare("SELECT COUNT(*) FROM peripheriques WHERE nom = ? AND type = ?");
            $check->execute([$periph['nom'], $periph['type']]);
            
            if ($check->fetchColumn() == 0) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO peripheriques (nom, type, marque) VALUES (?, ?, ?)");
                    $stmt->execute([$periph['nom'], $periph['type'], $periph['marque']]);
                    $inserted++;
                } catch(Exception $e) {
                    // Si colonne marque n'existe pas
                    $stmt = $pdo->prepare("INSERT INTO peripheriques (nom, type) VALUES (?, ?)");
                    $stmt->execute([$periph['nom'], $periph['type']]);
                    $inserted++;
                }
            } else {
                $duplicates++;
            }
        }
        
        $pdo->commit();
        $message = "Import terminé ! $inserted périphériques ajoutés, $duplicates doublons ignorés.";
        
    } catch(Exception $e) {
        $pdo->rollBack();
        $message = "Erreur : " . $e->getMessage();
    }
}

$stats = [];
try {
    $stats['total'] = $pdo->query("SELECT COUNT(*) FROM peripheriques")->fetchColumn();
    $stats_by_type = $pdo->query("SELECT type, COUNT(*) as count FROM peripheriques GROUP BY type ORDER BY count DESC")->fetchAll();
} catch(Exception $e) {
    $stats = ['total' => 0];
    $stats_by_type = [];
}
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Import Périphériques TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Import Périphériques TechSolutions</h1>
            <div>
                <a href="peripheriques_admin.php" class="admin-btn">← Gestion Périphériques</a>
                <a href="dashboard.php" class="admin-btn">Dashboard</a>
            </div>
        </div>
    </header>

    <div class="admin-container">
        <?php if ($message): ?>
            <div class="admin-message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="form-section">
            <h2>Statistiques actuelles</h2>
            <p><strong>Total des périphériques:</strong> <?php echo $stats['total']; ?></p>
            
            <?php if ($stats_by_type): ?>
                <h3>Répartition par type:</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <?php foreach ($stats_by_type as $type_stat): ?>
                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px;">
                            <strong><?php echo htmlspecialchars($type_stat['type']); ?></strong><br>
                            <span style="color: #007bff;"><?php echo $type_stat['count']; ?> périphérique(s)</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-section">
            <h2>Import des périphériques TechSolutions</h2>
            <p><strong>Nombre de périphériques à importer:</strong> <?php echo count($peripheriques_data); ?></p>
            
            <div style="background: #fff3cd; padding: 1rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #ffc107;">
                <strong>Note:</strong> Les doublons seront automatiquement ignorés.
            </div>
            
            <form method="post">
                <input type="hidden" name="action" value="populate">
                <button type="submit" class="admin-btn" onclick="return confirm('Importer tous les périphériques TechSolutions ?')">
                    Importer les périphériques
                </button>
            </form>
        </div>
    </div>
</body>
</html>