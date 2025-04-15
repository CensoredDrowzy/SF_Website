<?php
session_start();
require_once 'new_db_config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: new_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        // Validate inputs
        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            throw new Exception('All fields are required');
        }

        if ($new_password !== $confirm_password) {
            throw new Exception('New passwords do not match');
        }

        if (strlen($new_password) < 8) {
            throw new Exception('Password must be at least 8 characters');
        }

        // Verify current password
        $stmt = $pdo->prepare("SELECT password FROM admin_users WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($current_password, $user['password'])) {
            throw new Exception('Current password is incorrect');
        }

        // Update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_stmt = $pdo->prepare("UPDATE admin_users SET password = ? WHERE id = ?");
        $update_stmt->execute([$hashed_password, $_SESSION['admin_id']]);

        // Redirect with success message
        $_SESSION['password_change_success'] = true;
        header('Location: dashboard.php');
        exit();

    } catch (Exception $e) {
        $_SESSION['password_change_error'] = $e->getMessage();
        header('Location: dashboard.php');
        exit();
    }
}

// If not POST request, redirect to dashboard
header('Location: dashboard.php');
exit();
?>