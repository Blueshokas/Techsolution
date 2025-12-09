<?php
// Balise d'ouverture PHP
require_once '../config.php';
// Inclusion du fichier de configuration

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    // Vérification de l'authentification admin
    header('Location: login.php');
    // Redirection si non connecté
    exit;
    // Arrêt du script
}

$message = '';
// Initialisation de la variable message

// Gestion des actions
if ($_POST) {
    // Vérifie si le formulaire a été soumis
    if ($_POST['action'] === 'add_component') {
        // Action : ajouter un composant
        $nom = trim($_POST['nom']);
        // Récupère le nom du composant
        $type = trim($_POST['type']);
        // Récupère le type (CPU, RAM, etc.)
        $marque = trim($_POST['marque']);
        // Récupère la marque (optionnel)
        
        if ($nom && $type) {
            // Vérifie que les champs obligatoires sont remplis
            try {
                // Bloc try pour gérer les erreurs
                $stmt = $pdo->prepare("INSERT INTO components (nom, type, marque) VALUES (?, ?, ?)");
                // Préparation de la requête d'insertion
                $stmt->execute([$nom, $type, $marque]);
                // Exécution avec les valeurs
                $message = "Composant ajouté !";
                // Message de succès
            } catch(Exception $e) {
                // Capture les erreurs
                $message = "Erreur : " . $e->getMessage();
                // Message d'erreur avec détails
            }
        }
    } elseif ($_POST['action'] === 'delete_component') {
        // Action : supprimer un composant
        $id = (int)$_POST['id'];
        // Récupère l'ID et le convertit en entier pour sécurité
        try {
            // Bloc try
            $stmt = $pdo->prepare("DELETE FROM components WHERE id = ?");
            // Préparation de la requête de suppression
            $stmt->execute([$id]);
            // Exécution avec l'ID
            $message = "Composant supprimé !";
            // Message de succès
        } catch(Exception $e) {
            // Capture les erreurs
            $message = "Erreur : " . $e->getMessage();
            // Message d'erreur
        }
    }
}

// Récupérer tous les composants
try {
    // Bloc try
    $components = $pdo->query("SELECT * FROM components ORDER BY type, nom")->fetchAll();
    // Requête pour récupérer tous les composants triés par type puis nom
} catch(Exception $e) {
    // Capture les erreurs
    $components = [];
    // Tableau vide si erreur
}
?>
<!DOCTYPE html>
<!-- Déclaration HTML5 -->
<html lang="fr" class="admin-page">
<!-- Langue française avec classe admin-page -->
<head>
    <!-- En-tête -->
    <meta charset="UTF-8">
    <!-- Encodage UTF-8 -->
    <title>Gestion Composants - TechSolutions</title>
    <!-- Titre -->
    <link rel="stylesheet" href="../assets/style.css">
    <!-- Lien CSS -->
