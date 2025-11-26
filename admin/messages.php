<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_POST) {
    if ($_POST['action'] === 'delete') {
        $id = (int)$_POST['id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Message supprimé !";
        } catch(Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'mark_read') {
        $id = (int)$_POST['id'];
        try {
            $stmt = $pdo->prepare("UPDATE contacts SET lu = 1 WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Message marqué comme lu !";
        } catch(Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}

try {
    $messages = $pdo->query("SELECT * FROM contacts ORDER BY date_creation DESC")->fetchAll();
} catch(Exception $e) {
    $messages = [];
}
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Messages - TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Messages Clients</h1>
            <div>
                <a href="dashboard.php" class="admin-btn">← Dashboard</a>
                <a href="logout.php" class="admin-btn btn-danger">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="admin-container">
        <?php if ($message): ?>
            <div class="message-alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="stats">
            <div class="stat-card">
                <h3><?php echo count($messages); ?></h3>
                <p>Messages reçus</p>
            </div>
            <div class="stat-card">
                <h3><?php echo count(array_filter($messages, function($m) { return isset($m['lu']) && $m['lu'] == 0; })); ?></h3>
                <p>Non lus</p>
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
                <div class="message-item" style="<?php echo (isset($msg['lu']) && $msg['lu'] == 0) ? 'background: #fff3cd; border-left: 4px solid #ffc107;' : ''; ?>">
                    <div class="message-header">
                        <div class="message-info">
                            <div class="message-name">
                                <?php echo htmlspecialchars($msg['nom']); ?>
                                <?php if (isset($msg['lu']) && $msg['lu'] == 0): ?>
                                    <span style="background: #ffc107; color: #000; padding: 2px 8px; border-radius: 3px; font-size: 0.8rem; margin-left: 10px;">Non lu</span>
                                <?php endif; ?>
                            </div>
                            <div class="message-email"><?php echo htmlspecialchars($msg['email']); ?></div>
                        </div>
                        <div class="message-date"><?php echo date('d/m/Y H:i', strtotime($msg['date_creation'])); ?></div>
                    </div>
                    <div class="message-content">
                        <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                    </div>
                    <div>
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo urlencode($msg['email']); ?>&su=<?php echo urlencode('Re: Votre message'); ?>&body=<?php echo urlencode('Bonjour ' . $msg['nom'] . ',\n\n'); ?>" target="_blank" class="admin-btn btn-success">Répondre via Gmail</a>
                        <?php if (isset($msg['lu']) && $msg['lu'] == 0): ?>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="action" value="mark_read">
                            <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                            <button type="submit" class="admin-btn">Marquer comme lu</button>
                        </form>
                        <?php endif; ?>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                            <button type="submit" class="admin-btn btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
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