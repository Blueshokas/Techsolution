<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$pc_id = $_GET['id'] ?? null;
if (!$pc_id) {
    header('Location: pc_admin.php');
    exit;
}

// Récupérer les infos du PC
$stmt = $pdo->prepare("SELECT * FROM pcs WHERE id = ?");
$stmt->execute([$pc_id]);
$pc = $stmt->fetch();

if (!$pc) {
    header('Location: pc_admin.php');
    exit;
}

// Récupérer les composants du PC
$stmt = $pdo->prepare("
    SELECT c.* 
    FROM components c 
    JOIN pc_components pc ON c.id = pc.component_id 
    WHERE pc.pc_id = ?
    ORDER BY c.type, c.nom
");
$stmt->execute([$pc_id]);
$components = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Composants - <?php echo htmlspecialchars($pc['nom']); ?></title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Composants - <?php echo htmlspecialchars($pc['nom']); ?></h1>
            <div>
                <a href="pc_admin.php" class="admin-btn">← Retour aux PC</a>
                <a href="pc_components_admin.php?pc_id=<?php echo $pc_id; ?>" class="admin-btn">Modifier</a>
            </div>
        </div>
    </header>

    <div class="admin-container">
        <div class="pc-info">
            <h2>Informations du PC</h2>
            <p><strong>Nom :</strong> <?php echo htmlspecialchars($pc['nom']); ?></p>
            <p><strong>Prix :</strong> <?php echo number_format($pc['prix'], 2, ',', ' '); ?> €</p>
            <p><strong>Stock :</strong> <?php echo $pc['stock']; ?></p>

        </div>

        <div class="pc-list">
            <h2>Composants</h2>
            <?php if ($components): ?>
                <?php 
                $current_type = '';
                foreach ($components as $component): 
                    if ($current_type !== $component['type']):
                        if ($current_type !== '') echo '</div>';
                        $current_type = $component['type'];
                        echo '<h3 style="margin-top: 2rem; color: #007bff;">' . htmlspecialchars($current_type) . '</h3>';
                        echo '<div style="margin-left: 1rem;">';
                    endif;
                ?>
                <div class="pc-item" style="grid-template-columns: 3fr 1fr;">
                    <div>
                        <div class="pc-name"><?php echo htmlspecialchars($component['nom']); ?></div>
                        <?php if (isset($component['marque']) && $component['marque']): ?>
                            <div style="font-size: 0.9rem; color: #666;">Marque: <?php echo htmlspecialchars($component['marque']); ?></div>
                        <?php endif; ?>
                    </div>
                    <div><?php echo htmlspecialchars($component['type']); ?></div>
                </div>
                <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucun composant configuré pour ce PC.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>