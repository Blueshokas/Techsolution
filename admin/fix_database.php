<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_POST && $_POST['action'] === 'fix_database') {
    try {
        // Ajouter la colonne marque si elle n'existe pas
        $pdo->exec("ALTER TABLE components ADD COLUMN marque VARCHAR(255) DEFAULT NULL");
        $message = "Colonne 'marque' ajoutée avec succès !";
    } catch(Exception $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            $message = "La colonne 'marque' existe déjà.";
        } else {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}

// Vérifier la structure de la table
try {
    $columns = $pdo->query("DESCRIBE components")->fetchAll();
} catch(Exception $e) {
    $columns = [];
}
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Correction Base de Données - TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Correction Base de Données</h1>
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
            <h2>Structure actuelle de la table 'components'</h2>
            <?php if ($columns): ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="background: #f8f9fa;">
                        <th style="border: 1px solid #dee2e6; padding: 0.5rem;">Colonne</th>
                        <th style="border: 1px solid #dee2e6; padding: 0.5rem;">Type</th>
                        <th style="border: 1px solid #dee2e6; padding: 0.5rem;">Null</th>
                        <th style="border: 1px solid #dee2e6; padding: 0.5rem;">Défaut</th>
                    </tr>
                    <?php foreach ($columns as $column): ?>
                        <tr>
                            <td style="border: 1px solid #dee2e6; padding: 0.5rem;"><?php echo htmlspecialchars($column['Field']); ?></td>
                            <td style="border: 1px solid #dee2e6; padding: 0.5rem;"><?php echo htmlspecialchars($column['Type']); ?></td>
                            <td style="border: 1px solid #dee2e6; padding: 0.5rem;"><?php echo htmlspecialchars($column['Null']); ?></td>
                            <td style="border: 1px solid #dee2e6; padding: 0.5rem;"><?php echo htmlspecialchars($column['Default'] ?? 'NULL'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>

        <div class="form-section">
            <h2>Correction nécessaire</h2>
            <p>Pour utiliser le système de composants TechSolutions, la colonne 'marque' doit être ajoutée à la table 'components'.</p>
            
            <form method="post">
                <input type="hidden" name="action" value="fix_database">
                <button type="submit" class="admin-btn">Ajouter la colonne 'marque'</button>
            </form>
        </div>
    </div>
</body>
</html>