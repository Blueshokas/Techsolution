<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

// PC à créer selon le document TechSolutions
$pcs_to_create = [
    ['nom' => 'PC Développement', 'prix' => 2500],
    ['nom' => 'PC Infrastructure', 'prix' => 3500],
    ['nom' => 'PC Design UX/UI', 'prix' => 4500],
    ['nom' => 'PC Marketing', 'prix' => 1500],
    ['nom' => 'PC Support Client', 'prix' => 1200],
    ['nom' => 'PC Support Handicap', 'prix' => 2000],
    ['nom' => 'PC RH Administration', 'prix' => 1800],
    ['nom' => 'PC Direction', 'prix' => 5500]
];

// Configurations par PC
$pc_configs = [
    'PC Développement' => [
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
    'PC Infrastructure' => [
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
    'PC Design UX/UI' => [
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
    'PC Marketing' => [
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
    'PC Support Client' => [
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
    'PC Support Handicap' => [
        'Intel Core i5-14600K (3.5 GHz / 5.3 GHz)',
        'ASUS PRIME Z790-P WIFI',
        'Corsair Vengeance DDR5 32 Go (2 x 16 Go) 4800 MHz CL40',
        'Samsung 980 PRO 1 To M.2 NVMe PCIe 4.0',
        'Fractal Design Define 7 Compact',
        'Seasonic FOCUS GX-750 650W 80+ Gold Modulaire',
        'be quiet! Pure Rock 3',
        'iiyama 27" LED - G-Master GB2745QSU-B2 Black Hawk',
        'Clavier rétroéclairé à gros caractères pour PC',
        'Contour RollerMouse Red Plus',
        'Logitech USB Headset H390'
    ],
    'PC RH Administration' => [
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
    'PC Direction' => [
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

if ($_POST && $_POST['action'] === 'create_pcs') {
    try {
        $pdo->beginTransaction();
        
        $created_pcs = 0;
        $assigned_components = 0;
        $errors = 0;
        
        // Supprimer tous les anciens PC et leurs composants
        $pdo->exec("DELETE FROM pc_components");
        $pdo->exec("DELETE FROM pcs");
        
        foreach ($pcs_to_create as $pc_data) {
            // Créer le PC
            $stmt = $pdo->prepare("INSERT INTO pcs (nom, prix) VALUES (?, ?)");
            $stmt->execute([$pc_data['nom'], $pc_data['prix']]);
            $pc_id = $pdo->lastInsertId();
            $created_pcs++;
            
            // Associer les composants
            if (isset($pc_configs[$pc_data['nom']])) {
                foreach ($pc_configs[$pc_data['nom']] as $component_name) {
                    $stmt = $pdo->prepare("SELECT id FROM components WHERE nom = ?");
                    $stmt->execute([$component_name]);
                    $component = $stmt->fetch();
                    
                    if ($component) {
                        $stmt = $pdo->prepare("INSERT INTO pc_components (pc_id, component_id) VALUES (?, ?)");
                        $stmt->execute([$pc_id, $component['id']]);
                        $assigned_components++;
                    } else {
                        $errors++;
                    }
                }
            }
        }
        
        $pdo->commit();
        $message = "Création terminée ! $created_pcs PC créés, $assigned_components composants assignés, $errors composants non trouvés.";
        
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
    <title>Création PC TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Création PC TechSolutions</h1>
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
            <h2>Création des PC TechSolutions</h2>
            <p>Cette action va créer tous les PC selon le document TechSolutions avec leurs composants.</p>
            
            <div style="background: #d1ecf1; padding: 1rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #17a2b8;">
                <strong>PC à créer :</strong>
                <ul style="margin: 0.5rem 0;">
                    <?php foreach ($pcs_to_create as $pc): ?>
                        <li><?php echo htmlspecialchars($pc['nom']); ?> - <?php echo $pc['prix']; ?>€</li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <form method="post">
                <input type="hidden" name="action" value="create_pcs">
                <button type="submit" class="admin-btn" onclick="return confirm('Créer tous les PC TechSolutions avec leurs composants ?')">
                    Créer les PC TechSolutions
                </button>
            </form>
        </div>

        <div class="form-section">
            <h2>Aperçu des configurations</h2>
            <div style="max-height: 400px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 8px;">
                <?php foreach ($pc_configs as $pc_name => $components): ?>
                    <div style="margin-bottom: 1rem;">
                        <h4 style="background: #007bff; color: white; margin: 0; padding: 0.5rem 1rem;">
                            <?php echo htmlspecialchars($pc_name); ?> (<?php echo count($components); ?> composants)
                        </h4>
                        <div style="padding: 0.5rem 1rem; background: #f8f9fa;">
                            <?php foreach (array_slice($components, 0, 5) as $component): ?>
                                <div style="font-size: 0.9rem; padding: 0.1rem 0;">• <?php echo htmlspecialchars($component); ?></div>
                            <?php endforeach; ?>
                            <?php if (count($components) > 5): ?>
                                <div style="font-size: 0.9rem; color: #666; font-style: italic;">... et <?php echo count($components) - 5; ?> autres composants</div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>