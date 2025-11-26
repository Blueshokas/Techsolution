<?php
require_once '../config.php';

try {
    // Ajouter la colonne 'lu' à la table contacts
    $pdo->exec("ALTER TABLE contacts ADD COLUMN IF NOT EXISTS lu TINYINT(1) DEFAULT 0");
    
    echo "✅ Colonne 'lu' ajoutée avec succès à la table contacts !<br>";
    echo "<a href='messages.php'>Voir les messages</a> | <a href='dashboard.php'>Retour dashboard</a>";
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage();
}
?>