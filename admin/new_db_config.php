<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'kwjgsdqm_skyfall202525');
define('DB_PASS', 'Sf9kTRXQjvteYpVPghsS');
define('DB_NAME', 'kwjgsdqm_skyfall202525');

// Create PDO connection
try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>