<?php
// Balise d'ouverture PHP
require_once '../config.php';
// Inclusion du fichier de configuration (connexion BDD + session)
// ../ remonte d'un niveau dans l'arborescence (depuis admin/ vers racine)

$error = '';
// Initialisation de la variable d'erreur (vide par défaut)

if ($_POST) {
    // Condition : vérifie si le formulaire a été soumis en POST
    $username = trim($_POST['username']);
    // Récupère le nom d'utilisateur et supprime les espaces
    $password = trim($_POST['password']);
    // Récupère le mot de passe et supprime les espaces
    
    try {
        // Bloc try pour gérer les erreurs de base de données
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged'] = true;
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_role'] = $user['role'];
            header('Location: dashboard.php');
            exit;
        } else {
            // Sinon (utilisateur inexistant ou mot de passe incorrect)
            $error = "Identifiants incorrects";
            // Message d'erreur générique (sécurité : ne pas préciser si c'est le login ou le mot de passe)
        }
    } catch(Exception $e) {
        // Bloc catch : capture les erreurs SQL
        $error = "Erreur de connexion";
        // Message d'erreur générique
    }
}
?>
<!DOCTYPE html>
<!-- Déclaration HTML5 -->
<html lang="fr">
<!-- Langue française -->
<head>
    <!-- En-tête du document -->
    <meta charset="UTF-8">
    <!-- Encodage UTF-8 -->
    <title>Connexion Admin - TechSolutions</title>
    <!-- Titre de la page -->
    <style>
        /* Styles CSS inline pour la page de connexion */
        /* Style du body : police Arial, fond gris, flexbox centré, hauteur minimale 100vh (100% de la hauteur de la fenêtre) */
        body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        /* Boîte de connexion : fond blanc, padding 2rem, coins arrondis 8px, ombre portée, largeur 300px */
        .login-box { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 300px; }
        /* Titre h1 dans la boîte : centré, marge basse 1.5rem, couleur gris foncé */
        .login-box h1 { text-align: center; margin-bottom: 1.5rem; color: #333; }
        /* Groupe de champ : marge basse 1rem */
        .form-group { margin-bottom: 1rem; }
        /* Label : affichage en bloc, marge basse 0.5rem */
        .form-group label { display: block; margin-bottom: 0.5rem; }
        /* Input : largeur 100%, padding 0.8rem, bordure grise, coins arrondis, box-sizing pour inclure padding dans la largeur */
        .form-group input { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        /* Bouton : largeur 100%, padding 0.8rem, fond bleu, texte blanc, pas de bordure, coins arrondis, curseur pointeur */
        .btn { width: 100%; padding: 0.8rem; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        /* Bouton au survol : fond bleu plus foncé */
        .btn:hover { background: #0056b3; }
        /* Message d'erreur : texte rouge, centré, marge basse 1rem */
        .error { color: red; text-align: center; margin-bottom: 1rem; }
        /* Lien de retour : centré, marge haute 1rem */
        .back-link { text-align: center; margin-top: 1rem; }
    </style>
    <!-- Fin des styles -->
</head>
<body>
    <!-- Corps du document -->
    <div class="login-box">
        <!-- Boîte de connexion -->
        <h1>Admin TechSolutions</h1>
        <!-- Titre de la page de connexion -->
        <?php if ($error): ?>
            <!-- Condition PHP : si une erreur existe -->
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <!-- Affichage du message d'erreur avec échappement HTML -->
        <?php endif; ?>
        <!-- Fin de la condition -->
        
        <form method="post">
            <!-- Formulaire de connexion avec méthode POST -->
            <div class="form-group">
                <!-- Groupe pour le champ username -->
                <label>Nom d'utilisateur</label>
                <!-- Étiquette du champ -->
                <input type="text" name="username" required>
                <!-- Champ texte obligatoire pour le nom d'utilisateur -->
            </div>
            <div class="form-group">
                <!-- Groupe pour le champ password -->
                <label>Mot de passe</label>
                <!-- Étiquette du champ -->
                <input type="password" name="password" required>
                <!-- Champ mot de passe (masqué) obligatoire -->
            </div>
            <button type="submit" class="btn">Se connecter</button>
            <!-- Bouton de soumission du formulaire -->
        </form>
        <!-- Fin du formulaire -->
        
        <p class="back-link">
            <!-- Paragraphe pour le lien de retour -->
            <a href="../index.php">← Retour au site</a>
            <!-- Lien vers la page d'accueil avec flèche gauche (←) -->
        </p>
    </div><?php // Fin de la boîte de connexion ?>
</body><?php // Fin du body ?>
</html>