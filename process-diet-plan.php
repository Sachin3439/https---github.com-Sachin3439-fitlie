<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set header to return JSON response
header('Content-Type: application/json');

session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Log the received data
    error_log("Received POST data: " . print_r($_POST, true));
    
    $diet_name = $_POST['diet_name'] ?? '';
    $diet_type = $_POST['diet_type'] ?? '';
    $daily_calories = $_POST['daily_calories'] ?? '';
    $user_id = $_SESSION['user_id'];

    // Validate inputs
    if (empty($diet_name) || empty($diet_type) || empty($daily_calories)) {
        die(json_encode(['success' => false, 'message' => 'Please fill in all required fields']));
    }

    try {
        // Delete existing diet plan for the user
        $stmt = $pdo->prepare("DELETE FROM user_diet_plans WHERE user_id = ?");
        $stmt->execute([$user_id]);

        // Insert new diet plan
        $stmt = $pdo->prepare("INSERT INTO user_diet_plans (user_id, diet_name, diet_type, daily_calories) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $diet_name, $diet_type, $daily_calories]);

        // Get user email
        $stmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if ($user) {
            // Send confirmation email
            $to = $user['email'];
            $subject = "Your Diet Plan Confirmation";
            $message = "Dear User,\n\n";
            $message .= "Your diet plan has been successfully created:\n\n";
            $message .= "Plan Name: $diet_name\n";
            $message .= "Diet Type: $diet_type\n";
            $message .= "Daily Calories: $daily_calories\n\n";
            $message .= "You can view your complete diet plan in your dashboard.\n\n";
            $message .= "Best regards,\nFitLife Team";

            $headers = "From: noreply@fitlife.com\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            if (!mail($to, $subject, $message, $headers)) {
                error_log("Failed to send email to: " . $to);
                // Continue execution even if email fails
            }
        }

        echo json_encode(['success' => true, 'message' => 'Diet plan created successfully']);
    } catch (PDOException $e) {
        error_log("Diet plan creation error: " . $e->getMessage());
        echo json_encode([
            'success' => false, 
            'message' => 'An error occurred while creating your diet plan. Please try again later.',
            'debug' => $e->getMessage() // Only include in development
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?> 