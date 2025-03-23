<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';

require_once 'config/database.php';

try {
    // Create connection without database
    $conn = new mysqli($host, $username, $password);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS fitlife_db";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully or already exists<br>";
    } else {
        throw new Exception("Error creating database: " . $conn->error);
    }
    
    // Select the database
    $conn->select_db('fitlife_db');
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(100),
        age INT,
        gender ENUM('male', 'female', 'other'),
        height DECIMAL(5,2),
        weight DECIMAL(5,2),
        bmi DECIMAL(4,2),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Users table created successfully<br>";
    } else {
        throw new Exception("Error creating users table: " . $conn->error);
    }
    
    // Create BMI history table
    $sql = "CREATE TABLE IF NOT EXISTS bmi_history (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        height DECIMAL(5,2),
        weight DECIMAL(5,2),
        bmi DECIMAL(4,2),
        calculated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";

    if ($conn->query($sql) === TRUE) {
        echo "BMI history table created successfully<br>";
    } else {
        throw new Exception("Error creating bmi_history table: " . $conn->error);
    }
    
    // Create exercise_logs table
    $sql = "CREATE TABLE IF NOT EXISTS exercise_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        exercise_name VARCHAR(100) NOT NULL,
        sets INT,
        reps INT,
        duration INT,
        calories_burned INT,
        date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Exercise logs table created successfully<br>";
    } else {
        throw new Exception("Error creating exercise_logs table: " . $conn->error);
    }
    
    // Create progress_tracking table
    $sql = "CREATE TABLE IF NOT EXISTS progress_tracking (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        weight DECIMAL(5,2),
        body_fat_percentage DECIMAL(4,2),
        muscle_mass_percentage DECIMAL(4,2),
        date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Progress tracking table created successfully<br>";
    } else {
        throw new Exception("Error creating progress_tracking table: " . $conn->error);
    }
    
    // Create goals table
    $sql = "CREATE TABLE IF NOT EXISTS goals (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        goal_type ENUM('weight_loss', 'muscle_gain', 'maintenance', 'endurance', 'strength'),
        target_weight DECIMAL(5,2),
        target_date DATE,
        status ENUM('active', 'completed', 'abandoned') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Goals table created successfully<br>";
    } else {
        throw new Exception("Error creating goals table: " . $conn->error);
    }
    
    // Create consultations table
    $sql = "CREATE TABLE IF NOT EXISTS consultations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        consultant_name VARCHAR(100),
        consultation_date DATETIME,
        status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Consultations table created successfully<br>";
    } else {
        throw new Exception("Error creating consultations table: " . $conn->error);
    }
    
    // Create user_diet_plans table
    $sql = "CREATE TABLE IF NOT EXISTS user_diet_plans (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        diet_name VARCHAR(100) NOT NULL,
        diet_type ENUM('vegetarian', 'non-vegetarian') NOT NULL,
        daily_calories VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Database table 'user_diet_plans' created successfully!<br>";
    } else {
        throw new Exception("Error creating user_diet_plans table: " . $conn->error);
    }
    
    echo "<br>Database setup completed successfully!<br>";
    echo "You can now <a href='login.php'>return to login</a>.";
    
} catch (Exception $e) {
    die("Setup failed: " . $e->getMessage());
}

$conn->close();
?> 