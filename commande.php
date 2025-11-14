<?php
require_once 'config.php';

if ($_POST && isset($_POST['pc_id'])) {
    $pc_id = (int)$_POST['pc_id'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM pc WHERE id = ? AND stock > 0");
        $stmt->execute([$pc_id]);
        $pc = $stmt->fetch();
        
        if ($pc) {
            $stmt = $pdo->prepare("UPDATE pc SET stock = stock - 1 WHERE id = ?");
            $stmt->execute([$pc_id]);
            
            $message = "Commande confirmée pour " . htmlspecialchars($pc['nom']) . " !";
            $success = true;
        } else {
            $message = "PC non disponible ou en rupture de stock.";
            $success = false;
        }
    } catch(Exception $e) {
        $message = "Erreur lors de la commande.";
        $success = false;
    }
} else {
    header('Location: pc.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commande - TechSolutions</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .result-container { background: white; padding: 3rem; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center; max-width: 500px; }
        .success { color: #27ae60; }
        .error { color: #e74c3c; }
        .result-container h1 { margin-bottom: 1rem; }
        .result-container p { margin-bottom: 2rem; font-size: 1.1rem; }
        .btn { display: inline-block; padding: 0.8rem 2rem; background: #3498db; color: white; text-decoration: none; border-radius: 5px; margin: 0 0.5rem; }
        .btn:hover { background: #2980b9; }
    </style>
</head>
<body>
    <div class="result-container">
        <h1 class="<?php echo $success ? 'success' : 'error'; ?>">
            <?php echo $success ? '✅ Commande réussie !' : '❌ Erreur'; ?>
        </h1>
        <p><?php echo $message; ?></p>
        <a href="pc.php" class="btn">Retour aux PC</a>
        <a href="contact.php" class="btn">Nous contacter</a>
    </div>
</body>
</html>