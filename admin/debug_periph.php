<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

try {
    $stmt = $pdo->query("SELECT * FROM peripheriques LIMIT 5");
    $periphs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($periphs);
    echo "</pre>";
} catch(Exception $e) {
    echo "Erreur: " . $e->getMessage();
}
