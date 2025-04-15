<?php
// Use the credentials from your x10hosting PHPMyAdmin
$host = "localhost"; // Usually localhost on x10hosting
$dbname = "kwjgsdqm_skyfall202525";
$user = "kwjgsdqm_skyfall202525";
$pass = "Sf9kTRXQjvteYpVPghsS";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    echo "Connected successfully to x10hosting database!";
    
    // Test if admin_users table exists
    $stmt = $pdo->query("SELECT 1 FROM admin_users LIMIT 1");
    echo $stmt ? "\nTable exists" : "\nTable doesn't exist";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>