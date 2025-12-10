<?php
// Balise d'ouverture PHP

// Configuration de la base de données
$host = 'localhost';
// Variable contenant l'adresse du serveur MySQL (localhost = serveur local)
$dbname = 'techsolution';
// Variable contenant le nom de la base de données à utiliser
$username = 'root';
// Variable contenant le nom d'utilisateur MySQL (root = administrateur par défaut)
$password = '';
// Variable contenant le mot de passe MySQL (vide par défaut sur XAMPP)

try {
    // Bloc try pour gérer les erreurs de connexion
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Création d'un objet PDO pour la connexion à la base de données
    // DSN (Data Source Name) : mysql:host=localhost;dbname=techsolution;charset=utf8
    // charset=utf8 permet de gérer les caractères accentués
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Configuration de PDO pour lancer des exceptions en cas d'erreur SQL
    // Permet une meilleure gestion des erreurs avec try-catch
} catch(PDOException $e) {
    // Bloc catch : capture les erreurs de type PDOException
    die("Erreur de connexion : " . $e->getMessage());
    // Arrêt du script avec affichage du message d'erreur
    // die() stoppe l'exécution et affiche le message
}

// Démarrer la session si pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    // Condition : vérifie si aucune session n'est active
    // PHP_SESSION_NONE = constante indiquant qu'aucune session n'existe
    session_start();
    // Démarre une nouvelle session PHP
    // Permet de stocker des variables entre les pages (ex: connexion utilisateur)
}
?>