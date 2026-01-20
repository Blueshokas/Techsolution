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

$stmt = $pdo->prepare("SELECT * FROM pcs WHERE id = ?");
$stmt->execute([$pc_id]);
$pc = $stmt->fetch();

if (!$pc) {
    header('Location: pc_admin.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT c.* 
    FROM components c 
    JOIN pc_components pc ON c.id = pc.component_id 
    WHERE pc.pc_id = ?
    ORDER BY 
        CASE c.type 
            WHEN 'CPU' THEN 1
            WHEN 'Carte Mère' THEN 2
            WHEN 'RAM' THEN 3
            WHEN 'SSD' THEN 4
            WHEN 'HDD' THEN 5
            WHEN 'GPU' THEN 6
            WHEN 'Alimentation' THEN 7
            WHEN 'Refroidissement' THEN 8
            WHEN 'Boîtier' THEN 9
            ELSE 10
        END, c.nom
");
$stmt->execute([$pc_id]);
$components = $stmt->fetchAll();

$stmt = $pdo->prepare("
    SELECT p.* 
    FROM peripheriques p 
    JOIN pc_peripheriques pp ON p.id = pp.peripherique_id 
    WHERE pp.pc_id = ?
    ORDER BY p.type, p.nom
");
$stmt->execute([$pc_id]);
$peripheriques = $stmt->fetchAll();
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
                <a href="pc_admin.php" class="admin-btn">← Retour</a>
                <a href="logout.php" class="admin-btn btn-danger">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="admin-container">
        <div class="form-section">
            <h2>Informations du PC</h2>
            <?php if (isset($pc['service'])): ?>
                <p><strong>Service:</strong> <?php echo htmlspecialchars($pc['service']); ?></p>
            <?php endif; ?>
            <?php if (isset($pc['description'])): ?>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($pc['description']); ?></p>
            <?php endif; ?>
        </div>

        <div class="pc-list">
            <h2>Composants (<?php echo count($components); ?>)</h2>
            <?php if ($components): ?>
                <?php 
                $current_type = '';
                foreach ($components as $component): 
                    if ($current_type !== $component['type']):
                        if ($current_type !== '') echo '</div>';
                        $current_type = $component['type'];
                        echo '<h3 style="margin-top: 1.5rem; color: #007bff;">' . htmlspecialchars($current_type) . '</h3>';
                        echo '<div>';
                    endif;
                ?>
                <div class="pc-item" style="margin-bottom: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <div class="pc-name" style="font-weight: 600;"><?php echo htmlspecialchars($component['nom']); ?></div>
                </div>
                <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucun composant.</p>
            <?php endif; ?>
        </div>

        <div class="pc-list">
            <h2>Périphériques (<?php echo count($peripheriques); ?>)</h2>
            <?php if ($peripheriques): ?>
                <?php 
                $current_type = '';
                foreach ($peripheriques as $peripherique): 
                    if ($current_type !== $peripherique['type']):
                        if ($current_type !== '') echo '</div>';
                        $current_type = $peripherique['type'];
                        echo '<h3 style="margin-top: 1.5rem; color: #007bff;">' . htmlspecialchars($current_type) . '</h3>';
                        echo '<div>';
                    endif;
                ?>
                <div class="pc-item" style="margin-bottom: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <div class="pc-name" style="font-weight: 600;"><?php echo htmlspecialchars($peripherique['nom']); ?></div>
                </div>
                <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucun périphérique.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
