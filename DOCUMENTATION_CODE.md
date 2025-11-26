# Documentation Complète du Code - TechSolutionVF

## 📋 Table des matières
1. [Configuration](#configuration)
2. [Pages Publiques](#pages-publiques)
3. [Espace Administration](#espace-administration)
4. [Base de Données](#base-de-données)
5. [Sécurité](#sécurité)

---

## Configuration

### `config.php`
**Rôle** : Configuration centrale de l'application

```php
// Paramètres de connexion à la base de données
$host = 'localhost';
$dbname = 'techsolution';
$username = 'root';
$password = '';

// Connexion PDO avec gestion d'erreurs
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Démarrage de la session si non active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
```

**Fonctionnalités** :
- Connexion à MySQL via PDO
- Mode d'erreur en exception pour meilleure gestion
- Gestion automatique des sessions
- Charset UTF-8 pour les caractères spéciaux

---

## Pages Publiques

### `index.php`
**Rôle** : Page d'accueil du site

**Structure HTML** :
- Header avec navigation (Accueil, Actualités, Contact, Connexion)
- Section hero avec titre et CTA
- Présentation de l'entreprise
- Section services (Développement logiciel, Conseil)
- Footer avec mentions légales

**Éléments clés** :
```php
<nav>
    <a href="index.php">Accueil</a>
    <a href="actualites.php">Actualités</a>
    <a href="contact.php">Contact</a>
    <a href="admin/login.php">Connexion</a>
</nav>
```

---

### `actualites.php`
**Rôle** : Affichage des actualités publiées

**Code PHP** :
```php
// Récupération des actualités actives
try {
    $actualites = $pdo->query("SELECT * FROM actualites WHERE actif = 1 ORDER BY date_publication DESC")->fetchAll();
} catch(Exception $e) {
    $actualites = [];
}
```

**Affichage** :
```php
foreach ($actualites as $actu):
    echo htmlspecialchars($actu['titre']);
    echo date('d/m/Y', strtotime($actu['date_publication']));
    echo nl2br(htmlspecialchars($actu['contenu']));
endforeach;
```

**Fonctionnalités** :
- Requête SQL avec tri par date décroissante
- Protection XSS avec `htmlspecialchars()`
- Conversion des retours à la ligne avec `nl2br()`
- Gestion des erreurs avec try/catch

---

### `contact.php`
**Rôle** : Formulaire de contact avec conformité RGPD

**Traitement du formulaire** :
```php
if ($_POST) {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $message_text = trim($_POST['message']);
    
    // Vérification du consentement RGPD
    if ($nom && $email && $message_text && isset($_POST['rgpd_consent'])) {
        $stmt = $pdo->prepare("INSERT INTO contacts (nom, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $email, $message_text]);
        $message = "Votre message a été envoyé avec succès !";
    }
}
```

**Sécurité** :
- Requêtes préparées contre les injections SQL
- Validation des champs obligatoires
- Consentement RGPD obligatoire
- Nettoyage des données avec `trim()`

**Formulaire HTML** :
```html
<input type="text" name="nom" required>
<input type="email" name="email" required>
<textarea name="message" required></textarea>
<input type="checkbox" name="rgpd_consent" required>
```

---

### `rgpd.php`
**Rôle** : Politique de confidentialité

**Contenu** :
- Données collectées (nom, email, message)
- Utilisation des données
- Durée de conservation (3 ans)
- Droits des utilisateurs (accès, rectification, suppression)
- Coordonnées de contact

---

### `commande.php`
**Rôle** : Traitement des commandes de PC

**Logique** :
```php
if ($_POST && isset($_POST['pc_id'])) {
    $pc_id = (int)$_POST['pc_id'];
    
    // Vérifier disponibilité
    $stmt = $pdo->prepare("SELECT * FROM pc WHERE id = ? AND stock > 0");
    $stmt->execute([$pc_id]);
    $pc = $stmt->fetch();
    
    if ($pc) {
        // Décrémenter le stock
        $stmt = $pdo->prepare("UPDATE pc SET stock = stock - 1 WHERE id = ?");
        $stmt->execute([$pc_id]);
        $success = true;
    }
}
```

**Fonctionnalités** :
- Vérification du stock avant commande
- Décrémentation automatique du stock
- Messages de confirmation/erreur
- Redirection si accès direct

---

## Espace Administration

### `admin/login.php`
**Rôle** : Authentification des administrateurs

**Processus de connexion** :
```php
if ($_POST) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Récupération de l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    // Vérification du mot de passe hashé
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged'] = true;
        $_SESSION['admin_username'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    }
}
```

**Sécurité** :
- Mots de passe hashés avec `password_hash()`
- Vérification avec `password_verify()`
- Sessions pour maintenir l'authentification
- Protection contre les injections SQL

---

### `admin/auth_check.php`
**Rôle** : Vérification de l'authentification

```php
session_start();

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: login.php');
    exit;
}
```

**Usage** : Inclus en début de chaque page admin pour protéger l'accès

---

### `admin/logout.php`
**Rôle** : Déconnexion

```php
session_start();
session_destroy();
header('Location: ../index.php');
exit;
```

**Fonctionnalités** :
- Destruction de la session
- Redirection vers la page d'accueil

---

### `admin/dashboard.php`
**Rôle** : Tableau de bord administrateur

**Statistiques** :
```php
$stats_pc = $pdo->query("SELECT COUNT(*) FROM pcs")->fetchColumn();
$stats_messages = $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
$stats_actualites = $pdo->query("SELECT COUNT(*) FROM actualites")->fetchColumn();
```

**Sections** :
- Statistiques (nombre de PC, messages, actualités)
- Liens vers toutes les fonctionnalités admin
- Affichage du nom d'utilisateur connecté

**Actions disponibles** :
- Gestion du parc informatique
- Consultation des messages clients
- Gestion des actualités
- Changement de mot de passe
- Création d'utilisateurs
- Accès au parc info

---

### `admin/pc_admin.php`
**Rôle** : Gestion CRUD des PC

**Ajout de PC** :
```php
if ($_POST['action'] === 'add') {
    $nom = trim($_POST['nom']);
    $description = trim($_POST['description']);
    $prix = (float)$_POST['prix'];
    $stock = (int)$_POST['stock'];
    
    $stmt = $pdo->prepare("INSERT INTO pcs (nom, description, prix, stock) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $description, $prix, $stock]);
}
```

**Suppression de PC** :
```php
if ($_POST['action'] === 'delete') {
    $id = (int)$_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM pcs WHERE id = ?");
    $stmt->execute([$id]);
}
```

**Affichage** :
```php
$stmt = $pdo->query("SELECT * FROM pcs ORDER BY nom");
$pcs = $stmt->fetchAll();
```

**Fonctionnalités** :
- Formulaire d'ajout avec validation
- Liste des PC avec prix et stock
- Bouton de suppression avec confirmation JavaScript
- Conversion des types (float pour prix, int pour stock)

---

### `admin/pc.php`
**Rôle** : Visualisation du parc informatique

**Récupération des données** :
```php
// PC
$stmt = $pdo->query("SELECT * FROM pcs ORDER BY prix ASC");
$pcs = $stmt->fetchAll();

// Périphériques
$stmt = $pdo->query("SELECT * FROM peripheriques ORDER BY departement, type");
$peripheriques = $stmt->fetchAll();

// Groupement par département
$periph_by_dept = [];
foreach ($peripheriques as $periph) {
    $periph_by_dept[$periph['departement']][] = $periph;
}
```

**Affichage des composants** :
```php
$composants_list = explode(' | ', $pc['description']);
foreach ($composants_list as $composant):
    if (trim($composant)):
        echo '<li>' . htmlspecialchars($composant) . '</li>';
    endif;
endforeach;
```

**Affichage des périphériques** :
```php
foreach ($periph_by_dept as $dept => $periphs):
    echo '<h3>' . htmlspecialchars($dept) . ' (' . $periphs[0]['quantite'] . ' postes)</h3>';
    foreach ($periphs as $periph):
        echo '<strong>' . htmlspecialchars($periph['type']) . ':</strong> ';
        echo htmlspecialchars($periph['nom']);
    endforeach;
endforeach;
```

**Fonctionnalités** :
- Affichage des PC avec composants détaillés
- Parsing de la description avec `explode()`
- Affichage dynamique des périphériques par département
- Groupement des données par département

---

### `admin/actualites_admin.php`
**Rôle** : Gestion des actualités

**Ajout d'actualité** :
```php
if ($_POST['action'] === 'add') {
    $titre = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);
    
    $stmt = $pdo->prepare("INSERT INTO actualites (titre, contenu) VALUES (?, ?)");
    $stmt->execute([$titre, $contenu]);
}
```

**Suppression** :
```php
if ($_POST['action'] === 'delete') {
    $id = (int)$_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM actualites WHERE id = ?");
    $stmt->execute([$id]);
}
```

**Liste** :
```php
$actualites = $pdo->query("SELECT * FROM actualites ORDER BY date_publication DESC")->fetchAll();
```

**Fonctionnalités** :
- Formulaire de publication
- Liste avec date et extrait
- Suppression avec confirmation

---

### `admin/messages.php`
**Rôle** : Consultation des messages clients

**Récupération** :
```php
$messages = $pdo->query("SELECT * FROM contacts ORDER BY date_creation DESC")->fetchAll();
```

**Statistiques** :
```php
$total = count($messages);
$cette_semaine = count(array_filter($messages, function($m) {
    return strtotime($m['date_creation']) > strtotime('-7 days');
}));
```

**Affichage** :
```php
foreach ($messages as $msg):
    echo htmlspecialchars($msg['nom']);
    echo htmlspecialchars($msg['email']);
    echo nl2br(htmlspecialchars($msg['message']));
    echo date('d/m/Y H:i', strtotime($msg['date_creation']));
endforeach;
```

**Actions** :
- Bouton "Répondre" (lien mailto)
- Bouton "Supprimer"
- Statistiques (total, cette semaine)

---

### `admin/add_user.php`
**Rôle** : Création de comptes administrateur

**Processus** :
```php
if ($_POST) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Vérifier si l'utilisateur existe
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    
    if (!$stmt->fetch()) {
        // Hasher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insérer
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashedPassword]);
    }
}
```

**Sécurité** :
- Vérification des doublons
- Hashage avec `PASSWORD_DEFAULT` (bcrypt)
- Validation des champs

---

### `admin/change_password.php`
**Rôle** : Modification du mot de passe

**Processus** :
```php
if ($_POST) {
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Vérifications
    if ($new_password !== $confirm_password) {
        $message = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($new_password) < 6) {
        $message = "Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        // Vérifier l'ancien mot de passe
        $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->execute([$_SESSION['admin_username']]);
        $user = $stmt->fetch();
        
        if (password_verify($current_password, $user['password'])) {
            // Mettre à jour
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->execute([$hashedPassword, $_SESSION['admin_username']]);
        }
    }
}
```

**Validations** :
- Correspondance des nouveaux mots de passe
- Longueur minimale (6 caractères)
- Vérification de l'ancien mot de passe

---

### `admin/create_peripheriques.php`
**Rôle** : Création de la table périphériques et insertion des données

**Création de table** :
```php
$pdo->exec("
    CREATE TABLE IF NOT EXISTS peripheriques (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(255) NOT NULL,
        type ENUM('Écran', 'Clavier', 'Souris', 'Casque', 'Webcam', 'Spéciaux') NOT NULL,
        departement VARCHAR(100) NOT NULL,
        quantite INT DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");
```

**Insertion en masse** :
```php
$peripheriques = [
    ['2x Dell UltraSharp U2723DE 27" QHD', 'Écran', 'Développement', 15],
    ['Logitech MX Keys Advanced Wireless', 'Clavier', 'Développement', 15],
    // ... autres périphériques
];

$stmt = $pdo->prepare("INSERT INTO peripheriques (nom, type, departement, quantite) VALUES (?, ?, ?, ?)");
foreach ($peripheriques as $periph) {
    $stmt->execute($periph);
}
```

**Fonctionnalités** :
- Création de table avec IF NOT EXISTS
- Type ENUM pour les catégories
- Insertion de tous les départements
- Script à exécuter une seule fois

---

### `admin/components_admin.php`
**Rôle** : Gestion des composants (système avancé)

**Note** : Ce fichier fait partie d'un système de gestion avancée des composants avec tables séparées. Non utilisé dans la version simple actuelle.

---

### `admin/migrate_components.php`
**Rôle** : Migration vers structure avec composants séparés

**Note** : Script de migration pour passer d'une structure simple (description en texte) à une structure normalisée (tables séparées). Non utilisé dans la version simple actuelle.

---

### `admin/update_parc.php`
**Rôle** : Script de mise à jour du parc informatique

**Fonctionnalités** :
```php
// Vider la table
$pdo->exec("DELETE FROM pcs");

// Configurations de PC
$configurations = [
    [
        'nom' => 'Poste Développement Logiciel (15 postes)',
        'description' => 'CPU: Intel Core i7-12700 | RAM: 32 Go DDR4 | SSD: Samsung 980 1 To | GPU: RTX 3050',
        'prix' => 2800.00,
        'stock' => 15
    ],
    // ... autres configurations
];

// Insertion
foreach ($configurations as $config) {
    $stmt = $pdo->prepare("INSERT INTO pcs (nom, description, prix, stock, actif) VALUES (?, ?, ?, ?, 1)");
    $stmt->execute([$config['nom'], $config['description'], $config['prix'], $config['stock']]);
}
```

**Usage** : Script de maintenance pour réinitialiser/mettre à jour les données du parc

---

### `admin/test.php`
**Rôle** : Test du serveur

```php
echo "Test OK - Le serveur fonctionne !";
phpinfo();
```

**Usage** : Vérification rapide de la configuration PHP

---

## Base de Données

### Structure

#### Table `pcs`
```sql
CREATE TABLE pcs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    actif TINYINT(1) DEFAULT 1
);
```

**Champs** :
- `id` : Identifiant unique
- `nom` : Nom du PC/configuration
- `description` : Composants séparés par " | "
- `prix` : Prix en euros (2 décimales)
- `stock` : Quantité disponible
- `actif` : Statut (1=actif, 0=inactif)

---

#### Table `actualites`
```sql
CREATE TABLE actualites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    date_publication DATETIME DEFAULT CURRENT_TIMESTAMP,
    actif TINYINT(1) DEFAULT 1
);
```

**Champs** :
- `id` : Identifiant unique
- `titre` : Titre de l'actualité
- `contenu` : Contenu complet
- `date_publication` : Date automatique
- `actif` : Statut de publication

---

#### Table `contacts`
```sql
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

**Champs** :
- `id` : Identifiant unique
- `nom` : Nom du contact
- `email` : Email du contact
- `message` : Message envoyé
- `date_creation` : Date d'envoi

---

#### Table `users`
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);
```

**Champs** :
- `id` : Identifiant unique
- `username` : Nom d'utilisateur (unique)
- `password` : Mot de passe hashé (bcrypt)

---

#### Table `peripheriques`
```sql
CREATE TABLE peripheriques (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    type ENUM('Écran', 'Clavier', 'Souris', 'Casque', 'Webcam', 'Spéciaux') NOT NULL,
    departement VARCHAR(100) NOT NULL,
    quantite INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Champs** :
- `id` : Identifiant unique
- `nom` : Nom du périphérique
- `type` : Catégorie (ENUM)
- `departement` : Département concerné
- `quantite` : Nombre de postes
- `created_at` : Date de création

---

## Sécurité

### Protection contre les injections SQL
**Méthode** : Requêtes préparées PDO
```php
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
```

### Protection XSS
**Méthode** : Échappement HTML
```php
echo htmlspecialchars($data);
```

### Authentification
**Méthode** : Sessions PHP + mots de passe hashés
```php
password_hash($password, PASSWORD_DEFAULT);
password_verify($password, $hash);
```

### Contrôle d'accès
**Méthode** : Vérification de session sur chaque page admin
```php
if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}
```

### Validation des données
**Méthodes** :
- `trim()` : Suppression des espaces
- `(int)`, `(float)` : Conversion de types
- `isset()` : Vérification d'existence
- `filter_var()` : Validation d'email (optionnel)

---

## Flux de données

### Connexion utilisateur
1. Formulaire login.php
2. Vérification username en BDD
3. Vérification password avec `password_verify()`
4. Création de session
5. Redirection vers dashboard.php

### Ajout d'actualité
1. Formulaire actualites_admin.php
2. Validation des champs
3. Insertion en BDD avec requête préparée
4. Affichage du message de confirmation
5. Actualité visible sur actualites.php

### Contact client
1. Formulaire contact.php
2. Vérification consentement RGPD
3. Insertion en BDD
4. Message de confirmation
5. Consultation dans messages.php

---

## Conventions de code

### Nommage
- Variables : `$snake_case`
- Fonctions : `camelCase`
- Classes : `PascalCase`
- Constantes : `UPPER_CASE`

### Structure PHP
```php
<?php
require_once 'config.php';

// Vérification auth
if (!isset($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit;
}

// Traitement POST
if ($_POST) {
    // Code
}

// Récupération données
try {
    $data = $pdo->query("...")->fetchAll();
} catch(Exception $e) {
    $data = [];
}
?>
<!DOCTYPE html>
<!-- HTML -->
```

### Sécurité systématique
- Toujours utiliser `htmlspecialchars()` pour l'affichage
- Toujours utiliser des requêtes préparées
- Toujours valider les données entrantes
- Toujours vérifier l'authentification

---

## Maintenance

### Ajout d'une fonctionnalité
1. Créer la table en BDD si nécessaire
2. Créer le fichier PHP dans `/admin/`
3. Ajouter la vérification d'authentification
4. Créer le formulaire et le traitement
5. Ajouter le lien dans dashboard.php

### Modification de la structure BDD
1. Créer un script de migration
2. Tester sur une copie de la BDD
3. Exécuter le script
4. Mettre à jour le code PHP correspondant

### Sauvegarde
- Exporter régulièrement la BDD via phpMyAdmin
- Sauvegarder les fichiers du projet
- Versionner avec Git (recommandé)

---

## Améliorations possibles

### Fonctionnalités
- Système de pagination pour les listes
- Recherche et filtres
- Export des données (CSV, PDF)
- Gestion des images pour les PC
- Système de notifications
- API REST pour intégrations

### Sécurité
- Limitation des tentatives de connexion
- Authentification à deux facteurs
- Logs des actions admin
- CSRF tokens
- Rate limiting

### Performance
- Cache des requêtes fréquentes
- Optimisation des images
- Minification CSS/JS
- CDN pour les assets

### UX/UI
- Interface responsive améliorée
- Dark mode
- Notifications en temps réel
- Drag & drop pour les images
- Éditeur WYSIWYG pour les actualités

---

**Fin de la documentation**
