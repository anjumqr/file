<?php
session_start();

function hasPermission($userId, $filePath, $permissionType) {
    // ... database connection code

    // Check if user is an Administrator (if they exist)
    $role_sql = "SELECT r.name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.id = ?";
    $role_stmt = $pdo->prepare($role_sql);
    $role_stmt->execute([$userId]);
    $role = $role_stmt->fetchColumn();

    if ($role === 'Administrator') {
        return true; // Admins have full access
    }

    // Check for specific file permission
    $sql = "SELECT can_read, can_write FROM file_permissions WHERE user_id = ? AND file_path = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId, $filePath]);
    $permission = $stmt->fetch();

    if (!$permission) {
        return false; // No permission record found
    }

    if ($permissionType === 'read') {
        return $permission['can_read'] == 1;
    } elseif ($permissionType === 'write') {
        return $permission['can_write'] == 1;
    }

    return false;
}