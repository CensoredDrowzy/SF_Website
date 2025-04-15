<?php
require 'new_db_config.php';

try {
    $stmt = $pdo->query("SELECT 1");
    echo "Database connection successful!";
    echo "\nPDO MySQL driver is working correctly";
    
    // Check if admin_users table exists
    $tableExists = $pdo->query("SELECT 1 FROM admin_users LIMIT 1");
    echo $tableExists ? "\nadmin_users table exists" : "\nadmin_users table missing";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>