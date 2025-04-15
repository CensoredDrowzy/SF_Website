<?php
require_once 'new_db_config.php';

try {
    // Check if products table exists
    $stmt = $pdo->query("SELECT 1 FROM products LIMIT 1");
    echo "Products table exists!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    echo "\nThe products table may not exist. You need to run the SQL in admin/add_products_table.sql";
}

$pdo = null;
?>