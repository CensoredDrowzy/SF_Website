<?php
session_start();
require_once 'new_db_config.php';

// Verify CSRF token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        $_SESSION['login_error'] = "Invalid security token";
        header('Location: new_login.php');
        exit();
    }

    try {
        // Rate limiting - max 5 attempts in 5 minutes
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['first_attempt_time'] = time();
        }

        if ($_SESSION['login_attempts'] >= 5 && (time() - $_SESSION['first_attempt_time']) < 300) {
            throw new Exception('too_many_attempts');
        }

        // Input validation
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            $_SESSION['login_attempts']++;
            throw new Exception('empty_fields');
        }

        $stmt = $pdo->prepare("SELECT id, username, password FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Reset attempts on successful login
            unset($_SESSION['login_attempts']);
            unset($_SESSION['first_attempt_time']);
            
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            header('Location: dashboard.php');
            exit();
        }
        
        // Increment failed attempts
        $_SESSION['login_attempts']++;
        throw new Exception('invalid_credentials');
    } catch (Exception $e) {
        header('Location: new_login.php?error=' . $e->getMessage());
        exit();
    }
}

header('Location: new_login.php');
exit();
