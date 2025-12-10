<?php
// Balise d'ouverture PHP
session_start();
// Démarre la session pour pouvoir accéder aux variables de session
// Nécessaire avant de pouvoir détruire la session
session_destroy();
// Détruit toutes les données de la session (déconnexion)
// Supprime toutes les variables de session ($_SESSION['admin_logged'], etc.)
header('Location: ../index.php');
// Redirection vers la page d'accueil du site
// ../ remonte d'un niveau (de admin/ vers racine)
exit;
// Arrêt du script après la redirection
// Empêche l'exécution de code supplémentaire
?>