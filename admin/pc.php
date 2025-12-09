<?php
// Inclusion du fichier de configuration (connexion BDD + session)
require_once '../config.php';

// Vérification de l'authentification admin
// Si la session 'admin_logged' n'existe pas ou est fausse, redirection vers la page d'accueil
if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: index.php');
    exit; // Arrêt du script après redirection
}

// Bloc try pour gérer les erreurs de base de données
try {
    // Requête SQL pour récupérer tous les PC triés par prix croissant
    $stmt = $pdo->query("SELECT * FROM pcs ORDER BY prix ASC");
    // Récupération de tous les résultats sous forme de tableau associatif
    $pcs = $stmt->fetchAll();
    
    // Initialisation d'un tableau vide pour stocker les périphériques par PC
    $peripheriques_by_pc = [];
    
    // Bloc try pour gérer les erreurs spécifiques aux périphériques
    try {
        // Boucle sur chaque PC récupéré
        foreach ($pcs as $pc) {
            // Préparation d'une requête paramétrée pour éviter les injections SQL
            // JOIN entre peripheriques et pc_peripheriques pour récupérer les périphériques d'un PC
            $stmt = $pdo->prepare("
                SELECT p.nom, p.type 
                FROM peripheriques p 
                JOIN pc_peripheriques pp ON p.id = pp.peripherique_id 
                WHERE pp.pc_id = ?
                ORDER BY p.type, p.nom
            ");
            // Exécution de la requête avec l'ID du PC comme paramètre
            $stmt->execute([$pc['id']]);
            // Stockage des périphériques dans le tableau indexé par nom de PC
            $peripheriques_by_pc[$pc['nom']] = $stmt->fetchAll();
        }
    } catch(Exception $e) {
        // En cas d'erreur (table inexistante), initialiser un tableau vide
        $peripheriques_by_pc = [];
    }
    
} catch(Exception $e) {
    // En cas d'erreur globale, initialiser des tableaux vides
    $pcs = [];
    $peripheriques_by_pc = [];
}
?>
<!DOCTYPE html>
<!-- Déclaration du type de document HTML5 -->
<html lang="fr">
<!-- Langue du document en français -->
<head>
    <!-- Encodage des caractères en UTF-8 pour supporter les accents -->
    <meta charset="UTF-8">
    <!-- Configuration responsive pour mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Titre affiché dans l'onglet du navigateur -->
    <title>Parc Informatique - TechSolutions</title>
    <!-- Lien vers la feuille de style CSS -->
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <!-- Balise body : contient tout le contenu visible de la page -->
    <!-- En-tête de la page admin -->
    <header class="admin-header">
        <!-- Balise header avec classe CSS pour le style de l'en-tête admin -->
        <div class="container">
            <!-- Conteneur pour centrer et limiter la largeur du contenu -->
            <!-- Titre de la page -->
            <h2>Parc Informatique</h2>
            <!-- Titre de niveau 2 affiché dans l'en-tête -->
            <div>
                <!-- Div pour regrouper les boutons de navigation -->
                <!-- Bouton de retour au dashboard -->
                <a href="dashboard.php" class="admin-btn">Retour Dashboard</a>
                <!-- Lien hypertexte vers dashboard.php avec classe CSS admin-btn -->
                <!-- Bouton de déconnexion -->
                <a href="logout.php" class="admin-btn">Déconnexion</a>
                <!-- Lien hypertexte vers logout.php pour terminer la session -->
            </div>
            <!-- Fin du div des boutons -->
        </div>
        <!-- Fin du conteneur -->
    </header>
    <!-- Fin de l'en-tête -->

    <section class="section">
        <!-- Section principale avec classe CSS pour le style -->
        <div class="container">
            <!-- Conteneur pour centrer le contenu -->
            <h1>Parc Informatique</h1>
            <!-- Titre principal de niveau 1 -->
            <p style="text-align: center; margin-bottom: 2rem; color: #666;">Gestion du parc informatique de l'entreprise par poste de travail</p>
            <!-- Paragraphe descriptif avec style inline : centré, marge basse 2rem, couleur grise -->
            <div class="pc-grid">
                <!-- Div avec classe pc-grid pour afficher les PC en grille CSS -->
                <?php if ($pcs): ?>
                    <!-- Condition PHP : si le tableau $pcs contient des données -->
                    <?php foreach ($pcs as $pc): ?>
                        <!-- Boucle foreach : parcourt chaque PC du tableau $pcs -->
                    <div class="pc-card">
                        <!-- Carte individuelle pour chaque PC avec classe CSS -->
                        <h3><?php echo htmlspecialchars($pc['nom']); ?></h3>
                        <!-- Titre niveau 3 : affiche le nom du PC avec échappement HTML pour sécurité -->
                        <div class="components">
                            <!-- Div pour regrouper les composants et périphériques -->
                            <strong>Composants:</strong>
                            <!-- Texte en gras pour le titre de la section composants -->
                            <ul>
                                <!-- Liste non ordonnée pour afficher les composants -->
                                <?php 
                                // Début du bloc PHP pour récupérer les composants
                                try {
                                    // Bloc try pour gérer les erreurs SQL
                                    $stmt = $pdo->prepare("
                                        SELECT c.nom, c.type 
                                        FROM components c 
                                        JOIN pc_components pc ON c.id = pc.component_id 
                                        WHERE pc.pc_id = ?
                                        ORDER BY c.type, c.nom
                                    ");
                                    // Préparation de la requête SQL avec paramètre pour éviter injection SQL
                                    // JOIN entre components et pc_components pour récupérer les composants du PC
                                    // Tri par type puis nom
                                    $stmt->execute([$pc['id']]);
                                    // Exécution de la requête avec l'ID du PC actuel
                                    $composants = $stmt->fetchAll();
                                    // Récupération de tous les composants dans un tableau
                                    
                                    if ($composants):
                                        // Condition : si des composants ont été trouvés
                                        foreach ($composants as $composant):
                                            // Boucle sur chaque composant
                                ?>
                                <li><?php echo htmlspecialchars($composant['type'] . ': ' . $composant['nom']); ?></li>
                                <!-- Élément de liste : affiche "Type: Nom" avec échappement HTML -->
                                <?php 
                                        endforeach;
                                        // Fin de la boucle foreach
                                    else:
                                        // Sinon (aucun composant trouvé)
                                ?>
                                <li>Aucun composant assigné</li>
                                <!-- Message si aucun composant n'est associé au PC -->
                                <?php 
                                    endif;
                                    // Fin de la condition if
                                } catch(Exception $e) {
                                    // Bloc catch : capture les erreurs SQL
                                ?>
                                <li>Erreur de chargement</li>
                                <!-- Message d'erreur si la requête échoue -->
                                <?php } ?>
                                <!-- Fin du bloc try-catch -->
                            </ul>
                            <!-- Fin de la liste des composants -->
                            
                            
                            <strong>Périphériques:</strong>
                            <!-- Texte en gras pour le titre de la section périphériques -->
                            <ul>
                                <!-- Liste non ordonnée pour afficher les périphériques -->
                                <?php 
                                // Début du bloc PHP pour récupérer les périphériques
                                try {
                                    // Bloc try pour gérer les erreurs SQL
                                    $stmt = $pdo->prepare("
                                        SELECT p.nom, p.type 
                                        FROM peripheriques p 
                                        JOIN pc_peripheriques pp ON p.id = pp.peripherique_id 
                                        WHERE pp.pc_id = ?
                                        ORDER BY p.type, p.nom
                                    ");
                                    // Préparation de la requête SQL avec paramètre
                                    // JOIN entre peripheriques et pc_peripheriques pour récupérer les périphériques du PC
                                    // Tri par type puis nom
                                    $stmt->execute([$pc['id']]);
                                    // Exécution de la requête avec l'ID du PC actuel
                                    $periphs = $stmt->fetchAll();
                                    // Récupération de tous les périphériques dans un tableau
                                    
                                    if ($periphs):
                                        // Condition : si des périphériques ont été trouvés
                                        foreach ($periphs as $periph):
                                            // Boucle sur chaque périphérique
                                            $display = !empty($periph['type']) ? $periph['type'] . ': ' . $periph['nom'] : $periph['nom'];
                                            // Opérateur ternaire : si type existe, affiche "Type: Nom", sinon juste le nom
                                ?>
                                <li><?php echo htmlspecialchars($display); ?></li>
                                <!-- Élément de liste : affiche le périphérique avec échappement HTML -->
                                <?php 
                                        endforeach;
                                        // Fin de la boucle foreach
                                    else:
                                        // Sinon (aucun périphérique trouvé)
                                ?>
                                <li>Aucun périphérique assigné</li>
                                <!-- Message si aucun périphérique n'est associé au PC -->
                                <?php 
                                    endif;
                                    // Fin de la condition if
                                } catch(Exception $e) {
                                    // Bloc catch : capture les erreurs SQL
                                ?>
                                <li>Erreur de chargement</li>
                                <!-- Message d'erreur si la requête échoue -->
                                <?php } ?>
                                <!-- Fin du bloc try-catch -->
                            </ul>
                            <!-- Fin de la liste des périphériques -->
                        </div>
                        <!-- Fin du div components -->
                    </div>
                    <!-- Fin de la carte PC -->
                    <?php endforeach; ?>
                    <!-- Fin de la boucle foreach des PC -->
                <?php else: ?>
                    <!-- Bloc else : si le tableau $pcs est vide -->
                    <div class="pc-card">
                        <!-- Carte pour afficher un message si aucun PC -->
                        <h3>Aucun PC disponible</h3>
                        <!-- Titre indiquant l'absence de PC -->
                        <p>Revenez bientôt pour découvrir nos nouveaux modèles !</p>
                        <!-- Message d'information pour l'utilisateur -->
                    </div>
                    <!-- Fin de la carte -->
                <?php endif; ?>
                <!-- Fin de la condition if ($pcs) -->
            </div>
            <!-- Fin du div pc-grid -->
        </div>
        <!-- Fin du conteneur -->
    </section>
    <!-- Fin de la section principale -->






    <footer>
        <!-- Pied de page du site -->
        <div class="container">
            <!-- Conteneur pour centrer le contenu du footer -->
            <p>&copy; 2024 TechSolutions. Tous droits réservés.</p>
            <!-- Paragraphe avec copyright et symbole © (entité HTML &copy;) -->
        </div>
        <!-- Fin du conteneur -->
    </footer>
    <!-- Fin du pied de page -->
</body>
<!-- Fin du body -->
</html>
<!-- Fin du document HTML -->