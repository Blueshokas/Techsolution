<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$results = [];

try {
    // Supprimer toutes les associations existantes
    $pdo->exec("DELETE FROM pc_components");
    $pdo->exec("DELETE FROM pc_peripheriques");
    $results[] = "✓ Anciennes associations supprimées";
    
    // Récupérer tous les PC, composants et périphériques
    $pcs = $pdo->query("SELECT * FROM pcs")->fetchAll(PDO::FETCH_ASSOC);
    $components = $pdo->query("SELECT * FROM components")->fetchAll(PDO::FETCH_ASSOC);
    $peripheriques = $pdo->query("SELECT * FROM peripheriques")->fetchAll(PDO::FETCH_ASSOC);
    
    // Créer des index
    $pc_index = [];
    foreach ($pcs as $p) $pc_index[$p['nom']] = $p['id'];
    
    $comp_index = [];
    foreach ($components as $c) $comp_index[$c['nom']] = $c['id'];
    
    $periph_index = [];
    foreach ($peripheriques as $p) $periph_index[$p['nom']] = $p['id'];
    
    // Configuration complète par PC
    $configs = [
        'PC Développement' => [
            'components' => [
                'Aerocool CS-106',
                'be quiet! Pure Wings 3 120mm PWM',
                'Gigabyte H610M S2H V3 DDR4',
                'Intel Core i7-13700F',
                'MSI GeForce RTX 3050 LP 6G OC',
                'Noctua NH-U12A Chromax Black',
                'G.Skill Aegis 32 Go (2×16 Go) DDR4 3200 MHz CL16',
                'Samsung SSD 980 NVMe M.2 1 To',
                'Corsair RM850e (2025) – 850W'
            ],
            'peripheriques' => [
                'Logitech K120 for Business',
                'Altyk Tapis de souris Taille M',
                'INOVU EG200V',
                'iiyama 27" LED – G-Master GB2745QSU-B2 Black Hawk'
            ]
        ],
        'PC Infrastructure' => [
            'components' => [
                'Intel Core i7-13700K',
                'MSI PRO Z790-P WIFI',
                'Kingston FURY Beast DDR5 64 Go (2×32 Go) 5600 MHz',
                'Samsung 990 PRO NVMe M.2 – 2 To',
                'Western Digital Red Plus – 4 To',
                'NVIDIA Quadro P620 – 2 Go',
                'Corsair 4000D Airflow',
                'Seasonic FOCUS GX-850 – 850W 80+ Gold',
                'Noctua NH-D15'
            ],
            'peripheriques' => [
                'LG 27UP850-W – 27\'\' 4K',
                'Logitech K280e Pro',
                'Logitech MX Master 3S',
                'SteelSeries QcK Heavy XXL'
            ]
        ],
        'PC Design UX/UI' => [
            'components' => [
                'AMD Ryzen 9 7900X',
                'ASUS ROG STRIX B650E-F GAMING WIFI',
                'G.Skill Trident Z5 RGB DDR5 64 Go (2x32 Go) 6000 MHz',
                'Samsung 990 PRO 2 To M.2 NVMe PCIe 4.0',
                'Samsung 870 EVO 4 To',
                'Gigabyte GeForce RTX 5070 EAGLE OC SFF 12G',
                'NZXT H7 Flow RGB Noir (2024)',
                'be quiet! Power Zone 2 1000W 80PLUS Platinum',
                'NZXT Kraken X63 280mm AIO RGB'
            ],
            'peripheriques' => [
                'BenQ SW272U 27" 4K IPS Professionnel',
                'Wacom Intuos Pro Large PTH-860',
                'Logitech K120 for Business',
                'Logitech MX Master 3S',
                'Calibrite Display Pro HL',
                'Razer Strider XXL Hybrid'
            ]
        ],
        'PC Marketing' => [
            'components' => [
                'Intel Core i5-12600K',
                'MSI PRO B760M-P DDR4',
                'Corsair Vengeance LPX Series Low Profile 16 Go (2x 8 Go) DDR4 3200 MHz CL16',
                'Kingston SSD NV3 500 Go',
                'Seagate BarraCuda 1 To 7200 RPM 3.5"',
                'Cooler Master MasterBox Q300L',
                'Corsair CX550 80PLUS Bronze (2023)',
                'Cooler Master Hyper 212 Black Edition'
            ],
            'peripheriques' => [
                'ASUS VA24EHF 24" Full HD IPS',
                'Logitech K270 Wireless Keyboard',
                'Logitech M330 Silent Plus Wireless',
                'Logitech USB Headset H390',
                'Logitech C270 HD 720p',
                'Fox Spirit S-Pad'
            ]
        ],
        'PC Support Client' => [
            'components' => [
                'AMD Ryzen 5 5600GT Wraith Stealth',
                'Gigabyte B550M DS3H AC R2',
                'Kingston FURY Beast DDR4 16 Go (2x8 Go) 3200 MHz',
                'Kingston NV2 500 Go M.2 NVMe PCIe 4.0',
                'Thermaltake View 270 TG ARGB (blanc)',
                'Corsair CV550 450W 80+ Bronze',
                'be quiet! Pure Rock Pro 3'
            ],
            'peripheriques' => [
                'Dell P2422H 24" Full HD IPS',
                'Logitech K120 USB Filaire',
                'Logitech B100 USB Optique',
                'Logitech USB Headset H390',
                'Logitech C270 HD 720p'
            ]
        ],
        'PC Support Handicap' => [
            'components' => [
                'Intel Core i5-14600K',
                'ASUS PRIME Z790-P WIFI',
                'Corsair Vengeance DDR5 32 Go (2 x 16 Go) 4800 MHz CL40',
                'Samsung 980 PRO 1 To M.2 NVMe PCIe 4.0',
                'Fractal Design Define 7 Compact',
                'Seasonic FOCUS GX-750 650W 80+ Gold Modulaire',
                'be quiet! Pure Rock 3'
            ],
            'peripheriques' => [
                'iiyama 27" LED - G-Master GB2745QSU-B2 Black Hawk',
                'Clavier rétroéclairé à gros caractères pour PC',
                'Contour RollerMouse Red Plus',
                'Logitech USB Headset H390'
            ]
        ],
        'PC RH Administration' => [
            'components' => [
                'Intel Core i5-12600K',
                'ASUS PRIME B760M-A WIFI D4',
                'Textorm 16 Go (2x 8 Go) DDR4 3200 MHz',
                'Samsung SSD 870 EVO 500 Go',
                'Western Digital WD Red Pro 2 To',
                'Antec P10C',
                'Corsair CX550 80+ Bronze',
                'Cooler Master Hyper 212 Black Edition'
            ],
            'peripheriques' => [
                'iiyama 23.8" LED - ProLite XUB2491H-B1',
                'Logitech K120 for Business',
                'INOVU EG200V',
                'Logitech H390 USB',
                'Logitech C270 HD 720p',
                'Epson WorkForce ES-50',
                'Fox Spirit S-Pad'
            ]
        ],
        'PC Direction' => [
            'components' => [
                'Intel Core i9-13900KS',
                'ASUS TUF GAMING Z790-PLUS WIFI',
                'Corsair Dominator Titanium DDR5 RGB 64 Go (2 x 32 Go) 6000 MHz',
                'Samsung SSD 990 PRO M.2 PCIe NVMe 2 To',
                'Samsung SSD 870 EVO 4 To',
                'Gainward GeForce RTX 4060 Ti Pegasus 8GB',
                'Lian Li O11 Dynamic EVO XL',
                'Corsair HX1000i 80PLUS Platinum ATX 3.1',
                'Corsair Nautilus 360 RS ARGB (Noir)'
            ],
            'peripheriques' => [
                'iiyama 31.5" LED - ProLite XUB3293UHSN-B5',
                'Logitech MX Keys S Combo',
                'SteelSeries Arctis Nova Pro',
                'Logitech BRIO 4K B2C',
                'Razer Pro Glide XXL'
            ]
        ]
    ];
    
    // Associer composants et périphériques
    $stmt_comp = $pdo->prepare("INSERT INTO pc_components (pc_id, component_id) VALUES (?, ?)");
    $stmt_periph = $pdo->prepare("INSERT INTO pc_peripheriques (pc_id, peripherique_id) VALUES (?, ?)");
    
    foreach ($configs as $pc_nom => $config) {
        if (!isset($pc_index[$pc_nom])) continue;
        $pc_id = $pc_index[$pc_nom];
        
        $comp_count = 0;
        foreach ($config['components'] as $comp_nom) {
            if (isset($comp_index[$comp_nom])) {
                $stmt_comp->execute([$pc_id, $comp_index[$comp_nom]]);
                $comp_count++;
            }
        }
        
        $periph_count = 0;
        foreach ($config['peripheriques'] as $periph_nom) {
            if (isset($periph_index[$periph_nom])) {
                $stmt_periph->execute([$pc_id, $periph_index[$periph_nom]]);
                $periph_count++;
            }
        }
        
        $results[] = "$pc_nom: $comp_count composants + $periph_count périphériques";
    }
    
    $results[] = "<strong>✓ Synchronisation terminée!</strong>";
    
} catch(Exception $e) {
    $results[] = "Erreur: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Synchronisation Configurations</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Synchronisation Configurations</h1>
            <div><a href="dashboard.php" class="admin-btn">← Dashboard</a></div>
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
