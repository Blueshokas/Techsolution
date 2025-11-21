<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

// Statistiques
try {
    $stats_pc = $pdo->query("SELECT COUNT(*) FROM pcs")->fetchColumn();
    $stats_messages = $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
    $stats_actualites = $pdo->query("SELECT COUNT(*) FROM actualites")->fetchColumn();
} catch(Exception $e) {
    $stats_pc = $stats_messages = $stats_actualites = 0;
}
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h2>Dashboard Admin</h2>
            <div>
                <span>Bienvenue, <?php echo $_SESSION['admin_username']; ?></span>
                <a href="logout.php" class="admin-btn btn-danger" style="margin-left: 1rem;">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="admin-container">
        <div class="welcome">
            <h1>🎉 Bienvenue dans l'espace d'administration !</h1>
            <p>Vous êtes connecté en tant qu'administrateur de TechSolutions.</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <h3><?php echo $stats_pc; ?></h3>
                <p>PC dans le parc</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $stats_messages; ?></h3>
                <p>Messages reçus</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $stats_actualites; ?></h3>
                <p>Actualités publiées</p>
            </div>
        </div>

        <div class="actions">
            <div class="action-card">
                <h3>Parc Informatique</h3>
                <p>Gérer les PC du parc informatique de l'entreprise.</p>
                <a href="pc_admin.php" class="admin-btn">Gérer le parc</a>
            </div>
            <div class="action-card">
                <h3>Messages clients</h3>
                <p>Consulter et répondre aux messages des clients.</p>
                <a href="messages.php" class="admin-btn">Voir les messages</a>
            </div>
            <div class="action-card">
                <h3>Actualités</h3>
                <p>Ajouter et gérer les actualités de l'entreprise.</p>
                <a href="actualites_admin.php" class="admin-btn">Gérer les actualités</a>
            </div>
            <div class="action-card">
                <h3>Sécurité</h3>
                <p>Changer votre mot de passe administrateur.</p>
                <a href="change_password.php" class="admin-btn">Changer mot de passe</a>
            </div>
            <div class="action-card">
                <h3>Utilisateurs</h3>
                <p>Créer de nouveaux comptes administrateur.</p>
                <a href="./add_user.php" class="admin-btn">Créer utilisateur</a>
            </div>
            <div class="action-card">
                <h3>Retour au site</h3>
                <p>Revenir à la page principale du site.</p>
                <a href="../index.php" class="admin-btn">Aller au site</a>
            </div>
            <div class="action-card">
                <h3>Parc info</h3>
                <p>Acceder au parc Informatique</p>
                <a href="pc.php" class="admin-btn">Acceder au parc</a>
            </div>

        </div>
    </div>
</body>
</html>