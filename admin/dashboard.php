<?php
// Balise d'ouverture PHP
require_once '../config.php';
// Inclusion du fichier de configuration (connexion BDD + session)

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    // Condition : vérifie si l'admin n'est PAS connecté
    // !isset() = la variable n'existe pas OU !$_SESSION['admin_logged'] = la variable est false
    header('Location: login.php');
    // Redirection vers la page de connexion si non authentifié
    exit;
    // Arrêt du script
}

// Statistiques
try {
    // Bloc try pour gérer les erreurs SQL
    $stats_pc = $pdo->query("SELECT COUNT(*) FROM pcs")->fetchColumn();
    // Requête SQL : compte le nombre de PC dans la table pcs
    // fetchColumn() récupère directement la valeur de la première colonne
    $stats_messages = $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
    // Compte le nombre de messages dans la table contacts
    $stats_actualites = $pdo->query("SELECT COUNT(*) FROM actualites")->fetchColumn();
    // Compte le nombre d'actualités dans la table actualites
} catch(Exception $e) {
    // Bloc catch : en cas d'erreur SQL
    $stats_pc = $stats_messages = $stats_actualites = 0;
    // Initialise toutes les statistiques à 0
}
?>
<!DOCTYPE html>
<!-- Déclaration HTML5 -->
<html lang="fr" class="admin-page">
<!-- Langue française avec classe admin-page pour styles spécifiques -->
<head>
    <!-- En-tête du document -->
    <meta charset="UTF-8">
    <!-- Encodage UTF-8 -->
    <title>Dashboard Admin - TechSolutions</title>
    <!-- Titre de la page -->
    <link rel="stylesheet" href="../assets/style.css">
    <!-- Lien vers la feuille de style -->
</head>
<body>
    <!-- Corps du document -->
    <header class="admin-header">
        <!-- En-tête admin avec classe CSS -->
        <div class="container">
            <!-- Conteneur -->
            <h2>Dashboard Admin</h2>
            <!-- Titre du dashboard -->
            <div>
                <!-- Conteneur pour le message de bienvenue et le bouton -->
                <span>Bienvenue, <?php echo $_SESSION['admin_username']; ?></span>
                <!-- Affiche le nom d'utilisateur stocké en session -->
                <a href="logout.php" class="admin-btn btn-danger" style="margin-left: 1rem;">Déconnexion</a>
                <!-- Bouton de déconnexion avec marge gauche 1rem -->
            </div>
        </div>
        <!-- Fin conteneur -->
    </header>
    <!-- Fin en-tête -->


    <div class="admin-container">
        <!-- Conteneur principal de l'interface admin -->
        <div class="welcome">
            <!-- Section de bienvenue -->
            <h1>🎉 Bienvenue dans l'espace d'administration !</h1>
            <!-- Titre avec emoji fête -->
            <p>Vous êtes connecté en tant qu'administrateur de TechSolutions.</p>
            <!-- Message de confirmation -->
        </div>
        <!-- Fin section bienvenue -->

        <div class="stats">
            <!-- Conteneur pour les statistiques (grille 3 colonnes) -->
            <div class="stat-card">
                <!-- Carte statistique PC -->
                <h3><?php echo $stats_pc; ?></h3>
                <!-- Affiche le nombre de PC -->
                <p>PC dans le parc</p>
                <!-- Libellé -->
            </div>
            <div class="stat-card">
                <!-- Carte statistique messages -->
                <h3><?php echo $stats_messages; ?></h3>
                <!-- Affiche le nombre de messages -->
                <p>Messages reçus</p>
                <!-- Libellé -->
            </div>
            <div class="stat-card">
                <!-- Carte statistique actualités -->
                <h3><?php echo $stats_actualites; ?></h3>
                <!-- Affiche le nombre d'actualités -->
                <p>Actualités publiées</p>
                <!-- Libellé -->
            </div>
        </div>
        <!-- Fin stats -->


        <div class="actions">
            <!-- Conteneur pour les cartes d'action (grille responsive) -->
            <div class="action-card">
                <!-- Carte : Parc Informatique -->
                <h3>Parc Informatique</h3>
                <!-- Titre de la carte -->
                <p>Gérer les PC du parc informatique de l'entreprise.</p>
                <!-- Description -->
                <a href="pc_admin.php" class="admin-btn">Gérer le parc</a>
                <!-- Bouton vers la gestion des PC -->
            </div>
            <div class="action-card">
                <!-- Carte : Composants -->
                <h3>Composants</h3>
                <p>Gérer les composants disponibles.</p>
                <a href="components_admin.php" class="admin-btn">Gérer composants</a>
                <!-- Bouton vers la gestion des composants -->
            </div>

            <div class="action-card">
                <!-- Carte : Configurations PC -->
                <h3>Configurations PC</h3>
                <p>Gérer composants et périphériques des PC.</p>
                <a href="pc_components_admin.php" class="admin-btn">Gérer composants</a>
                <!-- Bouton vers l'association PC-Composants -->
                <a href="pc_peripheriques_admin.php" class="admin-btn" style="margin-top: 0.5rem;">Gérer périphériques</a>
                <!-- Bouton vers l'association PC-Périphériques avec marge haute -->
            </div>
            <div class="action-card">
                <!-- Carte : Messages clients -->
                <h3>Messages clients</h3>
                <p>Consulter et répondre aux messages des clients.</p>
                <a href="messages.php" class="admin-btn">Voir les messages</a>
                <!-- Bouton vers la gestion des messages -->
            </div>
            <div class="action-card">
                <!-- Carte : Actualités -->
                <h3>Actualités</h3>
                <p>Ajouter et gérer les actualités de l'entreprise.</p>
                <a href="actualites_admin.php" class="admin-btn">Gérer les actualités</a>
                <!-- Bouton vers la gestion des actualités -->
            </div>
            <div class="action-card">
                <!-- Carte : Sécurité -->
                <h3>Sécurité</h3>
                <p>Changer votre mot de passe administrateur.</p>
                <a href="change_password.php" class="admin-btn">Changer mot de passe</a>
                <!-- Bouton vers le changement de mot de passe -->
            </div>
            <div class="action-card">
                <!-- Carte : Utilisateurs -->
                <h3>Utilisateurs</h3>
                <p>Gérer les comptes administrateur.</p>
                <a href="users_admin.php" class="admin-btn">Gérer utilisateurs</a>
                <!-- Bouton vers la gestion des utilisateurs -->
            </div>
            <div class="action-card">
                <!-- Carte : Retour au site -->
                <h3>Retour au site</h3>
                <p>Revenir à la page principale du site.</p>
                <a href="../index.php" class="admin-btn">Aller au site</a>
                <!-- Bouton vers la page d'accueil publique -->
            </div>
            <div class="action-card">
                <!-- Carte : Parc info -->
                <h3>Parc info</h3>
                <p>Acceder au parc Informatique</p>
                <a href="pc.php" class="admin-btn">Acceder au parc</a>
                <!-- Bouton vers la visualisation du parc informatique -->
            </div>

        </div><?php // Fin actions ?>
    </div><?php // Fin admin-container ?>
</body><?php // Fin body ?>
</html>