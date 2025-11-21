<?php
require_once '../config.php';

// Vider la table pcs
$pdo->exec("DELETE FROM pcs");

// Ajouter les nouvelles configurations avec composants détaillés
$configurations = [
    [
        'nom' => 'Poste Infrastructures Systèmes (5 postes)',
        'description' => 'CPU: Intel Core i7-13700K (16C/24T, 3.4-5.4 GHz) | Carte Mère: MSI PRO Z790-P WIFI DDR5 | RAM: Kingston FURY Beast DDR5 64 Go | SSD: Samsung 990 PRO 2 To | HDD: Western Digital Red Plus 4 To | GPU: PNY NVIDIA Quadro P620 | Écrans: 3x LG 27UP850-W 27" 4K | Clavier: Das Keyboard 4 Professional | Souris: Logitech MX Master 3S',
        'prix' => 4500.00,
        'stock' => 5
    ],
    [
        'nom' => 'Poste Design UX/UI (5 postes)',
        'description' => 'CPU: AMD Ryzen 9 7900X (12C/24T, 4.7-5.4 GHz) | Carte Mère: ASUS ROG STRIX B650E-F GAMING WIFI | RAM: G.Skill Trident Z5 RGB DDR5 64 Go | SSD: Samsung 990 PRO 2 To | GPU: NVIDIA GeForce RTX 4070 12 Go | Écrans: 2x BenQ SW272U 27" 4K Pro | Tablette: Wacom Intuos Pro Large | Clavier: Apple Magic Keyboard | Souris: Logitech MX Master 3S',
        'prix' => 5200.00,
        'stock' => 5
    ],
    [
        'nom' => 'Poste Marketing/Vente (10 postes)',
        'description' => 'CPU: Intel Core i5-13400 (10C/16T, 2.5-4.6 GHz) | Carte Mère: MSI PRO B660M-A WIFI DDR4 | RAM: Corsair Vengeance LPX DDR4 16 Go | SSD: Crucial P3 500 Go | HDD: Seagate BarraCuda 1 To | GPU: Intel UHD Graphics 730 | Écran: ASUS VA24EHE 24" Full HD | Clavier: Logitech K270 Wireless | Souris: Logitech M330 Silent Plus | Casque: Jabra Evolve 40 UC',
        'prix' => 1200.00,
        'stock' => 10
    ],
    [
        'nom' => 'Poste Support Client Standard (4 postes)',
        'description' => 'CPU: AMD Ryzen 5 5600G (6C/12T, 3.5-4.4 GHz) | Carte Mère: ASRock B550M Pro4 Micro-ATX | RAM: Kingston FURY Beast DDR4 16 Go | SSD: Kingston NV2 500 Go | GPU: AMD Radeon Vega 7 Graphics | Écran: Dell P2422H 24" Full HD | Clavier: Logitech K120 USB | Souris: Logitech B100 USB | Casque: Plantronics Blackwire 3220 USB',
        'prix' => 1000.00,
        'stock' => 4
    ],
    [
        'nom' => 'Poste Développement Logiciel (15 postes)',
        'description' => 'CPU: Intel Core i7-12700 (2.1 GHz / 4.9 GHz) | Carte Mère: Gigabyte H610M S2H V3 DDR4 | RAM: G.Skill Aegis 32 Go (2 x 16 Go) DDR4 3200 MHz CL16 | SSD: Samsung SSD 980 M.2 PCIe NVMe 1 To | GPU: MSI GeForce RTX 3050 LP 6G OC | Boîtier: Aerocool CS-106 (Noir) | Refroidissement: Noctua NH-U12A Chromax Black | Ventilation: be quiet! Pure Wings 3 120mm PWM | Alimentation: Corsair RM850e (2025)',
        'prix' => 2800.00,
        'stock' => 15
    ],
    [
        'nom' => 'Poste RH/Administration (5 postes)',
        'description' => 'CPU: Intel Core i5-13400 (10C/16T, 2.5-4.6 GHz) | Carte Mère: ASUS PRIME B660M-A D4 | RAM: Crucial DDR4 16 Go | SSD: Samsung 970 EVO Plus 500 Go | HDD: Western Digital Blue 1 To | GPU: Intel UHD Graphics 730 | Écran: HP E24 G5 24" Full HD | Clavier: Microsoft Wired Keyboard 600 | Souris: Microsoft Basic Optical Mouse | Scanner: Epson WorkForce DS-530 II (partagé)',
        'prix' => 1300.00,
        'stock' => 5
    ],
    [
        'nom' => 'Poste Direction (5 postes)',
        'description' => 'CPU: Intel Core i9-13900K (24C/32T, 3.0-5.8 GHz) | Carte Mère: ASUS ROG MAXIMUS Z790 HERO | RAM: Corsair Dominator Platinum RGB DDR5 64 Go | SSD: Samsung 990 PRO 2 To | GPU: NVIDIA GeForce RTX 4060 Ti 8 Go | Écrans: 2x Dell UltraSharp U3223QE 32" 4K IPS | Clavier: Logitech MX Keys S for Business | Souris: Logitech MX Master 3S | Station: CalDigit TS4 Thunderbolt 4 Dock',
        'prix' => 7500.00,
        'stock' => 5
    ]
];

foreach ($configurations as $config) {
    $stmt = $pdo->prepare("INSERT INTO pcs (nom, description, prix, stock, actif) VALUES (?, ?, ?, ?, 1)");
    $stmt->execute([$config['nom'], $config['description'], $config['prix'], $config['stock']]);
}

echo "Base de données mise à jour avec succès ! Les composants sont maintenant affichés en détail.";
?>