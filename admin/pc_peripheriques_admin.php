<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

// Ajouter un périphérique à un PC
if ($_POST && $_POST['action'] === 'add_peripherique_to_pc') {
    $pc_id = (int)$_POST['pc_id'];
    $peripherique_id = (int)$_POST['peripherique_id'];
    
    if ($pc_id && $peripherique_id) {
        try {
            $check = $pdo->prepare("SELECT COUNT(*) FROM pc_peripheriques WHERE pc_id = ? AND peripherique_id = ?");
            $check->execute([$pc_id, $peripherique_id]);
            
            if ($check->fetchColumn() == 0) {
                $stmt = $pdo->prepare("INSERT INTO pc_peripheriques (pc_id, peripherique_id) VALUES (?, ?)");
                $stmt->execute([$pc_id, $peripherique_id]);
                $message = "Périphérique ajouté au PC !";
            } else {
                $message = "Ce périphérique est déjà associé à ce PC.";
            }
        } catch(Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}

// Supprimer un périphérique d'un PC
if ($_POST && $_POST['action'] === 'remove_peripherique_from_pc') {
    $pc_id = (int)$_POST['pc_id'];
    $peripherique_id = (int)$_POST['peripherique_id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM pc_peripheriques WHERE pc_id = ? AND peripherique_id = ?");
        $stmt->execute([$pc_id, $peripherique_id]);
        $message = "Périphérique retiré du PC !";
    } catch(Exception $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}

// Récupérer les PC
$pcs = $pdo->query("SELECT * FROM pcs ORDER BY nom")->fetchAll();

// Récupérer les périphériques
$peripheriques = $pdo->query("SELECT * FROM peripheriques ORDER BY type, nom")->fetchAll();

// Grouper par type
$peripheriques_by_type = [];
foreach ($peripheriques as $peripherique) {
    $peripheriques_by_type[$peripherique['type']][] = $peripherique;
}

// PC sélectionné
$selected_pc_id = $_GET['pc_id'] ?? null;
$pc_peripheriques = [];
$pc_info = null;
if ($selected_pc_id) {
    $stmt = $pdo->prepare("SELECT * FROM pcs WHERE id = ?");
    $stmt->execute([$selected_pc_id]);
    $pc_info = $stmt->fetch();
    
    $stmt = $pdo->prepare("
        SELECT p.*, pp.id as pc_peripherique_id 
        FROM peripheriques p 
        JOIN pc_peripheriques pp ON p.id = pp.peripherique_id 
        WHERE pp.pc_id = ?
        ORDER BY p.type, p.nom
    ");
    $stmt->execute([$selected_pc_id]);
    $pc_peripheriques = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Gestion PC-Périphériques - TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Gestion PC-Périphériques</h1>
            <div>
                <a href="dashboard.php" class="admin-btn">← Dashboard</a>
                <a href="logout.php" class="admin-btn btn-danger">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="admin-container">
        <?php if ($message): ?>
            <div class="admin-message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="form-section">
            <h2>Sélectionner un PC</h2>
            <form method="get">
                <div class="admin-form-group">
                    <label for="pc_id">PC à modifier</label>
                    <select id="pc_id" name="pc_id" onchange="this.form.submit()">
                        <option value="">Choisir un PC</option>
                        <?php foreach ($pcs as $pc): ?>
                            <option value="<?php echo $pc['id']; ?>" <?php echo $selected_pc_id == $pc['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($pc['nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>

        <?php if ($selected_pc_id && $pc_info): ?>
            <div class="form-section">
                <h2>PC: <?php echo htmlspecialchars($pc_info['nom']); ?></h2>
                <p><strong>Périphériques associés:</strong> <?php echo count($pc_peripheriques); ?></p>
            </div>

            <div class="form-section">
                <h2>Ajouter un périphérique</h2>
                <form method="post">
                    <input type="hidden" name="action" value="add_peripherique_to_pc">
                    <input type="hidden" name="pc_id" value="<?php echo $selected_pc_id; ?>">
                    <div class="admin-form-group">
                        <label for="peripherique_id">Périphérique</label>
                        <select id="peripherique_id" name="peripherique_id" required>
                            <option value="">Choisir un périphérique</option>
                            <?php foreach ($peripheriques_by_type as $type => $type_periphs): ?>
                                <optgroup label="<?php echo htmlspecialchars($type); ?>">
                                    <?php foreach ($type_periphs as $peripherique): ?>
                                        <option value="<?php echo $peripherique['id']; ?>">
                                            <?php echo htmlspecialchars($peripherique['nom']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="admin-btn">Ajouter</button>
                </form>
            </div>

            <div class="pc-list">
                <h2>Périphériques du PC</h2>
                <?php if ($pc_peripheriques): ?>
                    <?php 
                    $current_type = '';
                    foreach ($pc_peripheriques as $periph): 
                        if ($current_type !== $periph['type']):
                            if ($current_type !== '') echo '</div>';
                            $current_type = $periph['type'];
                            echo '<h3 style="margin-top: 1.5rem; color: #007bff;">' . htmlspecialchars($current_type) . '</h3>';
                            echo '<div style="margin-left: 1rem;">';
                        endif;
                    ?>
                    <div class="pc-item" style="grid-template-columns: 2fr 1fr;">
                        <div class="pc-name"><?php echo htmlspecialchars($periph['nom']); ?></div>
                        <div>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="action" value="remove_peripherique_from_pc">
                                <input type="hidden" name="pc_id" value="<?php echo $selected_pc_id; ?>">
                                <input type="hidden" name="peripherique_id" value="<?php echo $periph['id']; ?>">
                                <button type="submit" class="admin-btn btn-danger" onclick="return confirm('Retirer ?')">Retirer</button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>Aucun périphérique associé.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
