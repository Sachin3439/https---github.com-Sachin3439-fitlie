<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = 'localhost';
$username = 'root';  // Default XAMPP username
$password = '';      // Default XAMPP password
$database = 'fitness_db';

// Function to check if MySQL service is running
function isMySQLRunning() {
    $connection = @fsockopen('localhost', 3306, $errno, $errstr, 5);
    if ($connection) {
        fclose($connection);
        return true;
    }
    return false;
}

// Check if MySQL is running
if (!isMySQLRunning()) {
    die("Error: MySQL server is not running. Please start MySQL in XAMPP Control Panel.");
}

// Create connection with error handling
try {
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Set charset to utf8mb4
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    // Log the error
    error_log("Database connection error: " . $e->getMessage());
    
    // Show user-friendly message
    die("Sorry, there was a problem connecting to the database. Please make sure:
         <br>1. XAMPP MySQL service is running
         <br>2. Database 'fitlife_db' exists
         <br>3. Username and password are correct
         <br><br>Error details: " . $e->getMessage());
}

// Create PDO connection for prepared statements
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$database;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    error_log("PDO Connection failed: " . $e->getMessage());
    die("Database connection error. Please try again later.");
}

// Function to check if all required tables exist
function checkRequiredTables($pdo) {
    $required_tables = ['users', 'bmi_history'];
    $missing_tables = [];

    foreach ($required_tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() == 0) {
            $missing_tables[] = $table;
        }
    }

    if (!empty($missing_tables)) {
        error_log("Missing required tables: " . implode(', ', $missing_tables));
        die("Database setup incomplete. Please run the database.sql script first.");
    }
}

// Check for required tables
checkRequiredTables($pdo);
?>