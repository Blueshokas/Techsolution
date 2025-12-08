<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_POST) {
    if ($_POST['action'] === 'add') {
        $nom = trim($_POST['nom']);
        $prix = (float)$_POST['prix'];
        $stock = (int)$_POST['stock'];
        
        if ($nom && $prix > 0) {
            try {
                $stmt = $pdo->prepare("INSERT INTO pcs (nom, prix, stock) VALUES (?, ?, ?)");
                $stmt->execute([$nom, $prix, $stock]);
                $message = "PC ajouté !";
            } catch(Exception $e) {
                $message = "Erreur : " . $e->getMessage();
            }
        }
    } elseif ($_POST['action'] === 'delete') {
        $id = (int)$_POST['id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM pcs WHERE id = ?");
            $stmt->execute([$id]);
            $message = "PC supprimé !";
        } catch(Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}

try {
    // Récupérer les PC
    $stmt = $pdo->query("SELECT * FROM pcs ORDER BY nom");
    $pcs = $stmt->fetchAll();
} catch(Exception $e) {
    $pcs = [];
}
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Gestion PC - TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Gestion des PC</h1>
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
            <h2>Ajouter un PC</h2>
            <form method="post">
                <input type="hidden" name="action" value="add">
                <div class="admin-form-group">
                    <label for="nom">Nom *</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="admin-form-group">
                    <label for="prix">Prix (€) *</label>
                    <input type="number" id="prix" name="prix" step="0.01" min="0" required>
                </div>
                <div class="admin-form-group">
                    <label for="stock">Stock *</label>
                    <input type="number" id="stock" name="stock" min="0" required>
                </div>

                <button type="submit" class="admin-btn">Ajouter</button>
            </form>
        </div>

        <div class="pc-list">
            <h2>PC en catalogue</h2>
            <?php if ($pcs): ?>
                <div class="pc-item" style="font-weight: bold; border-bottom: 2px solid #333;">
                    <div>Nom</div>
                    <div>Prix</div>
                    <div>Stock</div>
                    <div>Actions</div>
                </div>
                <?php foreach ($pcs as $pc): ?>
                <div class="pc-item">
                    <div>
                        <div class="pc-name"><?php echo htmlspecialchars($pc['nom']); ?></div>
                    </div>
                    <div class="pc-price"><?php echo number_format($pc['prix'], 2, ',', ' '); ?> €</div>
                    <div><?php echo $pc['stock']; ?></div>
                    <div>
                        <a href="view_pc_components.php?id=<?php echo $pc['id']; ?>" class="admin-btn" style="margin-right: 0.5rem;">Voir composants</a>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $pc['id']; ?>">
                            <button type="submit" class="admin-btn btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun PC.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>