</head>
<body>
    <!-- Corps -->
    <header class="admin-header">
        <!-- En-tête admin -->
        <div class="container">
            <!-- Conteneur -->
            <h1>Gestion des Composants</h1>
            <!-- Titre principal -->
            <div>
                <!-- Conteneur boutons -->
                <a href="dashboard.php" class="admin-btn">← Dashboard</a>
                <!-- Bouton retour dashboard -->
                <a href="logout.php" class="admin-btn btn-danger">Déconnexion</a>
                <!-- Bouton déconnexion -->
            </div>
        </div>
    </header>
    <!-- Fin en-tête -->


    <div class="admin-container">
        <!-- Conteneur principal admin -->
        <?php if ($message): ?>
            <!-- Si un message existe -->
            <div class="admin-message"><?php echo htmlspecialchars($message); ?></div>
            <!-- Affichage du message avec échappement HTML -->
        <?php endif; ?>
        <!-- Fin condition -->

        <div class="form-section">
            <!-- Section formulaire -->
            <h2>Ajouter un composant</h2>
            <!-- Titre section -->
            <form method="post">
                <!-- Formulaire POST -->
                <input type="hidden" name="action" value="add_component">
                <!-- Champ caché pour identifier l'action -->
                <div class="admin-form-group">
                    <!-- Groupe de champ -->
                    <label for="type">Type *</label>
                    <!-- Étiquette -->
                    <select id="type" name="type" required>
                        <!-- Liste déroulante obligatoire -->
                        <option value="">Sélectionner un type</option>
                        <!-- Option par défaut vide -->
                        <optgroup label="Composants PC">
                            <!-- Groupe d'options : Composants PC -->
                            <option value="CPU">CPU (Processeur)</option>
                            <!-- Option CPU -->
                            <option value="Carte Mère">Carte Mère</option>
                            <option value="RAM">RAM (Mémoire)</option>
                            <option value="SSD">SSD</option>
                            <option value="HDD">HDD (Disque dur)</option>
                            <option value="GPU">GPU (Carte graphique)</option>
                            <option value="Alimentation">Alimentation</option>
                            <option value="Refroidissement">Refroidissement</option>
                            <option value="Boîtier">Boîtier</option>
                            <option value="Ventilateur">Ventilateur</option>
                        </optgroup>
                        <optgroup label="Périphériques">
                            <option value="Écran">Écran</option>
                            <option value="Clavier">Clavier</option>
                            <option value="Souris">Souris</option>
                            <option value="Tapis de souris">Tapis de souris</option>
                            <option value="Casque Audio">Casque Audio</option>
                            <option value="Webcam">Webcam</option>
                            <option value="Tablette Graphique">Tablette Graphique</option>
                            <option value="Colorimètre">Colorimètre</option>
                            <option value="Scanner">Scanner</option>
                        </optgroup>
                        <optgroup label="Mobilité & Protection">
                            <option value="Ordinateur Portable">Ordinateur Portable</option>
                            <option value="Sacoche">Sacoche</option>
                            <option value="Onduleur">Onduleur</option>
                        </optgroup>
                        <optgroup label="Autre">
                            <option value="Autre">Autre</option>
                        </optgroup>
                    </select>
                </div>
                <div class="admin-form-group">
                    <!-- Groupe nom -->
                    <label for="nom">Nom du composant *</label>
                    <!-- Étiquette -->
                    <input type="text" id="nom" name="nom" required>
                    <!-- Champ texte obligatoire -->
                </div>
                <div class="admin-form-group">
                    <!-- Groupe marque -->
                    <label for="marque">Marque</label>
                    <!-- Étiquette -->
                    <input type="text" id="marque" name="marque">
                    <!-- Champ texte optionnel -->
                </div>
                <button type="submit" class="admin-btn">Ajouter</button>
                <!-- Bouton de soumission -->
            </form>
            <!-- Fin formulaire -->
        </div>
        <!-- Fin form-section -->


        <div class="pc-list">
            <!-- Section liste des composants -->
            <h2>Composants disponibles</h2>
            <!-- Titre section -->
            <?php if ($components): ?>
                <!-- Si des composants existent -->
                <?php 
                // Début bloc PHP
                $current_type = '';
                // Variable pour suivre le type actuel (pour regroupement)
                foreach ($components as $component): 
                    // Boucle sur chaque composant
                    if ($current_type !== $component['type']):
                        // Si le type change (nouveau groupe)
                        if ($current_type !== '') echo '</div>';
                        // Ferme le div du groupe précédent (sauf pour le premier)
                        $current_type = $component['type'];
                        // Met à jour le type actuel
                        echo '<h3 style="margin-top: 2rem; color: #007bff;">' . htmlspecialchars($current_type) . '</h3>';
                        // Affiche le titre du groupe (type) en bleu
                        echo '<div style="margin-left: 1rem;">';
                        // Ouvre un div avec indentation pour les composants du groupe
                    endif;
                    // Fin condition
                ?>
                <div class="pc-item" style="grid-template-columns: 2fr 1fr 1fr;">
                    <!-- Item composant avec grille 3 colonnes (2fr 1fr 1fr) -->
                    <div>
                        <!-- Colonne 1 : nom et marque -->
                        <div class="pc-name"><?php echo htmlspecialchars($component['nom']); ?></div>
                        <!-- Nom du composant -->
                        <?php if ($component['marque']): ?>
                            <!-- Si une marque existe -->
                            <div style="font-size: 0.9rem; color: #666;">Marque: <?php echo htmlspecialchars($component['marque']); ?></div>
                            <!-- Affichage de la marque en gris -->
                        <?php endif; ?>
                        <!-- Fin condition -->
                    </div>
                    <div><?php echo htmlspecialchars($component['type']); ?></div>
                    <!-- Colonne 2 : type -->
                    <div>
                        <!-- Colonne 3 : actions -->
                        <form method="post" style="display: inline;">
                            <!-- Formulaire inline pour la suppression -->
                            <input type="hidden" name="action" value="delete_component">
                            <!-- Action : delete_component -->
                            <input type="hidden" name="id" value="<?php echo $component['id']; ?>">
                            <!-- ID du composant à supprimer -->
                            <button type="submit" class="admin-btn btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
                            <!-- Bouton suppression avec confirmation JavaScript -->
                        </form>
                    </div>
                </div>
                <!-- Fin item -->
                <?php endforeach; ?>
                <!-- Fin boucle -->
                </div>
                <!-- Ferme le dernier groupe -->
            <?php else: ?>
                <!-- Sinon (aucun composant) -->
                <p>Aucun composant.</p>
                <!-- Message -->
            <?php endif; ?>
            <!-- Fin condition -->
        </div>
        <!-- Fin pc-list -->
    </div>
    <!-- Fin admin-container -->
</body>
<!-- Fin body -->
</html>
<!-- Fin HTML -->