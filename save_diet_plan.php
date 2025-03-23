<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $diet_name = $_POST['diet_name'];
    $diet_type = $_POST['diet_type'];
    $daily_calories = $_POST['daily_calories'];

    try {
        // First, delete any existing diet plan for this user
        $stmt = $pdo->prepare("DELETE FROM user_diet_plans WHERE user_id = ?");
        $stmt->execute([$user_id]);

        // Insert the new diet plan
        $stmt = $pdo->prepare("INSERT INTO user_diet_plans (user_id, diet_name, diet_type, daily_calories) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $diet_name, $diet_type, $daily_calories]);

        // Set success message
        $_SESSION['success_message'] = "Your diet plan has been updated successfully!";
    } catch (PDOException $e) {
        // Set error message
        $_SESSION['error_message'] = "Error saving your diet plan. Please try again.";
    }

    // Redirect back to diet plans page
    header('Location: diet-plans.php');
    exit();
} 