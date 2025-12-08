<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

// Composants du document TechSolutions
$techsolutions_components = [
    // DÉVELOPPEMENT
    ['nom' => 'Aerocool CS-106 (Noir)', 'type' => 'Boîtier', 'marque' => 'Aerocool'],
    ['nom' => 'be quiet! Pure Wings 3 120mm PWM', 'type' => 'Ventilateur', 'marque' => 'be quiet!'],
    ['nom' => 'Gigabyte H610M S2H V3 DDR4', 'type' => 'Carte Mère', 'marque' => 'Gigabyte'],
    ['nom' => 'Intel Core i7-13700F (2.1 GHz / 5.2 GHz)', 'type' => 'CPU', 'marque' => 'Intel'],
    ['nom' => 'MSI GeForce RTX 3050 LP 6G OC', 'type' => 'GPU', 'marque' => 'MSI'],
    ['nom' => 'Noctua NH-U12A Chromax Black', 'type' => 'Refroidissement', 'marque' => 'Noctua'],
    ['nom' => 'G.Skill Aegis 32 Go (2×16 Go) DDR4 3200 MHz CL16', 'type' => 'RAM', 'marque' => 'G.Skill'],
    ['nom' => 'Samsung SSD 980 NVMe M.2 1 To', 'type' => 'SSD', 'marque' => 'Samsung'],
    ['nom' => 'Corsair RM850e (2025) – 850W', 'type' => 'Alimentation', 'marque' => 'Corsair'],
    ['nom' => 'Logitech K120 for Business', 'type' => 'Clavier', 'marque' => 'Logitech'],
    ['nom' => 'Altyk Tapis de souris Taille M', 'type' => 'Tapis de souris', 'marque' => 'Altyk'],
    ['nom' => 'INOVU EG200V', 'type' => 'Souris', 'marque' => 'INOVU'],
    ['nom' => 'iiyama 27" LED – G-Master GB2745QSU-B2 Black Hawk', 'type' => 'Écran', 'marque' => 'iiyama'],

    // INFRASTRUCTURE SYSTÈMES ET RÉSEAUX
    ['nom' => 'Intel Core i7-13700K', 'type' => 'CPU', 'marque' => 'Intel'],
    ['nom' => 'MSI PRO Z790-P WIFI', 'type' => 'Carte Mère', 'marque' => 'MSI'],
    ['nom' => 'Kingston FURY Beast DDR5 64 Go (2×32 Go) 5600 MHz', 'type' => 'RAM', 'marque' => 'Kingston'],
    ['nom' => 'Samsung 990 PRO NVMe M.2 – 2 To', 'type' => 'SSD', 'marque' => 'Samsung'],
    ['nom' => 'Western Digital Red Plus – 4 To', 'type' => 'HDD', 'marque' => 'Western Digital'],
    ['nom' => 'NVIDIA Quadro P620 – 2 Go', 'type' => 'GPU', 'marque' => 'NVIDIA'],
    ['nom' => 'Corsair 4000D Airflow', 'type' => 'Boîtier', 'marque' => 'Corsair'],
    ['nom' => 'Seasonic FOCUS GX-850 – 850W 80+ Gold', 'type' => 'Alimentation', 'marque' => 'Seasonic'],
    ['nom' => 'Noctua NH-D15', 'type' => 'Refroidissement', 'marque' => 'Noctua'],
    ['nom' => 'LG 27UP850-W – 27" 4K', 'type' => 'Écran', 'marque' => 'LG'],
    ['nom' => 'Logitech K280e Pro', 'type' => 'Clavier', 'marque' => 'Logitech'],
    ['nom' => 'Logitech MX Master 3S', 'type' => 'Souris', 'marque' => 'Logitech'],
    ['nom' => 'SteelSeries QcK Heavy XXL', 'type' => 'Tapis de souris', 'marque' => 'SteelSeries'],

    // DESIGN UX/UI
    ['nom' => 'AMD Ryzen 9 7900X (4.7 GHz / 5.4 GHz)', 'type' => 'CPU', 'marque' => 'AMD'],
    ['nom' => 'ASUS ROG STRIX B650E-F GAMING WIFI', 'type' => 'Carte Mère', 'marque' => 'ASUS'],
    ['nom' => 'G.Skill Trident Z5 RGB DDR5 64 Go (2x32 Go) 6000 MHz', 'type' => 'RAM', 'marque' => 'G.Skill'],
    ['nom' => 'Samsung 990 PRO 2 To M.2 NVMe PCIe 4.0', 'type' => 'SSD', 'marque' => 'Samsung'],
    ['nom' => 'Samsung 870 EVO 4 To', 'type' => 'SSD', 'marque' => 'Samsung'],
    ['nom' => 'Gigabyte GeForce RTX 5070 EAGLE OC SFF 12G', 'type' => 'GPU', 'marque' => 'Gigabyte'],
    ['nom' => 'NZXT H7 Flow RGB Noir (2024)', 'type' => 'Boîtier', 'marque' => 'NZXT'],
    ['nom' => 'be quiet! Power Zone 2 1000W 80PLUS Platinum', 'type' => 'Alimentation', 'marque' => 'be quiet!'],
    ['nom' => 'NZXT Kraken X63 280mm AIO RGB', 'type' => 'Refroidissement', 'marque' => 'NZXT'],
    ['nom' => 'BenQ SW272U 27" 4K IPS Professionnel', 'type' => 'Écran', 'marque' => 'BenQ'],
    ['nom' => 'Wacom Intuos Pro Large PTH-860', 'type' => 'Tablette Graphique', 'marque' => 'Wacom'],
    ['nom' => 'Calibrite Display Pro HL', 'type' => 'Colorimètre', 'marque' => 'Calibrite'],
    ['nom' => 'Razer Strider XXL Hybrid', 'type' => 'Tapis de souris', 'marque' => 'Razer'],

    // MARKETING ET VENTE
    ['nom' => 'Intel Core i5-12600K (3.7 GHz / 4.9 GHz)', 'type' => 'CPU', 'marque' => 'Intel'],
    ['nom' => 'MSI PRO B760M-P DDR4', 'type' => 'Carte Mère', 'marque' => 'MSI'],
    ['nom' => 'Corsair Vengeance LPX Series Low Profile 16 Go (2x 8 Go) DDR4 3200 MHz CL16', 'type' => 'RAM', 'marque' => 'Corsair'],
    ['nom' => 'Kingston SSD NV3 500 Go', 'type' => 'SSD', 'marque' => 'Kingston'],
    ['nom' => 'Seagate BarraCuda 1 To 7200 RPM 3.5"', 'type' => 'HDD', 'marque' => 'Seagate'],
    ['nom' => 'Cooler Master MasterBox Q300L', 'type' => 'Boîtier', 'marque' => 'Cooler Master'],
    ['nom' => 'Corsair CX550 80PLUS Bronze (2023)', 'type' => 'Alimentation', 'marque' => 'Corsair'],
    ['nom' => 'Cooler Master Hyper 212 Black Edition', 'type' => 'Refroidissement', 'marque' => 'Cooler Master'],
    ['nom' => 'ASUS VA24EHF 24" Full HD IPS', 'type' => 'Écran', 'marque' => 'ASUS'],
    ['nom' => 'Logitech K270 Wireless Keyboard', 'type' => 'Clavier', 'marque' => 'Logitech'],
    ['nom' => 'Logitech M330 Silent Plus Wireless', 'type' => 'Souris', 'marque' => 'Logitech'],
    ['nom' => 'Logitech USB Headset H390', 'type' => 'Casque Audio', 'marque' => 'Logitech'],
    ['nom' => 'Logitech C270 HD 720p', 'type' => 'Webcam', 'marque' => 'Logitech'],
    ['nom' => 'Fox Spirit S-Pad', 'type' => 'Tapis de souris', 'marque' => 'Fox Spirit'],

    // SUPPORT CLIENT
    ['nom' => 'AMD Ryzen 5 5600GT Wraith Stealth (3.6 GHz / 4.6 GHz)', 'type' => 'CPU', 'marque' => 'AMD'],
    ['nom' => 'Gigabyte B550M DS3H AC R2', 'type' => 'Carte Mère', 'marque' => 'Gigabyte'],
    ['nom' => 'Kingston FURY Beast DDR4 16 Go (2x8 Go) 3200 MHz', 'type' => 'RAM', 'marque' => 'Kingston'],
    ['nom' => 'Kingston NV2 500 Go M.2 NVMe PCIe 4.0', 'type' => 'SSD', 'marque' => 'Kingston'],
    ['nom' => 'Thermaltake View 270 TG ARGB (blanc)', 'type' => 'Boîtier', 'marque' => 'Thermaltake'],
    ['nom' => 'Corsair CV550 450W 80+ Bronze', 'type' => 'Alimentation', 'marque' => 'Corsair'],
    ['nom' => 'be quiet! Pure Rock Pro 3', 'type' => 'Refroidissement', 'marque' => 'be quiet!'],
    ['nom' => 'Dell P2422H 24" Full HD IPS', 'type' => 'Écran', 'marque' => 'Dell'],
    ['nom' => 'Logitech K120 USB Filaire', 'type' => 'Clavier', 'marque' => 'Logitech'],
    ['nom' => 'Logitech B100 USB Optique', 'type' => 'Souris', 'marque' => 'Logitech'],

    // SUPPORT CLIENT - HANDICAP VISUEL
    ['nom' => 'Intel Core i5-14600K (3.5 GHz / 5.3 GHz)', 'type' => 'CPU', 'marque' => 'Intel'],
    ['nom' => 'ASUS PRIME Z790-P WIFI', 'type' => 'Carte Mère', 'marque' => 'ASUS'],
    ['nom' => 'Corsair Vengeance DDR5 32 Go (2 x 16 Go) 4800 MHz CL40', 'type' => 'RAM', 'marque' => 'Corsair'],
    ['nom' => 'Samsung 980 PRO 1 To M.2 NVMe PCIe 4.0', 'type' => 'SSD', 'marque' => 'Samsung'],
    ['nom' => 'Fractal Design Define 7 Compact', 'type' => 'Boîtier', 'marque' => 'Fractal Design'],
    ['nom' => 'Seasonic FOCUS GX-750 650W 80+ Gold Modulaire', 'type' => 'Alimentation', 'marque' => 'Seasonic'],
    ['nom' => 'be quiet! Pure Rock 3', 'type' => 'Refroidissement', 'marque' => 'be quiet!'],
    ['nom' => 'Clavier rétroéclairé à gros caractères pour PC', 'type' => 'Clavier', 'marque' => 'Générique'],
    ['nom' => 'Contour RollerMouse Red Plus', 'type' => 'Souris', 'marque' => 'Contour'],

    // RESSOURCES HUMAINES ET ADMINISTRATION
    ['nom' => 'ASUS PRIME B760M-A WIFI D4', 'type' => 'Carte Mère', 'marque' => 'ASUS'],
    ['nom' => 'Textorm 16 Go (2x 8 Go) DDR4 3200 MHz', 'type' => 'RAM', 'marque' => 'Textorm'],
    ['nom' => 'Samsung SSD 870 EVO 500 Go', 'type' => 'SSD', 'marque' => 'Samsung'],
    ['nom' => 'Western Digital WD Red Pro 2 To', 'type' => 'HDD', 'marque' => 'Western Digital'],
    ['nom' => 'Antec P10C', 'type' => 'Boîtier', 'marque' => 'Antec'],
    ['nom' => 'Corsair CX550 80+ Bronze', 'type' => 'Alimentation', 'marque' => 'Corsair'],
    ['nom' => 'iiyama 23.8" LED - ProLite XUB2491H-B1', 'type' => 'Écran', 'marque' => 'iiyama'],
    ['nom' => 'Logitech H390 USB', 'type' => 'Casque Audio', 'marque' => 'Logitech'],
    ['nom' => 'Epson WorkForce ES-50', 'type' => 'Scanner', 'marque' => 'Epson'],

    // DIRECTION
    ['nom' => 'Intel Core i9-13900KS (3.2 GHz / 6 GHz)', 'type' => 'CPU', 'marque' => 'Intel'],
    ['nom' => 'ASUS TUF GAMING Z790-PLUS WIFI', 'type' => 'Carte Mère', 'marque' => 'ASUS'],
    ['nom' => 'Corsair Dominator Titanium DDR5 RGB 64 Go (2 x 32 Go) 6000 MHz', 'type' => 'RAM', 'marque' => 'Corsair'],
    ['nom' => 'Samsung SSD 990 PRO M.2 PCIe NVMe 2 To', 'type' => 'SSD', 'marque' => 'Samsung'],
    ['nom' => 'Gainward GeForce RTX 4060 Ti Pegasus 8GB', 'type' => 'GPU', 'marque' => 'Gainward'],
    ['nom' => 'Lian Li O11 Dynamic EVO XL', 'type' => 'Boîtier', 'marque' => 'Lian Li'],
    ['nom' => 'Corsair HX1000i 80PLUS Platinum ATX 3.1', 'type' => 'Alimentation', 'marque' => 'Corsair'],
    ['nom' => 'Corsair Nautilus 360 RS ARGB (Noir)', 'type' => 'Refroidissement', 'marque' => 'Corsair'],
    ['nom' => 'iiyama 31.5" LED - ProLite XUB3293UHSN-B5', 'type' => 'Écran', 'marque' => 'iiyama'],
    ['nom' => 'Logitech MX Keys S Combo', 'type' => 'Clavier', 'marque' => 'Logitech'],
    ['nom' => 'SteelSeries Arctis Nova Pro', 'type' => 'Casque Audio', 'marque' => 'SteelSeries'],
    ['nom' => 'Logitech BRIO 4K B2C', 'type' => 'Webcam', 'marque' => 'Logitech'],
    ['nom' => 'Razer Pro Glide XXL', 'type' => 'Tapis de souris', 'marque' => 'Razer'],
    ['nom' => 'HP ZBook Ultra G1a 14 pouces (A3ZU9ET)', 'type' => 'Ordinateur Portable', 'marque' => 'HP'],
    ['nom' => 'Targus CityGear 3 Sleeve 14" Noir', 'type' => 'Sacoche', 'marque' => 'Targus'],

    // PROTECTION ÉLECTRIQUE
    ['nom' => 'APC Back-UPS PRO BR 900VA', 'type' => 'Onduleur', 'marque' => 'APC'],
];

