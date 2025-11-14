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
        $description = trim($_POST['description']);
        $prix = (float)$_POST['prix'];
        $stock = (int)$_POST['stock'];
        
        if ($nom && $description && $prix > 0) {
            try {
                $stmt = $pdo->prepare("INSERT INTO pcs (nom, description, prix, stock) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nom, $description, $prix, $stock]);
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
    // Récupérer les PC avec leurs composants pour l'admin
    $stmt = $pdo->query("
        SELECT p.*, 
               GROUP_CONCAT(CONCAT(c.nom, ' (', c.type, ')') SEPARATOR ', ') as composants
        FROM pcs p
        LEFT JOIN pc_components pc ON p.id = pc.pc_id
        LEFT JOIN components c ON pc.component_id = c.id
        GROUP BY p.id
        ORDER BY p.nom
    ");
    $pcs = $stmt->fetchAll();
} catch(Exception $e) {
    $pcs = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion PC - TechSolutions</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f8f9fa; }
        .header { background: #343a40; color: white; padding: 1rem 0; }
        .header .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem 20px; }
        
        .form-section { background: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px; }
        textarea { height: 80px; }
        
        .btn { padding: 0.8rem 1.5rem; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        
        .pc-list { background: white; padding: 2rem; border-radius: 8px; }
        .pc-item { border-bottom: 1px solid #eee; padding: 1rem 0; display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 1rem; align-items: center; }
        .pc-item:last-child { border-bottom: none; }
        .pc-name { font-weight: bold; color: #333; }
        .pc-price { color: #007bff; font-weight: bold; }
        
        .message { padding: 1rem; margin-bottom: 1rem; background: #d4edda; color: #155724; border-radius: 4px; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>Gestion des PC</h1>
            <div>
                <a href="dashboard.php" class="btn">← Dashboard</a>
                <a href="logout.php" class="btn btn-danger">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="container">
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="form-section">
            <h2>Ajouter un PC</h2>
            <form method="post">
                <input type="hidden" name="action" value="add">
                <div class="form-group">
                    <label for="nom">Nom *</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="prix">Prix (€) *</label>
                    <input type="number" id="prix" name="prix" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stock *</label>
                    <input type="number" id="stock" name="stock" min="0" required>
                </div>
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <button type="submit" class="btn">Ajouter</button>
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
                        <div style="font-size: 0.9rem; color: #666;"><?php echo htmlspecialchars(substr($pc['description'], 0, 50)); ?>...</div>
                    </div>
                    <div class="pc-price"><?php echo number_format($pc['prix'], 2, ',', ' '); ?> €</div>
                    <div><?php echo $pc['stock']; ?></div>
                    <div>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $pc['id']; ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
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