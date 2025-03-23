<?php
require __DIR__ . "/config/database.php";
require 'vendor/autoload.php'; // Ensure PHPMailer is included
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('Asia/Kolkata'); // Set timezone to Kolkata (IST)

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Initialize response messages
    $error = "";
    $success = "";

    // Validate email input
    if (empty($_POST["email"])) {
        $error = "Please enter your email.";
    } else {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    }

    // Proceed if no error
    if (empty($error)) {
        if (!$pdo) {
            die("Database connection failed!");
        }

        // Generate secure reset token
        try {
            $token = bin2hex(random_bytes(32)); // Generate a 64-character hexadecimal token
            $expiry = date('Y-m-d H:i:s', time() + 3600); // Expiry set to 1 hour from now
        } catch (Exception $e) {
            $error = "Error generating token: " . $e->getMessage();
        }

        if (empty($error)) {
            // Update token in the database
            try {
                $sql = "UPDATE users SET reset_token = :token, expires_at = :expiry WHERE email = :email";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':token' => $token,
                    ':expiry' => $expiry,
                    ':email' => $email
                ]);
                if ($stmt->rowCount() > 0) {
                    // Setup mail
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com'; // Change to your SMTP host
                        $mail->SMTPAuth = true;
                        $mail->Username = 'nabjyotirout@gmail.com'; // Change to your email
                        $mail->Password = 'fnau zllk eqyt sece'; // Change to your email password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        $mail->setFrom("nabjyotirout@gmail.com", "Fitness Tracker");
                        $mail->addAddress($email);
                        $mail->Subject = "Password Reset Request";
                        $mail->Body = "Click <a href='http://localhost/new/reset-password.php?token=$token'>here</a> to reset your password.";
                        $mail->isHTML(true);

                        $mail->send();
                        $success = "Message sent, please check your inbox.";
                    } catch (Exception $e) {
                        $error = "Mailer error: " . $mail->ErrorInfo;
                    }
                } else {
                    $error = "No user found with that email.";
                }
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Fitness Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Forgot Password</h3>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>

                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Send Reset Link</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <a href="login.php" class="text-decoration-none">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