if ($_POST && $_POST['action'] === 'populate') {
    try {
        $pdo->beginTransaction();
        
        $inserted = 0;
        $duplicates = 0;
        
        foreach ($techsolutions_components as $component) {
            // Vérifier si le composant existe déjà
            $check = $pdo->prepare("SELECT COUNT(*) FROM components WHERE nom = ? AND type = ?");
            $check->execute([$component['nom'], $component['type']]);
            
            if ($check->fetchColumn() == 0) {
                $stmt = $pdo->prepare("INSERT INTO components (nom, type, marque) VALUES (?, ?, ?)");
                $stmt->execute([$component['nom'], $component['type'], $component['marque']]);
                $inserted++;
            } else {
                $duplicates++;
            }
        }
        
        $pdo->commit();
        $message = "Import terminé ! $inserted composants ajoutés, $duplicates doublons ignorés.";
        
    } catch(Exception $e) {
        $pdo->rollBack();
        $message = "Erreur lors de l'import : " . $e->getMessage();
    }
}

// Statistiques actuelles
$stats = $pdo->query("SELECT COUNT(*) as total FROM components")->fetch();
$types_stats = $pdo->query("SELECT type, COUNT(*) as count FROM components GROUP BY type ORDER BY count DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Peupler Composants TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Peupler la base avec les composants TechSolutions</h1>
            <div>
                <a href="components_admin.php" class="admin-btn">← Gestion Composants</a>
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
            <p><strong>Total des composants:</strong> <?php echo $stats['total']; ?></p>
            
            <?php if ($types_stats): ?>
                <h3>Répartition par type:</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <?php foreach ($types_stats as $type_stat): ?>
                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px;">
                            <strong><?php echo htmlspecialchars($type_stat['type']); ?></strong><br>
                            <span style="color: #007bff;"><?php echo $type_stat['count']; ?> composant(s)</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-section">
            <h2>Import des composants TechSolutions</h2>
            <p>Cette action va importer tous les composants listés dans le document TechSolutions.</p>
            <p><strong>Nombre de composants à importer:</strong> <?php echo count($techsolutions_components); ?></p>
            
            <div style="background: #fff3cd; padding: 1rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #ffc107;">
                <strong>Note:</strong> Les doublons seront automatiquement ignorés (basé sur nom + type).
            </div>
            
            <form method="post">
                <input type="hidden" name="action" value="populate">
                <button type="submit" class="admin-btn" onclick="return confirm('Importer tous les composants TechSolutions ?')">
                    Importer les composants
                </button>
            </form>
        </div>

        <div class="form-section">
            <h2>Aperçu des composants à importer</h2>
            <div style="max-height: 400px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 8px;">
                <?php 
                $current_type = '';
                foreach ($techsolutions_components as $component): 
                    if ($current_type !== $component['type']):
                        if ($current_type !== '') echo '</div>';
                        $current_type = $component['type'];
                        echo '<h4 style="background: #007bff; color: white; margin: 0; padding: 0.5rem 1rem;">' . htmlspecialchars($current_type) . '</h4>';
                        echo '<div style="padding: 0.5rem 1rem;">';
                    endif;
                ?>
                    <div style="padding: 0.25rem 0; border-bottom: 1px solid #eee;">
                        <strong><?php echo htmlspecialchars($component['nom']); ?></strong>
                        <?php if ($component['marque']): ?>
                            <span style="color: #666;"> - <?php echo htmlspecialchars($component['marque']); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>