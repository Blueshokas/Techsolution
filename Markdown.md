#  Procédure de Sauvegarde et Restauration - TechSolution

##  SAUVEGARDE (PC Source)

### Étape 1 : Sauvegarde des fichier

1. Ouvrir Xampp et lancer apache et mysql
2. Ouvrir le dossier Techsolution
3. Lancer le script "saveTS.bat"
4. Attendre la fin du script
---

## RESTAURATION (PC Destination)

### Étape 1 : Restaurer les fichiers
1. Telecharger le dossier `Techsolution` dans github avec "Download Zip" dans l'onglet "CODE"
2. Extraire `Techsolution.zip` et copier le nouveau fichier
3. Coller le dossier `TechSolution` dans `c:\xampp\htdocs\`

### Étape 2 : Restaurer la base de données
1. Ouvrir phpMyAdmin : `http://localhost/phpmyadmin`
2. Créer une nouvelle base de données nommée `techsolution`
3. Sélectionner la base `techsolution`
4. Cliquer sur l'onglet **Importer**
5. Cliquer sur **Choisir un fichier**
6. Sélectionner `techsolution.sql`
7. Cliquer sur **Exécuter**

### Étape 3 : Vérifier la configuration
1. Ouvrir le fichier `config.php`
2. Vérifier les paramètres de connexion 

### Étape 4 : Tester le site
- Site public : `http://localhost/TechSolution/index.php`