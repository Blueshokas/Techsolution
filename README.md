# TechSolutionVF

Site web d'entreprise pour TechSolutions - Services informatiques basés à Brive-la-Gaillarde.

## 📋 Description

TechSolutions est une entreprise spécialisée dans les services informatiques, offrant des solutions technologiques complètes pour les entreprises et particuliers. Ce site web présente l'entreprise, ses services, et propose un espace d'administration pour la gestion du contenu.

## ✨ Fonctionnalités

### Site Public
- **Page d'accueil** : Présentation de l'entreprise et de ses services
- **Actualités** : Affichage des dernières nouvelles de l'entreprise
- **Contact** : Formulaire de contact avec conformité RGPD
- **Design responsive** : Compatible mobile et desktop

### Espace Administration
- **Dashboard** : Vue d'ensemble avec statistiques
- **Gestion du parc informatique** : CRUD des PC de l'entreprise
- **Gestion des actualités** : Création et modification des actualités
- **Messages clients** : Consultation des messages de contact
- **Gestion des utilisateurs** : Création de comptes administrateur
- **Sécurité** : Changement de mot de passe

## 🛠️ Technologies

- **Backend** : PHP 7.4+
- **Base de données** : MySQL
- **Frontend** : HTML5, CSS3, JavaScript
- **Serveur** : Apache (XAMPP)

## 📁 Structure du projet

```
TechSolutionVF/
├── admin/                  # Espace d'administration
│   ├── dashboard.php      # Tableau de bord admin
│   ├── login.php          # Connexion admin
│   ├── pc_admin.php       # Gestion du parc PC
│   ├── actualites_admin.php # Gestion des actualités
│   ├── messages.php       # Messages clients
│   └── ...
├── assets/                # Ressources statiques
│   ├── style.css         # Feuille de style principale
│   └── logo.png          # Logo de l'entreprise
├── config.php            # Configuration base de données
├── index.php             # Page d'accueil
├── contact.php           # Page de contact
├── actualites.php        # Page des actualités
└── rgpd.php             # Politique de confidentialité
```

## 🚀 Installation

### Prérequis
- XAMPP (Apache + MySQL + PHP)
- Navigateur web moderne

### Étapes d'installation

1. **Cloner le projet**
   ```bash
   git clone [url-du-repo]
   cd TechSolutionVF
   ```

2. **Démarrer XAMPP**
   - Lancer Apache et MySQL

3. **Créer la base de données**
   - Accéder à phpMyAdmin (http://localhost/phpmyadmin)
   - Créer une base de données nommée `techsolution`

4. **Importer les tables** (structure suggérée)
   ```sql
   -- Table des PC
   CREATE TABLE pcs (
       id INT AUTO_INCREMENT PRIMARY KEY,
       nom VARCHAR(255) NOT NULL,
       prix DECIMAL(10,2) NOT NULL,
       stock INT DEFAULT 0,
       composants TEXT
   );

   -- Table des actualités
   CREATE TABLE actualites (
       id INT AUTO_INCREMENT PRIMARY KEY,
       titre VARCHAR(255) NOT NULL,
       contenu TEXT NOT NULL,
       date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
   );

   -- Table des contacts
   CREATE TABLE contacts (
       id INT AUTO_INCREMENT PRIMARY KEY,
       nom VARCHAR(255) NOT NULL,
       email VARCHAR(255) NOT NULL,
       message TEXT NOT NULL,
       date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
   );

   -- Table des administrateurs
   CREATE TABLE admins (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) UNIQUE NOT NULL,
       password VARCHAR(255) NOT NULL
   );
   ```

5. **Configurer la base de données**
   - Modifier `config.php` si nécessaire (host, username, password)

6. **Créer un compte administrateur**
   ```sql
   INSERT INTO admins (username, password) 
   VALUES ('admin', '$2y$10$...');  -- Mot de passe hashé
   ```

7. **Accéder au site**
   - Site public : http://localhost/TechSolutionVF/
   - Administration : http://localhost/TechSolutionVF/admin/

## 👤 Utilisation

### Accès Administration
- URL : `/admin/login.php`
- Identifiants par défaut à configurer dans la base de données

### Fonctionnalités Admin
- **Dashboard** : Vue d'ensemble des statistiques
- **Parc PC** : Ajouter/modifier/supprimer des PC
- **Actualités** : Publier des nouvelles
- **Messages** : Consulter les demandes clients
- **Utilisateurs** : Gérer les comptes admin

## 🔒 Sécurité

- Sessions PHP sécurisées
- Mots de passe hashés (password_hash)
- Protection contre les injections SQL (PDO)
- Validation des données côté serveur
- Conformité RGPD pour les données personnelles

## 📞 Contact

**TechSolutions**
- Adresse : 12 rue des Innovateurs, 19100 Brive-la-Gaillarde
- Contact : Mme Anna LISE
- Email : contact@techsolutions.com
- Horaires : Lundi-Vendredi 9h-18h, Samedi 10h-16h

## 📄 Licence

© 2024 TechSolutions. Tous droits réservés.