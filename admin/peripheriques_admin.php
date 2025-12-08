<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

// Ajouter un périphérique
if ($_POST && $_POST['action'] === 'add_peripherique') {
    $nom = trim($_POST['nom']);
    $type = trim($_POST['type']);
    $marque = trim($_POST['marque']);
    
    if ($nom && $type) {
        try {
            $stmt = $pdo->prepare("INSERT INTO peripheriques (nom, type, marque) VALUES (?, ?, ?)");
            $stmt->execute([$nom, $type, $marque]);
            $message = "Périphérique ajouté !";
        } catch(Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}

// Supprimer un périphérique
if ($_POST && $_POST['action'] === 'delete_peripherique') {
    $id = (int)$_POST['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM peripheriques WHERE id = ?");
        $stmt->execute([$id]);
        $message = "Périphérique supprimé !";
    } catch(Exception $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}

// Récupérer tous les périphériques
try {
    $peripheriques = $pdo->query("SELECT * FROM peripheriques ORDER BY type, nom")->fetchAll();
} catch(Exception $e) {
    $peripheriques = [];
}
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Gestion Périphériques - TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Gestion des Périphériques</h1>
            <div>
                <a href="dashboard.php" class="admin-btn">← Dashboard</a>
                <a href="logout.php" class="admin-btn btn-danger">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="admin-container">
        <?php if ($message): ?>
            <div class="admin-message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="form-section">
            <h2>Ajouter un périphérique</h2>
            <form method="post">
                <input type="hidden" name="action" value="add_peripherique">
                <div class="admin-form-group">
                    <label for="type">Type *</label>
                    <select id="type" name="type" required>
                        <option value="">Sélectionner un type</option>
                        <option value="Écran">Écran</option>
                        <option value="Clavier">Clavier</option>
                        <option value="Souris">Souris</option>
                        <option value="Tapis de souris">Tapis de souris</option>
                        <option value="Casque Audio">Casque Audio</option>
                        <option value="Webcam">Webcam</option>
                        <option value="Tablette Graphique">Tablette Graphique</option>
                        <option value="Colorimètre">Colorimètre</option>
                        <option value="Scanner">Scanner</option>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label for="nom">Nom du périphérique *</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="admin-form-group">
                    <label for="marque">Marque</label>
                    <input type="text" id="marque" name="marque">
                </div>
                <button type="submit" class="admin-btn">Ajouter</button>
            </form>
        </div>

        <div class="pc-list">
            <h2>Périphériques disponibles</h2>
            <?php if ($peripheriques): ?>
                <?php 
                $current_type = '';
                foreach ($peripheriques as $peripherique): 
                    if ($current_type !== $peripherique['type']):
                        if ($current_type !== '') echo '</div>';
                        $current_type = $peripherique['type'];
                        echo '<h3 style="margin-top: 2rem; color: #007bff;">' . htmlspecialchars($current_type) . '</h3>';
                        echo '<div style="margin-left: 1rem;">';
                    endif;
                ?>
                <div class="pc-item" style="grid-template-columns: 2fr 1fr 1fr;">
                    <div>
                        <div class="pc-name"><?php echo htmlspecialchars($peripherique['nom']); ?></div>
                        <?php if (isset($peripherique['marque']) && $peripherique['marque']): ?>
                            <div style="font-size: 0.9rem; color: #666;">Marque: <?php echo htmlspecialchars($peripherique['marque']); ?></div>
                        <?php endif; ?>
                    </div>
                    <div><?php echo htmlspecialchars($peripherique['type']); ?></div>
                    <div>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="action" value="delete_peripherique">
                            <input type="hidden" name="id" value="<?php echo $peripherique['id']; ?>">
                            <button type="submit" class="admin-btn btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucun périphérique.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>