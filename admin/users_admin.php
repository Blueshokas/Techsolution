<?php
// Inclusion du fichier de configuration
require_once '../config.php';

// Vérification de l'authentification admin
if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

// Gestion des actions
if ($_POST) {
    if ($_POST['action'] === 'add_user') {
        // Action : ajouter un utilisateur
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if ($username && $password) {
            try {
                // Vérifier si l'utilisateur existe déjà
                $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
                $stmt->execute([$username]);
                
                if ($stmt->fetch()) {
                    $message = "Cet utilisateur existe déjà";
                } else {
                    // Hasher le mot de passe
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    // Insérer le nouvel utilisateur
                    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                    $stmt->execute([$username, $hashedPassword]);
                    $message = "Utilisateur créé avec succès !";
                }
            } catch(Exception $e) {
                $message = "Erreur : " . $e->getMessage();
            }
        }
    } elseif ($_POST['action'] === 'delete_user') {
        // Action : supprimer un utilisateur
        $id = (int)$_POST['id'];
        
        // Empêcher la suppression si c'est le seul utilisateur
        try {
            $count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
            
            if ($count <= 1) {
                $message = "Impossible de supprimer le dernier utilisateur !";
            } else {
                $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
                $stmt->execute([$id]);
                $message = "Utilisateur supprimé !";
            }
        } catch(Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}

// Récupérer tous les utilisateurs
try {
    $users = $pdo->query("SELECT * FROM users ORDER BY username")->fetchAll();
} catch(Exception $e) {
    $users = [];
}
?>
<!DOCTYPE html><?php // Déclaration HTML5 ?>
<html lang="fr" class="admin-page"><?php // Langue française ?>
<head>
    <meta charset="UTF-8"><?php // Encodage UTF-8 ?>
    <title>Gestion Utilisateurs - TechSolutions</title><?php // Titre ?>
    <link rel="stylesheet" href="../assets/style.css"><?php // Lien CSS ?>
</head>
<body><?php // Corps ?>
    <header class="admin-header"><?php // En-tête admin ?>
        <div class="container"><?php // Conteneur ?>
            <h1>Gestion des Utilisateurs</h1><?php // Titre principal ?>
            <div><?php // Conteneur boutons ?>
                <a href="dashboard.php" class="admin-btn">← Dashboard</a><?php // Bouton retour ?>
                <a href="logout.php" class="admin-btn btn-danger">Déconnexion</a><?php // Bouton déconnexion ?>
            </div>
        </div>
    </header><?php // Fin en-tête ?>

    <div class="admin-container"><?php // Conteneur principal admin ?>
        <?php if ($message): // Si un message existe ?>
            <div class="admin-message"><?php echo htmlspecialchars($message); ?></div><?php // Affichage du message ?>
        <?php endif; // Fin condition ?>

        <div class="form-section"><?php // Section formulaire ?>
            <h2>Ajouter un utilisateur</h2><?php // Titre section ?>
            <form method="post"><?php // Formulaire POST ?>
                <input type="hidden" name="action" value="add_user"><?php // Champ caché pour identifier l'action ?>
                <div class="admin-form-group"><?php // Groupe de champ ?>
                    <label for="username">Nom d'utilisateur *</label><?php // Étiquette ?>
                    <input type="text" id="username" name="username" required><?php // Champ texte obligatoire ?>
                </div>
                <div class="admin-form-group"><?php // Groupe mot de passe ?>
                    <label for="password">Mot de passe *</label><?php // Étiquette ?>
                    <input type="password" id="password" name="password" required><?php // Champ mot de passe obligatoire ?>
                </div>
                <button type="submit" class="admin-btn">Ajouter</button><?php // Bouton de soumission ?>
            </form><?php // Fin formulaire ?>
        </div><?php // Fin form-section ?>

        <div class="pc-list"><?php // Section liste des utilisateurs ?>
            <h2>Utilisateurs existants</h2><?php // Titre section ?>
            <?php if ($users): // Si des utilisateurs existent ?>
                <?php foreach ($users as $user): // Boucle sur chaque utilisateur ?>
                <div class="pc-item" style="grid-template-columns: 2fr 1fr;"><?php // Item utilisateur avec grille 2 colonnes ?>
                    <div><?php // Colonne 1 : nom ?>
                        <div class="pc-name"><?php echo htmlspecialchars($user['username']); ?></div><?php // Nom de l'utilisateur ?>
                    </div>
                    <div><?php // Colonne 2 : actions ?>
                        <form method="post" style="display: inline;"><?php // Formulaire inline pour la suppression ?>
                            <input type="hidden" name="action" value="delete_user"><?php // Action : delete_user ?>
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>"><?php // ID de l'utilisateur à supprimer ?>
                            <button type="submit" class="admin-btn btn-danger" onclick="return confirm('Supprimer cet utilisateur ?')"><?php // Bouton suppression avec confirmation JavaScript ?>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div><?php // Fin item ?>
                <?php endforeach; // Fin boucle ?>
            <?php else: // Sinon (aucun utilisateur) ?>
                <p>Aucun utilisateur.</p><?php // Message ?>
            <?php endif; // Fin condition ?>
        </div><?php // Fin pc-list ?>
    </div><?php // Fin admin-container ?>
</body><?php // Fin body ?>
</html>
