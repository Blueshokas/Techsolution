<?php
require_once '../config.php';

// Créer la table périphériques
try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS peripheriques (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(255) NOT NULL,
            type ENUM('Écran', 'Clavier', 'Souris', 'Casque', 'Webcam', 'Spéciaux') NOT NULL,
            departement VARCHAR(100) NOT NULL,
            quantite INT DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Insérer les données des périphériques
    $peripheriques = [
        // Développement
        ['2x Dell UltraSharp U2723DE 27" QHD', 'Écran', 'Développement', 15],
        ['Logitech MX Keys Advanced Wireless', 'Clavier', 'Développement', 15],
        ['Logitech MX Master 3S', 'Souris', 'Développement', 15],
        ['Jabra Evolve2 65 Bluetooth ANC', 'Casque', 'Développement', 15],
        ['Logitech Brio 4K', 'Webcam', 'Développement', 15],
        ['Tapis SteelSeries QcK Heavy XXL', 'Spéciaux', 'Développement', 15],
        
        // Infrastructures
        ['3x LG 27UP850-W 27" 4K', 'Écran', 'Infrastructures', 5],
        ['Das Keyboard 4 Professional Mécanique', 'Clavier', 'Infrastructures', 5],
        ['Logitech MX Master 3S', 'Souris', 'Infrastructures', 5],
        ['Sennheiser SC 165 USB', 'Casque', 'Infrastructures', 5],
        ['Logitech C920 HD Pro', 'Webcam', 'Infrastructures', 5],
        ['Hub Anker PowerExpand 13-en-1 + Tapis SteelSeries XXL', 'Spéciaux', 'Infrastructures', 5],
        
        // Design UX/UI
        ['2x BenQ SW272U 27" 4K Pro', 'Écran', 'Design UX/UI', 5],
        ['Apple Magic Keyboard Pavé Numérique', 'Clavier', 'Design UX/UI', 5],
        ['Logitech MX Master 3S', 'Souris', 'Design UX/UI', 5],
        ['Sony WH-1000XM5 Bluetooth ANC', 'Casque', 'Design UX/UI', 5],
        ['Logitech Brio 4K', 'Webcam', 'Design UX/UI', 5],
        ['Wacom Intuos Pro Large PTH-860 + Colorimètre X-Rite i1Display Pro + Tapis Razer Strider XXL', 'Spéciaux', 'Design UX/UI', 5],
        
        // Marketing
        ['1x ASUS VA24EHE 24" Full HD', 'Écran', 'Marketing', 10],
        ['Logitech K270 Wireless', 'Clavier', 'Marketing', 10],
        ['Logitech M330 Silent Plus Wireless', 'Souris', 'Marketing', 10],
        ['Jabra Evolve 40 UC Stereo USB', 'Casque', 'Marketing', 10],
        ['Logitech C270 HD 720p', 'Webcam', 'Marketing', 10],
        ['Tapis basique LDLC', 'Spéciaux', 'Marketing', 10],
        
        // Support Standard
        ['1x Dell P2422H 24" Full HD', 'Écran', 'Support Standard', 4],
        ['Logitech K120 USB Filaire', 'Clavier', 'Support Standard', 4],
        ['Logitech B100 USB', 'Souris', 'Support Standard', 4],
        ['Plantronics Blackwire 3220 USB', 'Casque', 'Support Standard', 4],
        ['Logitech C270 HD 720p', 'Webcam', 'Support Standard', 4],
        ['Aucun', 'Spéciaux', 'Support Standard', 4],
        
        // Support Adapté
        ['1x Dell UltraSharp U2723DE 27" QHD', 'Écran', 'Support Adapté', 1],
        ['Clevy grandes touches contrastées', 'Clavier', 'Support Adapté', 1],
        ['Contour RollerMouse Red Plus', 'Souris', 'Support Adapté', 1],
        ['Beyerdynamic DT 770 PRO 80 Ohm', 'Casque', 'Support Adapté', 1],
        ['Aucune', 'Webcam', 'Support Adapté', 1],
        ['Plage Braille Focus 40 Blue + Lampe LED TaoTronics + Pavé numérique USB tactile', 'Spéciaux', 'Support Adapté', 1],
        
        // RH & Admin
        ['1x HP E24 G5 24" Full HD', 'Écran', 'RH & Admin', 5],
        ['Microsoft Wired Keyboard 600 USB', 'Clavier', 'RH & Admin', 5],
        ['Microsoft Basic Optical Mouse USB', 'Souris', 'RH & Admin', 5],
        ['Logitech H390 USB', 'Casque', 'RH & Admin', 5],
        ['Logitech C270 HD 720p', 'Webcam', 'RH & Admin', 5],
        ['Tapis basique LDLC', 'Spéciaux', 'RH & Admin', 5],
        
        // Direction
        ['2x Dell UltraSharp U3223QE 32" 4K', 'Écran', 'Direction', 5],
        ['Logitech MX Keys S for Business', 'Clavier', 'Direction', 5],
        ['Logitech MX Master 3S for Business', 'Souris', 'Direction', 5],
        ['Bose 700 UC Bluetooth ANC', 'Casque', 'Direction', 5],
        ['Logitech BRIO 4K Stream Edition', 'Webcam', 'Direction', 5],
        ['CalDigit TS4 Thunderbolt 4 Dock + Tapis Razer Pro Glide XXL', 'Spéciaux', 'Direction', 5]
    ];

    $stmt = $pdo->prepare("INSERT INTO peripheriques (nom, type, departement, quantite) VALUES (?, ?, ?, ?)");
    
    foreach ($peripheriques as $periph) {
        $stmt->execute($periph);
    }

    echo "✅ Table périphériques créée et données insérées !<br>";
    echo "<a href='pc.php'>Voir le parc informatique</a> | <a href='dashboard.php'>Retour dashboard</a>";

} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage();
}
?>