<?php
require_once '../config.php';

if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

$message = '';

// Ajouter un composant à un PC
if ($_POST && $_POST['action'] === 'add_component_to_pc') {
    $pc_id = (int)$_POST['pc_id'];
    $component_id = (int)$_POST['component_id'];
    
    if ($pc_id && $component_id) {
        try {
            // Vérifier si le composant n'est pas déjà ajouté
            $check = $pdo->prepare("SELECT COUNT(*) FROM pc_components WHERE pc_id = ? AND component_id = ?");
            $check->execute([$pc_id, $component_id]);
            
            if ($check->fetchColumn() == 0) {
                $stmt = $pdo->prepare("INSERT INTO pc_components (pc_id, component_id) VALUES (?, ?)");
                $stmt->execute([$pc_id, $component_id]);
                $message = "Composant ajouté au PC avec succès !";
            } else {
                $message = "Ce composant est déjà présent dans ce PC.";
            }
        } catch(Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}

// Supprimer un composant d'un PC
if ($_POST && $_POST['action'] === 'remove_component_from_pc') {
    $pc_id = (int)$_POST['pc_id'];
    $component_id = (int)$_POST['component_id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM pc_components WHERE pc_id = ? AND component_id = ?");
        $stmt->execute([$pc_id, $component_id]);
        $message = "Composant retiré du PC avec succès !";
    } catch(Exception $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}

// Copier la configuration d'un PC vers un autre
if ($_POST && $_POST['action'] === 'copy_pc_config') {
    $source_pc_id = (int)$_POST['source_pc_id'];
    $target_pc_id = (int)$_POST['target_pc_id'];
    
    if ($source_pc_id && $target_pc_id && $source_pc_id !== $target_pc_id) {
        try {
            // Supprimer l'ancienne configuration du PC cible
            $pdo->prepare("DELETE FROM pc_components WHERE pc_id = ?")->execute([$target_pc_id]);
            
            // Copier la configuration du PC source
            $stmt = $pdo->prepare("
                INSERT INTO pc_components (pc_id, component_id)
                SELECT ?, component_id FROM pc_components WHERE pc_id = ?
            ");
            $stmt->execute([$target_pc_id, $source_pc_id]);
            $message = "Configuration copiée avec succès !";
        } catch(Exception $e) {
            $message = "Erreur lors de la copie : " . $e->getMessage();
        }
    }
}

// Récupérer les PC
$pcs = $pdo->query("SELECT * FROM pcs ORDER BY nom")->fetchAll();

// Récupérer les composants groupés par type
$components = $pdo->query("SELECT * FROM components ORDER BY type, nom")->fetchAll();

// Grouper les composants par type pour un affichage organisé
$components_by_type = [];
foreach ($components as $component) {
    $components_by_type[$component['type']][] = $component;
}

// Récupérer les composants d'un PC sélectionné
$selected_pc_id = $_GET['pc_id'] ?? null;
$pc_components = [];
$pc_info = null;
if ($selected_pc_id) {
    // Informations du PC
    $stmt = $pdo->prepare("SELECT * FROM pcs WHERE id = ?");
    $stmt->execute([$selected_pc_id]);
    $pc_info = $stmt->fetch();
    
    // Composants du PC
    $stmt = $pdo->prepare("
        SELECT c.*, pc.id as pc_component_id 
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
    $stmt->execute([$selected_pc_id]);
    $pc_components = $stmt->fetchAll();
}


?>
<!DOCTYPE html>
<html lang="fr" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>Gestion PC-Composants - TechSolutions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Gestion PC-Composants</h1>
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



        <!-- Sélection du PC -->
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
                                <?php if (isset($pc['service'])): ?>
                                    - <?php echo htmlspecialchars($pc['service']); ?>
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>

        <?php if ($selected_pc_id): ?>
            <!-- Informations du PC sélectionné -->
            <?php if ($pc_info): ?>
                <div class="form-section">
                    <h2>PC sélectionné: <?php echo htmlspecialchars($pc_info['nom']); ?></h2>
                    <div style="background: #e3f2fd; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        <?php if (isset($pc_info['service'])): ?>
                            <p><strong>Service:</strong> <?php echo htmlspecialchars($pc_info['service']); ?></p>
                        <?php endif; ?>
                        <?php if (isset($pc_info['description'])): ?>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($pc_info['description']); ?></p>
                        <?php endif; ?>
                        <p><strong>Nombre de composants:</strong> <?php echo count($pc_components); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Actions rapides -->
            <div class="form-section">
                <h2>Actions rapides</h2>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <!-- Copier configuration -->
                    <form method="post" style="display: inline-block;">
                        <input type="hidden" name="action" value="copy_pc_config">
                        <input type="hidden" name="target_pc_id" value="<?php echo $selected_pc_id; ?>">
                        <select name="source_pc_id" required style="margin-right: 0.5rem;">
                            <option value="">Copier depuis...</option>
                            <?php foreach ($pcs as $pc): ?>
                                <?php if ($pc['id'] != $selected_pc_id): ?>
                                    <option value="<?php echo $pc['id']; ?>"><?php echo htmlspecialchars($pc['nom']); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="admin-btn" onclick="return confirm('Remplacer la configuration actuelle ?')">Copier config</button>
                    </form>
                </div>
            </div>

            <!-- Ajouter un composant -->
            <div class="form-section">
                <h2>Ajouter un composant</h2>
                <form method="post">
                    <input type="hidden" name="action" value="add_component_to_pc">
                    <input type="hidden" name="pc_id" value="<?php echo $selected_pc_id; ?>">
                    <div class="admin-form-group">
                        <label for="component_id">Composant</label>
                        <select id="component_id" name="component_id" required>
                            <option value="">Choisir un composant</option>
                            <?php foreach ($components_by_type as $type => $type_components): ?>
                                <optgroup label="<?php echo htmlspecialchars($type); ?>">
                                    <?php foreach ($type_components as $component): ?>
                                        <option value="<?php echo $component['id']; ?>">
                                            <?php echo htmlspecialchars($component['nom']); ?>
                                            <?php if (isset($component['marque']) && $component['marque']): ?>
                                                (<?php echo htmlspecialchars($component['marque']); ?>)
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="admin-btn">Ajouter</button>
                </form>
            </div>

            <!-- Liste des composants du PC -->
            <div class="pc-list">
                <h2>Configuration actuelle (<?php echo count($pc_components); ?> composants)</h2>
                <?php if ($pc_components): ?>
                    <div style="margin-bottom: 1rem;">
                        <button onclick="toggleAllCategories()" class="admin-btn" style="background: #6c757d;">Replier/Déplier tout</button>
                    </div>
                    <?php 
                    $current_type = '';
                    $type_count = [];
                    // Compter les composants par type
                    foreach ($pc_components as $comp) {
                        $type_count[$comp['type']] = ($type_count[$comp['type']] ?? 0) + 1;
                    }
                    
                    foreach ($pc_components as $component): 
                        if ($current_type !== $component['type']):
                            if ($current_type !== '') echo '</div></div>';
                            $current_type = $component['type'];
                            $count = $type_count[$current_type];
                            echo '<div class="component-category" style="margin-bottom: 1.5rem; border: 1px solid #dee2e6; border-radius: 8px;">';
                            echo '<h3 style="margin: 0; padding: 1rem; background: #f8f9fa; color: #007bff; cursor: pointer; border-radius: 8px 8px 0 0;" onclick="toggleCategory(this)">';
                            echo '<span style="float: right; font-size: 0.8em;">(' . $count . ')</span>';
                            echo htmlspecialchars($current_type);
                            echo '</h3>';
                            echo '<div class="category-content" style="padding: 0;">';
                        endif;
                    ?>
                    <div class="pc-item" style="grid-template-columns: 3fr 1fr; padding: 1rem; border-bottom: 1px solid #eee;">
                        <div>
                            <div class="pc-name" style="font-weight: 600; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($component['nom']); ?></div>
                            <?php if (isset($component['marque']) && $component['marque']): ?>
                                <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.25rem;">
                                    <strong>Marque:</strong> <?php echo htmlspecialchars($component['marque']); ?>
                                </div>
                            <?php endif; ?>
                            <div style="font-size: 0.85rem; color: #007bff;">
                                <strong>Type:</strong> <?php echo htmlspecialchars($component['type']); ?>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="action" value="remove_component_from_pc">
                                <input type="hidden" name="pc_id" value="<?php echo $selected_pc_id; ?>">
                                <input type="hidden" name="component_id" value="<?php echo $component['id']; ?>">
                                <button type="submit" class="admin-btn btn-danger" onclick="return confirm('Retirer ce composant ?')" style="font-size: 0.9rem;">Retirer</button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    </div></div>
                <?php else: ?>
                    <div style="text-align: center; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
                        <p style="margin: 0; color: #666;">Aucun composant dans ce PC.</p>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: #999;">Utilisez le formulaire ci-dessus pour ajouter des composants.</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <script>
    function toggleCategory(header) {
        const content = header.nextElementSibling;
        if (content.style.display === 'none') {
            content.style.display = 'block';
            header.style.borderRadius = '8px 8px 0 0';
        } else {
            content.style.display = 'none';
            header.style.borderRadius = '8px';
        }
    }
    
    function toggleAllCategories() {
        const categories = document.querySelectorAll('.category-content');
        const headers = document.querySelectorAll('.component-category h3');
        const allHidden = Array.from(categories).every(cat => cat.style.display === 'none');
        
        categories.forEach((content, index) => {
            if (allHidden) {
                content.style.display = 'block';
                headers[index].style.borderRadius = '8px 8px 0 0';
            } else {
                content.style.display = 'none';
                headers[index].style.borderRadius = '8px';
            }
        });
    }
    </script>
</body>
</html>