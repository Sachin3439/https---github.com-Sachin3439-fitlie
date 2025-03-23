<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set header to return JSON response
header('Content-Type: application/json');

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get POST data
$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$dietType = $_POST['diet_type'] ?? '';

// Validate inputs
if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

if (!in_array($dietType, ['mediterranean', 'keto', 'vegetarian', 'fasting', 'lowcarb', 'paleo'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid diet type']);
    exit;
}

// In a real application, you would:
// 1. Save to database
// 2. Send confirmation email
// 3. Create user account if needed
// 4. Generate PDF with diet plan
// For now, we'll simulate success

// Prepare email content
$dietNames = [
    'mediterranean' => 'Mediterranean Diet',
    'keto' => 'Ketogenic Diet',
    'vegetarian' => 'Vegetarian Diet',
    'fasting' => 'Intermittent Fasting',
    'lowcarb' => 'Low-Carb Diet',
    'paleo' => 'Paleo Diet'
];

$dietName = $dietNames[$dietType];

// Email content
$to = $email;
$subject = "Welcome to Your {$dietName} Plan!";
$message = "
Hello!

Thank you for choosing the {$dietName} Plan. We're excited to help you on your wellness journey!

Your personalized diet plan will be available in your dashboard within the next few minutes.

Here's what to expect:
- Detailed meal plans
- Shopping lists
- Recipe suggestions
- Progress tracking tools

If you have any questions, please don't hesitate to reach out to our support team.

Best regards,
Your Fitness & Wellness Team
";

$headers = [
    'From' => 'noreply@yourfitnesssite.com',
    'Reply-To' => 'support@yourfitnesssite.com',
    'X-Mailer' => 'PHP/' . phpversion(),
    'Content-Type' => 'text/plain; charset=utf-8'
];

// Try to send email
try {
    if (mail($to, $subject, $message, $headers)) {
        // Success response
        echo json_encode([
            'success' => true,
            'message' => 'Diet plan activated successfully'
        ]);
    } else {
        // Email sending failed
        echo json_encode([
            'success' => true, // Still return success to user
            'message' => 'Plan activated, but email delivery may be delayed'
        ]);
    }
} catch (Exception $e) {
    // Log the error (in a real application)
    error_log("Email sending failed: " . $e->getMessage());
    
    // Still return success to user
    echo json_encode([
        'success' => true,
        'message' => 'Plan activated successfully'
    ]);
} 