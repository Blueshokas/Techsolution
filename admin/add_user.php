<?php
require_once '../config.php';
require_once 'permissions.php';

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: login.php');
    exit;
}

checkRole('admin');

$message = '';
$error = '';

if ($_POST) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];
    
    if (empty($username) || empty($password) || empty($role)) {
        $error = "Tous les champs sont requis";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            
            if ($stmt->fetch()) {
                $error = "Cet utilisateur existe déjà";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
                $stmt->execute([$username, $hashedPassword, $role]);
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
            
            <div class="admin-form-group">
                <label>Rôle</label>
                <select name="role" required>
                    <option value="utilisateur">Utilisateur</option>
                    <option value="technicien">Technicien</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            
            <button type="submit" class="admin-btn">Créer l'utilisateur</button>
            <a href="dashboard.php" class="admin-btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>