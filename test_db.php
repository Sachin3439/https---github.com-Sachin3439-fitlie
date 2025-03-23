<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';

echo "<h2>Database Connection Test</h2>";

try {
    // Test basic connection
    echo "Database connection successful!<br>";
    
    // Test users table
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $result = $stmt->fetch();
    echo "Users in database: " . $result['count'] . "<br>";
    
    // Test other tables
    $tables = ['bmi_history'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "Table '$table' exists<br>";
        } else {
            echo "Table '$table' does not exist!<br>";
        }
    }
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?> 