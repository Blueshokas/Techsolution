<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_POST) {
    if ($_POST['action'] === 'add') {
        $titre = trim($_POST['titre']);
        $contenu = trim($_POST['contenu']);
        
        if ($titre && $contenu) {
            try {
                $stmt = $pdo->prepare("INSERT INTO actualites (titre, contenu) VALUES (?, ?)");
                $stmt->execute([$titre, $contenu]);
                $message = "Actualité ajoutée !";
            } catch(Exception $e) {
                $message = "Erreur : " . $e->getMessage();
            }
        }
    } elseif ($_POST['action'] === 'delete') {
        $id = (int)$_POST['id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM actualites WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Actualité supprimée !";
        } catch(Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}

try {
    $actualites = $pdo->query("SELECT * FROM actualites ORDER BY date_publication DESC")->fetchAll();
} catch(Exception $e) {
    $actualites = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Actualités - TechSolutions</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f8f9fa; }
        .header { background: #343a40; color: white; padding: 1rem 0; }
        .header .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem 20px; }
        
        .form-section { background: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px; }
        textarea { height: 120px; resize: vertical; }
        
        .btn { padding: 0.8rem 1.5rem; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        
        .actualites-list { background: white; padding: 2rem; border-radius: 8px; }
        .actualite-item { border-bottom: 1px solid #eee; padding: 1rem 0; }
        .actualite-item:last-child { border-bottom: none; }
        .actualite-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
        .actualite-title { font-weight: bold; color: #333; }
        .actualite-date { color: #666; font-size: 0.9rem; }
        
        .message { padding: 1rem; margin-bottom: 1rem; background: #d4edda; color: #155724; border-radius: 4px; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>Gestion des Actualités</h1>
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
            <h2>Ajouter une actualité</h2>
            <form method="post">
                <input type="hidden" name="action" value="add">
                <div class="form-group">
                    <label for="titre">Titre *</label>
                    <input type="text" id="titre" name="titre" required>
                </div>
                <div class="form-group">
                    <label for="contenu">Contenu *</label>
                    <textarea id="contenu" name="contenu" required></textarea>
                </div>
                <button type="submit" class="btn">Publier</button>
            </form>
        </div>

        <div class="actualites-list">
            <h2>Actualités publiées</h2>
            <?php if ($actualites): ?>
                <?php foreach ($actualites as $actu): ?>
                <div class="actualite-item">
                    <div class="actualite-header">
                        <div class="actualite-title"><?php echo htmlspecialchars($actu['titre']); ?></div>
                        <div class="actualite-date"><?php echo date('d/m/Y H:i', strtotime($actu['date_publication'])); ?></div>
                    </div>
                    <p><?php echo htmlspecialchars(substr($actu['contenu'], 0, 150)); ?>...</p>
                    <form method="post" style="margin-top: 1rem;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $actu['id']; ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
                    </form>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune actualité.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>