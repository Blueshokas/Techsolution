<?php
// Configuration de la base de données
$host = 'localhost';
$dbname = 'techsolution';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Démarrer la session si pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>