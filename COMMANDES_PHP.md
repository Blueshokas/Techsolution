# Guide des Commandes et Fonctions PHP - TechSolutionVF

## 📚 Table des matières
1. [Commandes PHP de base](#commandes-php-de-base)
2. [Gestion de base de données (PDO)](#gestion-de-base-de-données-pdo)
3. [Gestion des sessions](#gestion-des-sessions)
4. [Manipulation de chaînes](#manipulation-de-chaînes)
5. [Sécurité](#sécurité)
6. [Dates et temps](#dates-et-temps)
7. [Tableaux](#tableaux)
8. [Redirections et headers](#redirections-et-headers)

---

## Commandes PHP de base

### `require_once`
**Syntaxe** : `require_once 'fichier.php';`

**Rôle** : Inclut un fichier PHP une seule fois dans le script

**Exemple** :
```php
require_once '../config.php';  // Inclut la configuration
```

**Différences** :
- `require` : Inclut et génère une erreur fatale si le fichier n'existe pas
- `require_once` : Comme require mais n'inclut qu'une seule fois
- `include` : Inclut mais génère seulement un warning si absent
- `include_once` : Comme include mais n'inclut qu'une seule fois

---

### `echo`
**Syntaxe** : `echo "texte";` ou `echo $variable;`

**Rôle** : Affiche du texte ou des variables

**Exemples** :
```php
echo "Bonjour";                           // Affiche: Bonjour
echo $nom;                                // Affiche la variable $nom
echo "Bonjour " . $nom;                   // Concatène avec .
echo "Bonjour $nom";                      // Interpolation dans les guillemets
```

---

### `isset()`
**Syntaxe** : `isset($variable)`

**Rôle** : Vérifie si une variable existe et n'est pas NULL

**Exemples** :
```php
if (isset($_POST['nom'])) {               // Vérifie si le champ 'nom' existe
    $nom = $_POST['nom'];
}

if (isset($_SESSION['admin_logged'])) {  // Vérifie si la session existe
    // Utilisateur connecté
}
```

**Retour** : `true` si la variable existe, `false` sinon

---

### `empty()`
**Syntaxe** : `empty($variable)`

**Rôle** : Vérifie si une variable est vide

**Exemples** :
```php
if (empty($nom)) {                        // Vérifie si $nom est vide
    echo "Le nom est vide";
}

if (!empty($pc['composants_list'])) {    // Vérifie si NON vide
    // Utiliser les composants
}
```

**Considéré comme vide** : "", 0, "0", NULL, false, array()

---

### `die()` / `exit()`
**Syntaxe** : `die("message");` ou `exit();`

**Rôle** : Arrête l'exécution du script

**Exemples** :
```php
die("Erreur de connexion");               // Arrête et affiche le message

header('Location: login.php');
exit;                                     // Arrête après une redirection
```

---

### `try / catch`
**Syntaxe** :
```php
try {
    // Code qui peut générer une erreur
} catch(Exception $e) {
    // Gestion de l'erreur
}
```

**Exemples** :
```php
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
} catch(PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

try {
    $stmt = $pdo->query("SELECT * FROM pcs");
    $pcs = $stmt->fetchAll();
} catch(Exception $e) {
    $pcs = [];  // Tableau vide en cas d'erreur
}
```

---

## Gestion de base de données (PDO)

### `new PDO()`
**Syntaxe** : `new PDO($dsn, $username, $password, $options)`

**Rôle** : Crée une connexion à la base de données

**Exemple** :
```php
$pdo = new PDO(
    "mysql:host=localhost;dbname=techsolution;charset=utf8",
    "root",
    ""
);
```

**DSN** : Data Source Name (chaîne de connexion)

---

### `setAttribute()`
**Syntaxe** : `$pdo->setAttribute($attribute, $value)`

**Rôle** : Configure les options de PDO

**Exemple** :
```php
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Active le mode exception pour les erreurs
```

**Options courantes** :
- `PDO::ATTR_ERRMODE` : Mode de gestion des erreurs
- `PDO::ERRMODE_EXCEPTION` : Lance des exceptions
- `PDO::ATTR_DEFAULT_FETCH_MODE` : Mode de récupération par défaut

---

### `query()`
**Syntaxe** : `$pdo->query($sql)`

**Rôle** : Exécute une requête SQL simple (sans paramètres)

**Exemples** :
```php
$stmt = $pdo->query("SELECT * FROM pcs");
$pcs = $stmt->fetchAll();

$count = $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
```

**⚠️ Attention** : N'utilisez JAMAIS query() avec des variables utilisateur (risque d'injection SQL)

---

### `prepare()`
**Syntaxe** : `$pdo->prepare($sql)`

**Rôle** : Prépare une requête SQL avec des paramètres (sécurisé)

**Exemples** :
```php
// Avec des points d'interrogation (?)
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);

// Avec des paramètres nommés (:nom)
$stmt = $pdo->prepare("INSERT INTO contacts (nom, email, message) VALUES (:nom, :email, :msg)");
$stmt->execute([
    ':nom' => $nom,
    ':email' => $email,
    ':msg' => $message
]);
```

**Avantages** :
- Protection contre les injections SQL
- Meilleure performance pour requêtes répétées
- Séparation données/requête

---

### `execute()`
**Syntaxe** : `$stmt->execute($params)`

**Rôle** : Exécute une requête préparée avec des paramètres

**Exemples** :
```php
$stmt = $pdo->prepare("INSERT INTO pcs (nom, prix, stock) VALUES (?, ?, ?)");
$stmt->execute([$nom, $prix, $stock]);

$stmt = $pdo->prepare("DELETE FROM pcs WHERE id = ?");
$stmt->execute([$id]);

$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
$stmt->execute([$hashedPassword, $username]);
```

---

### `fetch()`
**Syntaxe** : `$stmt->fetch($mode)`

**Rôle** : Récupère UNE ligne de résultat

**Exemples** :
```php
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();  // Retourne un tableau associatif

if ($user) {
    echo $user['username'];
    echo $user['password'];
}
```

**Modes** :
- `PDO::FETCH_ASSOC` : Tableau associatif (par défaut)
- `PDO::FETCH_OBJ` : Objet
- `PDO::FETCH_NUM` : Tableau numérique

---

### `fetchAll()`
**Syntaxe** : `$stmt->fetchAll($mode)`

**Rôle** : Récupère TOUTES les lignes de résultat

**Exemples** :
```php
$stmt = $pdo->query("SELECT * FROM pcs");
$pcs = $stmt->fetchAll();  // Retourne un tableau de tableaux

foreach ($pcs as $pc) {
    echo $pc['nom'];
    echo $pc['prix'];
}
```

---

### `fetchColumn()`
**Syntaxe** : `$stmt->fetchColumn($column_number)`

**Rôle** : Récupère UNE colonne d'UNE ligne

**Exemples** :
```php
$count = $pdo->query("SELECT COUNT(*) FROM pcs")->fetchColumn();
// Retourne directement le nombre (ex: 15)

$prix = $pdo->query("SELECT prix FROM pcs WHERE id = 1")->fetchColumn();
// Retourne directement le prix (ex: 2800.00)
```

---

### `lastInsertId()`
**Syntaxe** : `$pdo->lastInsertId()`

**Rôle** : Récupère l'ID de la dernière insertion

**Exemple** :
```php
$stmt = $pdo->prepare("INSERT INTO pcs (nom, prix) VALUES (?, ?)");
$stmt->execute([$nom, $prix]);
$pc_id = $pdo->lastInsertId();  // Récupère l'ID auto-incrémenté

echo "PC créé avec l'ID : " . $pc_id;
```

---

### `exec()`
**Syntaxe** : `$pdo->exec($sql)`

**Rôle** : Exécute une requête SQL et retourne le nombre de lignes affectées

**Exemples** :
```php
$pdo->exec("DELETE FROM pcs");  // Vide la table

$pdo->exec("CREATE TABLE IF NOT EXISTS peripheriques (...)");  // Crée une table

$affected = $pdo->exec("UPDATE pcs SET actif = 1");
echo "$affected lignes modifiées";
```

---

## Gestion des sessions

### `session_start()`
**Syntaxe** : `session_start()`

**Rôle** : Démarre ou reprend une session

**Exemple** :
```php
session_start();  // À appeler au début de chaque page utilisant les sessions
$_SESSION['admin_logged'] = true;
```

**⚠️ Important** : Doit être appelé AVANT tout affichage HTML

---

### `session_status()`
**Syntaxe** : `session_status()`

**Rôle** : Retourne l'état de la session

**Exemple** :
```php
if (session_status() === PHP_SESSION_NONE) {
    session_start();  // Démarre seulement si pas déjà active
}
```

**Valeurs** :
- `PHP_SESSION_DISABLED` : Sessions désactivées
- `PHP_SESSION_NONE` : Sessions activées mais pas démarrée
- `PHP_SESSION_ACTIVE` : Session active

---

### `session_destroy()`
**Syntaxe** : `session_destroy()`

**Rôle** : Détruit toutes les données de session

**Exemple** :
```php
session_start();
session_destroy();  // Déconnexion
header('Location: index.php');
exit;
```

---

### `$_SESSION`
**Syntaxe** : `$_SESSION['cle'] = $valeur`

**Rôle** : Tableau superglobal pour stocker des données de session

**Exemples** :
```php
// Stocker des données
$_SESSION['admin_logged'] = true;
$_SESSION['admin_username'] = 'john';
$_SESSION['user_id'] = 42;

// Lire des données
if ($_SESSION['admin_logged']) {
    echo "Connecté en tant que " . $_SESSION['admin_username'];
}

// Supprimer une donnée
unset($_SESSION['admin_logged']);
```

---

## Manipulation de chaînes

### `trim()`
**Syntaxe** : `trim($string, $characters)`

**Rôle** : Supprime les espaces (ou autres caractères) au début et à la fin

**Exemples** :
```php
$nom = trim($_POST['nom']);           // "  John  " devient "John"
$email = trim($_POST['email']);       // Supprime espaces inutiles
```

**Variantes** :
- `ltrim()` : Supprime à gauche uniquement
- `rtrim()` : Supprime à droite uniquement

---

### `htmlspecialchars()`
**Syntaxe** : `htmlspecialchars($string, $flags, $encoding)`

**Rôle** : Convertit les caractères spéciaux en entités HTML (protection XSS)

**Exemples** :
```php
echo htmlspecialchars($nom);
// "<script>alert('XSS')</script>" devient "&lt;script&gt;alert('XSS')&lt;/script&gt;"

echo htmlspecialchars($pc['nom']);
// Affiche le nom en toute sécurité
```

**Conversions** :
- `<` → `&lt;`
- `>` → `&gt;`
- `"` → `&quot;`
- `'` → `&#039;`
- `&` → `&amp;`

---

### `explode()`
**Syntaxe** : `explode($separator, $string, $limit)`

**Rôle** : Divise une chaîne en tableau

**Exemples** :
```php
$description = "CPU: Intel i7 | RAM: 32Go | SSD: 1To";
$composants = explode(' | ', $description);
// Résultat: ["CPU: Intel i7", "RAM: 32Go", "SSD: 1To"]

foreach ($composants as $composant) {
    echo $composant;
}
```

---

### `implode()` / `join()`
**Syntaxe** : `implode($separator, $array)`

**Rôle** : Joint les éléments d'un tableau en chaîne

**Exemples** :
```php
$tags = ['PHP', 'MySQL', 'HTML'];
$result = implode(', ', $tags);
// Résultat: "PHP, MySQL, HTML"

$path = ['admin', 'dashboard.php'];
$url = implode('/', $path);
// Résultat: "admin/dashboard.php"
```

---

### `nl2br()`
**Syntaxe** : `nl2br($string)`

**Rôle** : Convertit les retours à la ligne en balises `<br>`

**Exemple** :
```php
$message = "Ligne 1\nLigne 2\nLigne 3";
echo nl2br($message);
// Affiche:
// Ligne 1<br>
// Ligne 2<br>
// Ligne 3
```

---

### `strlen()`
**Syntaxe** : `strlen($string)`

**Rôle** : Retourne la longueur d'une chaîne

**Exemples** :
```php
if (strlen($password) < 6) {
    echo "Mot de passe trop court";
}

$length = strlen("Bonjour");  // Retourne 7
```

---

### `substr()`
**Syntaxe** : `substr($string, $start, $length)`

**Rôle** : Extrait une partie d'une chaîne

**Exemples** :
```php
$text = "Bonjour le monde";
echo substr($text, 0, 7);     // "Bonjour"
echo substr($text, 8);        // "le monde"
echo substr($text, -5);       // "monde"

// Extrait pour aperçu
echo substr($description, 0, 50) . "...";
```

---

### `strtotime()`
**Syntaxe** : `strtotime($datetime)`

**Rôle** : Convertit une date en timestamp Unix

**Exemples** :
```php
$timestamp = strtotime('2024-01-15 14:30:00');
$timestamp = strtotime($actu['date_publication']);
$timestamp = strtotime('-7 days');  // Il y a 7 jours
$timestamp = strtotime('+1 month'); // Dans 1 mois
```

---

## Sécurité

### `password_hash()`
**Syntaxe** : `password_hash($password, $algo, $options)`

**Rôle** : Hash un mot de passe de manière sécurisée

**Exemples** :
```php
$password = "monMotDePasse123";
$hash = password_hash($password, PASSWORD_DEFAULT);
// Résultat: $2y$10$abcdefghijklmnopqrstuvwxyz...

// Stockage en BDD
$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hash]);
```

**Algorithmes** :
- `PASSWORD_DEFAULT` : Bcrypt (recommandé)
- `PASSWORD_BCRYPT` : Bcrypt explicite
- `PASSWORD_ARGON2I` : Argon2i
- `PASSWORD_ARGON2ID` : Argon2id

---

### `password_verify()`
**Syntaxe** : `password_verify($password, $hash)`

**Rôle** : Vérifie si un mot de passe correspond au hash

**Exemple** :
```php
$password = $_POST['password'];
$hash = $user['password'];  // Hash depuis la BDD

if (password_verify($password, $hash)) {
    // Mot de passe correct
    $_SESSION['admin_logged'] = true;
} else {
    // Mot de passe incorrect
    $error = "Identifiants incorrects";
}
```

**Retour** : `true` si correspond, `false` sinon

---

## Dates et temps

### `date()`
**Syntaxe** : `date($format, $timestamp)`

**Rôle** : Formate une date

**Exemples** :
```php
echo date('d/m/Y');                    // 15/01/2024
echo date('d/m/Y H:i');                // 15/01/2024 14:30
echo date('Y-m-d');                    // 2024-01-15
echo date('l d F Y');                  // Monday 15 January 2024

$date = date('d/m/Y', strtotime($actu['date_publication']));
```

**Formats courants** :
- `d` : Jour (01-31)
- `m` : Mois (01-12)
- `Y` : Année (4 chiffres)
- `H` : Heure (00-23)
- `i` : Minutes (00-59)
- `s` : Secondes (00-59)

---

## Tableaux

### `count()`
**Syntaxe** : `count($array)`

**Rôle** : Compte le nombre d'éléments dans un tableau

**Exemples** :
```php
$total = count($messages);             // Nombre de messages
$nb_pcs = count($pcs);                 // Nombre de PC

if (count($actualites) > 0) {
    // Il y a des actualités
}
```

---

### `array_filter()`
**Syntaxe** : `array_filter($array, $callback)`

**Rôle** : Filtre les éléments d'un tableau

**Exemple** :
```php
$cette_semaine = count(array_filter($messages, function($m) {
    return strtotime($m['date_creation']) > strtotime('-7 days');
}));
// Compte les messages de moins de 7 jours
```

---

### `foreach`
**Syntaxe** : `foreach ($array as $value)` ou `foreach ($array as $key => $value)`

**Rôle** : Parcourt un tableau

**Exemples** :
```php
// Parcours simple
foreach ($pcs as $pc) {
    echo $pc['nom'];
    echo $pc['prix'];
}

// Avec clé et valeur
foreach ($periph_by_dept as $dept => $periphs) {
    echo "Département: $dept";
    foreach ($periphs as $periph) {
        echo $periph['nom'];
    }
}
```

---

## Redirections et headers

### `header()`
**Syntaxe** : `header($header, $replace, $http_response_code)`

**Rôle** : Envoie un en-tête HTTP brut

**Exemples** :
```php
// Redirection
header('Location: dashboard.php');
exit;  // Toujours mettre exit après une redirection

header('Location: login.php');
exit;

// Autres headers
header('Content-Type: application/json');
header('HTTP/1.1 404 Not Found');
```

**⚠️ Important** : Doit être appelé AVANT tout affichage HTML

---

## Variables superglobales

### `$_POST`
**Rôle** : Contient les données envoyées via méthode POST

**Exemples** :
```php
if ($_POST) {  // Vérifie si formulaire soumis
    $nom = $_POST['nom'];
    $email = $_POST['email'];
}

if (isset($_POST['action']) && $_POST['action'] === 'add') {
    // Action spécifique
}
```

---

### `$_GET`
**Rôle** : Contient les données envoyées via URL

**Exemples** :
```php
// URL: page.php?id=5&action=edit
$id = $_GET['id'];        // 5
$action = $_GET['action']; // edit

if (isset($_GET['id'])) {
    $pc_id = (int)$_GET['id'];
}
```

---

### `$_SERVER`
**Rôle** : Informations sur le serveur et l'exécution

**Exemples** :
```php
$_SERVER['REQUEST_METHOD']  // GET, POST, etc.
$_SERVER['HTTP_HOST']       // localhost
$_SERVER['REQUEST_URI']     // /admin/dashboard.php
$_SERVER['REMOTE_ADDR']     // Adresse IP du client
```

---

## Conversions de types

### Cast de types
**Syntaxe** : `(type)$variable`

**Exemples** :
```php
$id = (int)$_POST['id'];           // Force en entier
$prix = (float)$_POST['prix'];     // Force en décimal
$actif = (bool)$_POST['actif'];    // Force en booléen
$nom = (string)$_POST['nom'];      // Force en chaîne
```

**Pourquoi** : Sécurité et cohérence des données

---

## Opérateurs

### Opérateurs de comparaison
```php
==   // Égal (valeur)
===  // Identique (valeur ET type)
!=   // Différent
!==  // Non identique
<    // Inférieur
>    // Supérieur
<=   // Inférieur ou égal
>=   // Supérieur ou égal
```

**Exemples** :
```php
if ($user && password_verify($password, $user['password'])) { }
if ($_SESSION['admin_logged'] === true) { }
if ($stock > 0) { }
```

---

### Opérateurs logiques
```php
&&   // ET (AND)
||   // OU (OR)
!    // NON (NOT)
```

**Exemples** :
```php
if ($nom && $email && $message) { }
if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) { }
```

---

### Opérateur ternaire
**Syntaxe** : `$result = $condition ? $valeur_si_vrai : $valeur_si_faux`

**Exemples** :
```php
$message = $success ? "Succès" : "Erreur";
$class = $actif ? 'active' : 'inactive';
$display = count($pcs) > 0 ? 'block' : 'none';
```

---

### Opérateur de coalescence nulle
**Syntaxe** : `$result = $var ?? $default`

**Exemples** :
```php
$nom = $_POST['nom'] ?? '';
$page = $_GET['page'] ?? 1;
$composants = $pc['composants_list'] ?? $pc['description'];
```

**Équivalent à** :
```php
$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
```

---

## Structures de contrôle

### `if / elseif / else`
```php
if ($condition1) {
    // Code si condition1 vraie
} elseif ($condition2) {
    // Code si condition2 vraie
} else {
    // Code si aucune condition vraie
}
```

---

### Syntaxe alternative (dans HTML)
```php
<?php if ($pcs): ?>
    <!-- HTML si $pcs existe -->
<?php else: ?>
    <!-- HTML sinon -->
<?php endif; ?>

<?php foreach ($pcs as $pc): ?>
    <!-- HTML pour chaque PC -->
<?php endforeach; ?>
```

---

## Résumé des commandes les plus utilisées

| Commande | Usage | Exemple |
|----------|-------|---------|
| `require_once` | Inclure fichier | `require_once 'config.php';` |
| `$pdo->prepare()` | Requête sécurisée | `$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");` |
| `$stmt->execute()` | Exécuter requête | `$stmt->execute([$id]);` |
| `$stmt->fetchAll()` | Récupérer résultats | `$users = $stmt->fetchAll();` |
| `htmlspecialchars()` | Sécurité XSS | `echo htmlspecialchars($nom);` |
| `password_hash()` | Hasher mot de passe | `$hash = password_hash($pass, PASSWORD_DEFAULT);` |
| `password_verify()` | Vérifier mot de passe | `if (password_verify($pass, $hash)) {}` |
| `trim()` | Nettoyer espaces | `$nom = trim($_POST['nom']);` |
| `isset()` | Vérifier existence | `if (isset($_POST['nom'])) {}` |
| `header()` | Redirection | `header('Location: page.php');` |
| `session_start()` | Démarrer session | `session_start();` |
| `$_SESSION` | Stocker données | `$_SESSION['user_id'] = 42;` |

---

**Fin du guide des commandes**
