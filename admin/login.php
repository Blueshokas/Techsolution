<?php
require_once '../config.php';

$error = '';

if ($_POST) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged'] = true;
            $_SESSION['admin_username'] = $user['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Identifiants incorrects";
        }
    } catch(Exception $e) {
        $error = "Erreur de connexion";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin - TechSolutions</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .login-box { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 300px; }
        .login-box h1 { text-align: center; margin-bottom: 1.5rem; color: #333; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; }
        .form-group input { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn { width: 100%; padding: 0.8rem; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .error { color: red; text-align: center; margin-bottom: 1rem; }
        .back-link { text-align: center; margin-top: 1rem; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Admin TechSolutions</h1>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label>Nom d'utilisateur</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Se connecter</button>
        </form>
        
        <p class="back-link">
            <a href="../index.php">← Retour au site</a>
        </p>
    </div>
</body>
</html>