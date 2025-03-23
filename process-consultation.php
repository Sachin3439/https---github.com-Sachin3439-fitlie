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
    die(json_encode(['success' => false, 'message' => 'Please login first']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $preferred_date = $_POST['preferred_date'] ?? '';
    $message = $_POST['message'] ?? '';
    $user_id = $_SESSION['user_id'];

    // Validate inputs
    if (empty($name) || empty($email) || empty($phone) || empty($preferred_date)) {
        die(json_encode(['success' => false, 'message' => 'Please fill in all required fields']));
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die(json_encode(['success' => false, 'message' => 'Please enter a valid email address']));
    }

    try {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO consultations (user_id, consultant_name, consultation_date, notes) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $name, $preferred_date, $message);
        $stmt->execute();

        // Send email notification
        $to = "support@fitlife.com"; // Replace with your email
        $subject = "New Consultation Request";
        $email_message = "New consultation request received:\n\n";
        $email_message .= "Name: $name\n";
        $email_message .= "Email: $email\n";
        $email_message .= "Phone: $phone\n";
        $email_message .= "Preferred Date: $preferred_date\n";
        $email_message .= "Message: $message\n";

        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        mail($to, $subject, $email_message, $headers);

        // Send confirmation to user
        $user_subject = "Consultation Request Confirmation";
        $user_message = "Dear $name,\n\n";
        $user_message .= "Thank you for your consultation request. We will contact you shortly to confirm your appointment.\n\n";
        $user_message .= "Best regards,\nFitLife Team";

        mail($email, $user_subject, $user_message);

        echo json_encode(['success' => true, 'message' => 'Consultation request submitted successfully']);
    } catch (Exception $e) {
        error_log("Consultation submission error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
} 