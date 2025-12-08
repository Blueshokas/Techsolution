<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

// Configurations PC par service selon le document TechSolutions
$pc_configs = [
    'Développement' => [
        'Aerocool CS-106 (Noir)',
        'be quiet! Pure Wings 3 120mm PWM',
        'Gigabyte H610M S2H V3 DDR4',
        'Intel Core i7-13700F (2.1 GHz / 5.2 GHz)',
        'MSI GeForce RTX 3050 LP 6G OC',
        'Noctua NH-U12A Chromax Black',
        'G.Skill Aegis 32 Go (2×16 Go) DDR4 3200 MHz CL16',
        'Samsung SSD 980 NVMe M.2 1 To',
        'Corsair RM850e (2025) – 850W',
        'Logitech K120 for Business',
        'Altyk Tapis de souris Taille M',
        'INOVU EG200V',
        'iiyama 27" LED – G-Master GB2745QSU-B2 Black Hawk'
    ],
    'Infrastructure' => [
        'Intel Core i7-13700K',
        'MSI PRO Z790-P WIFI',
        'Kingston FURY Beast DDR5 64 Go (2×32 Go) 5600 MHz',
        'Samsung 990 PRO NVMe M.2 – 2 To',
        'Western Digital Red Plus – 4 To',
        'NVIDIA Quadro P620 – 2 Go',
        'Corsair 4000D Airflow',
        'Seasonic FOCUS GX-850 – 850W 80+ Gold',
        'Noctua NH-D15',
        'LG 27UP850-W – 27" 4K',
        'Logitech K280e Pro',
        'Logitech MX Master 3S',
        'SteelSeries QcK Heavy XXL'
    ],
    'Design' => [
        'AMD Ryzen 9 7900X (4.7 GHz / 5.4 GHz)',
        'ASUS ROG STRIX B650E-F GAMING WIFI',
        'G.Skill Trident Z5 RGB DDR5 64 Go (2x32 Go) 6000 MHz',
        'Samsung 990 PRO 2 To M.2 NVMe PCIe 4.0',
        'Samsung 870 EVO 4 To',
        'Gigabyte GeForce RTX 5070 EAGLE OC SFF 12G',
        'NZXT H7 Flow RGB Noir (2024)',
        'be quiet! Power Zone 2 1000W 80PLUS Platinum',
        'NZXT Kraken X63 280mm AIO RGB',
        'BenQ SW272U 27" 4K IPS Professionnel',
        'Wacom Intuos Pro Large PTH-860',
        'Logitech K120 for Business',
        'Logitech MX Master 3S',
        'Calibrite Display Pro HL',
        'Razer Strider XXL Hybrid'
    ],
    'Marketing' => [
        'Intel Core i5-12600K (3.7 GHz / 4.9 GHz)',
        'MSI PRO B760M-P DDR4',
        'Corsair Vengeance LPX Series Low Profile 16 Go (2x 8 Go) DDR4 3200 MHz CL16',
        'Kingston SSD NV3 500 Go',
        'Seagate BarraCuda 1 To 7200 RPM 3.5"',
        'Cooler Master MasterBox Q300L',
        'Corsair CX550 80PLUS Bronze (2023)',
        'Cooler Master Hyper 212 Black Edition',
        'ASUS VA24EHF 24" Full HD IPS',
        'Logitech K270 Wireless Keyboard',
        'Logitech M330 Silent Plus Wireless',
        'Logitech USB Headset H390',
        'Logitech C270 HD 720p',
        'Fox Spirit S-Pad'
    ],
    'Support' => [
        'AMD Ryzen 5 5600GT Wraith Stealth (3.6 GHz / 4.6 GHz)',
        'Gigabyte B550M DS3H AC R2',
        'Kingston FURY Beast DDR4 16 Go (2x8 Go) 3200 MHz',
        'Kingston NV2 500 Go M.2 NVMe PCIe 4.0',
        'Thermaltake View 270 TG ARGB (blanc)',
        'Corsair CV550 450W 80+ Bronze',
        'be quiet! Pure Rock Pro 3',
        'Dell P2422H 24" Full HD IPS',
        'Logitech K120 USB Filaire',
        'Logitech B100 USB Optique',
        'Logitech USB Headset H390',
        'Logitech C270 HD 720p'
    ],
    'RH' => [
        'Intel Core i5-12600K (3.7 GHz / 4.9 GHz)',
        'ASUS PRIME B760M-A WIFI D4',
        'Textorm 16 Go (2x 8 Go) DDR4 3200 MHz',
        'Samsung SSD 870 EVO 500 Go',
        'Western Digital WD Red Pro 2 To',
        'Antec P10C',
        'Corsair CX550 80+ Bronze',
        'Cooler Master Hyper 212 Black Edition',
        'iiyama 23.8" LED - ProLite XUB2491H-B1',
        'Logitech K120 for Business',
        'INOVU EG200V',
        'Logitech H390 USB',
        'Logitech C270 HD 720p',
        'Epson WorkForce ES-50',
        'Fox Spirit S-Pad'
    ],
    'Direction' => [
        'Intel Core i9-13900KS (3.2 GHz / 6 GHz)',
        'ASUS TUF GAMING Z790-PLUS WIFI',
        'Corsair Dominator Titanium DDR5 RGB 64 Go (2 x 32 Go) 6000 MHz',
        'Samsung SSD 990 PRO M.2 PCIe NVMe 2 To',
        'Samsung 870 EVO 4 To',
        'Gainward GeForce RTX 4060 Ti Pegasus 8GB',
        'Lian Li O11 Dynamic EVO XL',
        'Corsair HX1000i 80PLUS Platinum ATX 3.1',
        'Corsair Nautilus 360 RS ARGB (Noir)',
        'iiyama 31.5" LED - ProLite XUB3293UHSN-B5',
        'Logitech MX Keys S Combo',
        'SteelSeries Arctis Nova Pro',
        'Logitech BRIO 4K B2C',
        'Razer Pro Glide XXL'
    ]
];

