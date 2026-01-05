#  Procédure de Sauvegarde et Restauration - TechSolution

##  SAUVEGARDE (PC Source)

### Étape 1 : Sauvegarde des fichier

1 Ouvrir le dossier Techsolution
2 Lancer le script "saveTS.bat"
3 Attendre la fin du script
---

## RESTAURATION (PC Destination)

### Étape 1 : Restaurer les fichiers
1. Coller le dossier `TechSolution` dans `c:\xampp\htdocs\`

### Étape 2 : Restaurer la base de données
1. Ouvrir phpMyAdmin : `http://localhost/phpmyadmin`
2. Créer une nouvelle base de données nommée `techsolution`
3. Sélectionner la base `techsolution`
4. Cliquer sur l'onglet **Importer**
5. Cliquer sur **Choisir un fichier**
6. Sélectionner `techsolution_backup.sql`
7. Cliquer sur **Exécuter**

### Étape 3 : Vérifier la configuration
1. Ouvrir le fichier `config.php`
2. Vérifier les paramètres de connexion 

### Étape 4 : Tester le site
- Site public : `http://localhost/TechSolutionVF/`
- Administration : `http://localhost/TechSolutionVF/admin/login.php`

