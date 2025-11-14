<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_POST) {
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    if ($new_password !== $confirm_password) {
        $message = "Les nouveaux mots de passe ne correspondent pas.";
    } elseif (strlen($new_password) < 6) {
        $message = "Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ?");
            $stmt->execute([$_SESSION['admin_username']]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($current_password, $user['password'])) {
                $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
                $stmt->execute([$hashedPassword, $_SESSION['admin_username']]);
                $message = "Mot de passe modifié avec succès !";
            } else {
                $message = "Mot de passe actuel incorrect.";
            }
        } catch(Exception $e) {
            $message = "Erreur lors de la modification.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Changer mot de passe - TechSolutions</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f8f9fa; }
        .header { background: #343a40; color: white; padding: 1rem 0; }
        .header .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 500px; margin: 2rem auto; padding: 0 20px; }
        .form-section { background: white; padding: 2rem; border-radius: 8px; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 0.8rem 1.5rem; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .message { padding: 1rem; margin-bottom: 1rem; background: #d4edda; color: #155724; border-radius: 4px; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>Changer le mot de passe</h1>
            <div>
                <a href="dashboard.php" class="btn">← Dashboard</a>
                <a href="logout.php" class="btn btn-danger">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="container">
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'succès') !== false ? '' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="form-section">
            <form method="post">
                <div class="form-group">
                    <label for="current_password">Mot de passe actuel *</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Nouveau mot de passe *</label>
                    <input type="password" id="new_password" name="new_password" required minlength="6">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmer le nouveau mot de passe *</label>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
                </div>
                <button type="submit" class="btn">Modifier</button>
            </form>
        </div>
    </div>
</body>
</html>