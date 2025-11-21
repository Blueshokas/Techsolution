<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: login.php');
    exit;
}

$message = '';
$error = '';

if ($_POST) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (empty($username) || empty($password)) {
        $error = "Tous les champs sont requis";
    } else {
        try {
            // Vérifier si l'utilisateur existe déjà
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            
            if ($stmt->fetch()) {
                $error = "Cet utilisateur existe déjà";
            } else {
                // Hasher le mot de passe
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Insérer le nouvel utilisateur
                $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->execute([$username, $hashedPassword]);
                
                $message = "Utilisateur créé avec succès";
            }
        } catch(Exception $e) {
            $error = "Erreur lors de la création : " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Utilisateur - Admin TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="admin-container-medium">
        <div class="nav">
            <a href="dashboard.php">← Retour au tableau de bord</a>
        </div>
        
        <h1>Ajouter un utilisateur</h1>
        
        <?php if ($message): ?>
            <div class="admin-message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="admin-message admin-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="admin-form-group">
                <label>Nom d'utilisateur</label>
                <input type="text" name="username" required>
            </div>
            
            <div class="admin-form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" class="admin-btn">Créer l'utilisateur</button>
            <a href="dashboard.php" class="admin-btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>