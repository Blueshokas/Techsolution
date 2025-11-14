<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

// Statistiques
try {
    $stats_pc = $pdo->query("SELECT COUNT(*) FROM pcs")->fetchColumn();
    $stats_composants = $pdo->query("SELECT COUNT(*) FROM components")->fetchColumn();
    $stats_messages = $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
    $stats_actualites = $pdo->query("SELECT COUNT(*) FROM actualites")->fetchColumn();
} catch(Exception $e) {
    $stats_pc = $stats_composants = $stats_messages = $stats_actualites = 0;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - TechSolutions</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f8f9fa; }
        .header { background: #343a40; color: white; padding: 1rem 0; }
        .header .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem 20px; }
        
        .welcome { background: white; padding: 3rem; border-radius: 8px; text-align: center; margin-bottom: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .welcome h1 { color: #28a745; margin-bottom: 1rem; font-size: 2.5rem; }
        
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: white; padding: 2rem; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stat-card h3 { font-size: 2rem; color: #007bff; margin-bottom: 0.5rem; }
        
        .actions { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; }
        .action-card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .action-card h3 { color: #333; margin-bottom: 1rem; }
        
        .btn { display: inline-block; padding: 0.8rem 1.5rem; background: #007bff; color: white; text-decoration: none; border-radius: 4px; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <h2>Dashboard Admin</h2>
            <div>
                <span>Bienvenue, <?php echo $_SESSION['admin_username']; ?></span>
                <a href="logout.php" class="btn btn-danger" style="margin-left: 1rem;">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="container">
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
                <h3><?php echo $stats_composants; ?></h3>
                <p>Composants</p>
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
                <a href="pc_admin.php" class="btn">Gérer le parc</a>
            </div>
            <div class="action-card">
                <h3>Messages clients</h3>
                <p>Consulter et répondre aux messages des clients.</p>
                <a href="messages.php" class="btn">Voir les messages</a>
            </div>
            <div class="action-card">
                <h3>Actualités</h3>
                <p>Ajouter et gérer les actualités de l'entreprise.</p>
                <a href="actualites_admin.php" class="btn">Gérer les actualités</a>
            </div>
            <div class="action-card">
                <h3>Sécurité</h3>
                <p>Changer votre mot de passe administrateur.</p>
                <a href="change_password.php" class="btn">Changer mot de passe</a>
            </div>
            <div class="action-card">
                <h3>Utilisateurs</h3>
                <p>Créer de nouveaux comptes administrateur.</p>
                <a href="../add_user.php" class="btn">Créer utilisateur</a>
            </div>
            <div class="action-card">
                <h3>Retour au site</h3>
                <p>Revenir à la page principale du site.</p>
                <a href="../index.php" class="btn">Aller au site</a>
            </div>
        </div>
    </div>
</body>
</html>