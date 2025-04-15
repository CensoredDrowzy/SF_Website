<?php
session_start();
require_once 'new_db_config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: new_login.php');
    exit();
}

// Get product ID
$product_id = $_GET['id'] ?? 0;

try {
    // Verify product exists
    $stmt = $pdo->prepare("SELECT id FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    
    if (!$stmt->fetch()) {
        throw new Exception('Product not found');
    }

    // Delete product
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$product_id]);

    $_SESSION['product_success'] = "Product deleted successfully";
} catch (Exception $e) {
    $_SESSION['product_error'] = $e->getMessage();
}

header('Location: products.php');
exit();
?>