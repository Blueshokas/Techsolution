<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

// Gestion des actions
if ($_POST) {
    if ($_POST['action'] === 'add_component') {
        $nom = trim($_POST['nom']);
        $type = trim($_POST['type']);
        $marque = trim($_POST['marque']);
        
        if ($nom && $type) {
            try {
                $stmt = $pdo->prepare("INSERT INTO components (nom, type, marque) VALUES (?, ?, ?)");
                $stmt->execute([$nom, $type, $marque]);
                $message = "Composant ajouté !";
            } catch(Exception $e) {
                $message = "Erreur : " . $e->getMessage();
            }
        }
    } elseif ($_POST['action'] === 'delete_component') {
        $id = (int)$_POST['id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM components WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Composant supprimé !";
        } catch(Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}

// Récupérer tous les composants
try {
    $components = $pdo->query("SELECT * FROM components ORDER BY type, nom")->fetchAll();
} catch(Exception $e) {
    $components = [];
}
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Gestion Composants - TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Gestion des Composants</h1>
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
            <h2>Ajouter un composant</h2>
            <form method="post">
                <input type="hidden" name="action" value="add_component">
                <div class="admin-form-group">
                    <label for="type">Type *</label>
                    <select id="type" name="type" required>
                        <option value="">Sélectionner un type</option>
                        <option value="CPU">CPU</option>
                        <option value="RAM">RAM</option>
                        <option value="SSD">SSD</option>
                        <option value="HDD">HDD</option>
                        <option value="GPU">GPU</option>
                        <option value="Carte Mère">Carte Mère</option>
                        <option value="Boîtier">Boîtier</option>
                        <option value="Alimentation">Alimentation</option>
                        <option value="Refroidissement">Refroidissement</option>
                        <option value="Écran">Écran</option>
                        <option value="Clavier">Clavier</option>
                        <option value="Souris">Souris</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label for="nom">Nom du composant *</label>
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
            <h2>Composants disponibles</h2>
            <?php if ($components): ?>
                <?php 
                $current_type = '';
                foreach ($components as $component): 
                    if ($current_type !== $component['type']):
                        if ($current_type !== '') echo '</div>';
                        $current_type = $component['type'];
                        echo '<h3 style="margin-top: 2rem; color: #007bff;">' . htmlspecialchars($current_type) . '</h3>';
                        echo '<div style="margin-left: 1rem;">';
                    endif;
                ?>
                <div class="pc-item" style="grid-template-columns: 2fr 1fr 1fr;">
                    <div>
                        <div class="pc-name"><?php echo htmlspecialchars($component['nom']); ?></div>
                        <?php if ($component['marque']): ?>
                            <div style="font-size: 0.9rem; color: #666;">Marque: <?php echo htmlspecialchars($component['marque']); ?></div>
                        <?php endif; ?>
                    </div>
                    <div><?php echo htmlspecialchars($component['type']); ?></div>
                    <div>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="action" value="delete_component">
                            <input type="hidden" name="id" value="<?php echo $component['id']; ?>">
                            <button type="submit" class="admin-btn btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucun composant.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>