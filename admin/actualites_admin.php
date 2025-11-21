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
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Gestion Actualités - TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Gestion des Actualités</h1>
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
            <h2>Ajouter une actualité</h2>
            <form method="post">
                <input type="hidden" name="action" value="add">
                <div class="admin-form-group">
                    <label for="titre">Titre *</label>
                    <input type="text" id="titre" name="titre" required>
                </div>
                <div class="admin-form-group">
                    <label for="contenu">Contenu *</label>
                    <textarea id="contenu" name="contenu" required></textarea>
                </div>
                <button type="submit" class="admin-btn">Publier</button>
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
                        <button type="submit" class="admin-btn btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
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