if ($_POST && $_POST['action'] === 'populate_configs') {
    try {
        $pdo->beginTransaction();
        
        $assigned = 0;
        $errors = 0;
        
        foreach ($pc_configs as $service => $component_names) {
            // Trouver les PC de ce service
            $stmt = $pdo->prepare("SELECT id FROM pcs WHERE nom LIKE ?");
            $stmt->execute(["%$service%"]);
            $pcs = $stmt->fetchAll();
            
            foreach ($pcs as $pc) {
                // Supprimer l'ancienne configuration
                $pdo->prepare("DELETE FROM pc_components WHERE pc_id = ?")->execute([$pc['id']]);
                
                // Ajouter les nouveaux composants
                foreach ($component_names as $component_name) {
                    $stmt = $pdo->prepare("SELECT id FROM components WHERE nom = ?");
                    $stmt->execute([$component_name]);
                    $component = $stmt->fetch();
                    
                    if ($component) {
                        $stmt = $pdo->prepare("INSERT INTO pc_components (pc_id, component_id) VALUES (?, ?)");
                        $stmt->execute([$pc['id'], $component['id']]);
                        $assigned++;
                    } else {
                        $errors++;
                    }
                }
            }
        }
        
        $pdo->commit();
        $message = "Configuration terminée ! $assigned composants assignés, $errors composants non trouvés.";
        
    } catch(Exception $e) {
        $pdo->rollBack();
        $message = "Erreur : " . $e->getMessage();
    }
}

// Statistiques
$stats = [];
try {
    $stats['pcs'] = $pdo->query("SELECT COUNT(*) FROM pcs")->fetchColumn();
    $stats['components'] = $pdo->query("SELECT COUNT(*) FROM components")->fetchColumn();
    $stats['assignments'] = $pdo->query("SELECT COUNT(*) FROM pc_components")->fetchColumn();
} catch(Exception $e) {
    $stats = ['pcs' => 0, 'components' => 0, 'assignments' => 0];
}
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Configuration PC TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Configuration automatique des PC</h1>
            <div>
                <a href="pc_components_admin.php" class="admin-btn">← Gestion PC-Composants</a>
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
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center;">
                    <h3 style="margin: 0; color: #007bff;"><?php echo $stats['pcs']; ?></h3>
                    <p style="margin: 0;">PC dans le parc</p>
                </div>
                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center;">
                    <h3 style="margin: 0; color: #28a745;"><?php echo $stats['components']; ?></h3>
                    <p style="margin: 0;">Composants disponibles</p>
                </div>
                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center;">
                    <h3 style="margin: 0; color: #ffc107;"><?php echo $stats['assignments']; ?></h3>
                    <p style="margin: 0;">Associations PC-Composants</p>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h2>Configuration automatique</h2>
            <p>Cette action va configurer automatiquement tous les PC avec les composants du document TechSolutions selon leur service.</p>
            
            <div style="background: #fff3cd; padding: 1rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #ffc107;">
                <strong>Services configurés :</strong>
                <ul style="margin: 0.5rem 0;">
                    <?php foreach (array_keys($pc_configs) as $service): ?>
                        <li><?php echo htmlspecialchars($service); ?> (<?php echo count($pc_configs[$service]); ?> composants)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <form method="post">
                <input type="hidden" name="action" value="populate_configs">
                <button type="submit" class="admin-btn" onclick="return confirm('Configurer tous les PC avec les composants TechSolutions ?')">
                    Configurer automatiquement
                </button>
            </form>
        </div>
    </div>
</body>
</html>