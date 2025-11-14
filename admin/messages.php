<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_POST && $_POST['action'] === 'delete') {
    $id = (int)$_POST['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
        $message = "Message supprimé !";
    } catch(Exception $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}

try {
    $messages = $pdo->query("SELECT * FROM contacts ORDER BY date_creation DESC")->fetchAll();
} catch(Exception $e) {
    $messages = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Messages - TechSolutions</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f8f9fa; }
        .header { background: #343a40; color: white; padding: 1rem 0; }
        .header .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem 20px; }
        
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 8px; text-align: center; }
        .stat-card h3 { font-size: 2rem; color: #007bff; margin-bottom: 0.5rem; }
        
        .messages-list { background: white; padding: 2rem; border-radius: 8px; }
        .message-item { border-bottom: 1px solid #eee; padding: 1.5rem 0; }
        .message-item:last-child { border-bottom: none; }
        .message-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .message-info { display: flex; gap: 2rem; }
        .message-name { font-weight: bold; color: #333; }
        .message-email { color: #007bff; }
        .message-date { color: #666; font-size: 0.9rem; }
        .message-content { background: #f8f9fa; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; }
        
        .btn { padding: 0.8rem 1.5rem; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        
        .message-alert { padding: 1rem; margin-bottom: 1rem; background: #d4edda; color: #155724; border-radius: 4px; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>Messages Clients</h1>
            <div>
                <a href="dashboard.php" class="btn">← Dashboard</a>
                <a href="logout.php" class="btn btn-danger">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="container">
        <?php if ($message): ?>
            <div class="message-alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="stats">
            <div class="stat-card">
                <h3><?php echo count($messages); ?></h3>
                <p>Messages reçus</p>
            </div>
            <div class="stat-card">
                <h3><?php echo count(array_filter($messages, function($m) { return strtotime($m['date_creation']) > strtotime('-7 days'); })); ?></h3>
                <p>Cette semaine</p>
            </div>
        </div>

        <div class="messages-list">
            <h2>Tous les messages</h2>
            <?php if ($messages): ?>
                <?php foreach ($messages as $msg): ?>
                <div class="message-item">
                    <div class="message-header">
                        <div class="message-info">
                            <div class="message-name"><?php echo htmlspecialchars($msg['nom']); ?></div>
                            <div class="message-email"><?php echo htmlspecialchars($msg['email']); ?></div>
                        </div>
                        <div class="message-date"><?php echo date('d/m/Y H:i', strtotime($msg['date_creation'])); ?></div>
                    </div>
                    <div class="message-content">
                        <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                    </div>
                    <div>
                        <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>" class="btn btn-success">Répondre</a>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun message reçu.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>