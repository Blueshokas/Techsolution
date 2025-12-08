<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

echo "<h2>Associations PC-Périphériques</h2>";

try {
    $stmt = $pdo->query("SELECT pp.*, p.nom as periph_nom, p.type, pc.nom as pc_nom 
                         FROM pc_peripheriques pp 
                         JOIN peripheriques p ON pp.peripherique_id = p.id 
                         JOIN pcs pc ON pp.pc_id = pc.id 
                         LIMIT 10");
    $assocs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($assocs) {
        echo "<pre>";
        print_r($assocs);
        echo "</pre>";
    } else {
        echo "<p style='color: red;'>Aucune association trouvée! Exécutez populate_pc_peripheriques.php</p>";
    }
} catch(Exception $e) {
    echo "<p style='color: red;'>Erreur: " . $e->getMessage() . "</p>";
}
