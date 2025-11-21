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
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Changer mot de passe - TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Changer le mot de passe</h1>
            <div>
                <a href="dashboard.php" class="admin-btn">← Dashboard</a>
                <a href="logout.php" class="admin-btn btn-danger">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="admin-container-small">
        <?php if ($message): ?>
            <div class="admin-message <?php echo strpos($message, 'succès') !== false ? '' : 'admin-error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="form-section">
            <form method="post">
                <div class="admin-form-group">
                    <label for="current_password">Mot de passe actuel *</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="admin-form-group">
                    <label for="new_password">Nouveau mot de passe *</label>
                    <input type="password" id="new_password" name="new_password" required minlength="6">
                </div>
                <div class="admin-form-group">
                    <label for="confirm_password">Confirmer le nouveau mot de passe *</label>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
                </div>
                <button type="submit" class="admin-btn">Modifier</button>
            </form>
        </div>
    </div>
</body>
</html>