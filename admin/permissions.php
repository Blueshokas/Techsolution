<?php
function checkRole($required_role) {
    if (!isset($_SESSION['admin_role'])) {
        header('Location: login.php');
        exit;
    }
    
    $roles = ['utilisateur' => 1, 'technicien' => 2, 'admin' => 3];
    $user_level = $roles[$_SESSION['admin_role']] ?? 0;
    $required_level = $roles[$required_role] ?? 0;
    
    if ($user_level < $required_level) {
        header('Location: dashboard.php');
        exit;
    }
}

function hasRole($role) {
    return isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === $role;
}

function isAdmin() {
    return isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'admin';
}

function isTechnicien() {
    return isset($_SESSION['admin_role']) && in_array($_SESSION['admin_role'], ['technicien', 'admin']);
}
?>
