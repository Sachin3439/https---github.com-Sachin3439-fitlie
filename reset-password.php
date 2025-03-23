<?php
session_start();
require_once 'config/database.php';

$error = '';
$success = '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (empty($token)) {
    $error = "Invalid or expired reset link.";
} else {
    try {
        // Log the token for debugging
        error_log("Token: " . $token);
        error_log("Now: " . date('Y-m-d H:i:s', strtotime("+1 hour")));

        // Check if token exists and is not expired
     // Check if token exists and is not expired
$stmt = $pdo->prepare("SELECT email, expires_at FROM users WHERE reset_token = ? AND expires_at > NOW()");

        $stmt->execute([$token]);
        $reset = $stmt->fetch();

        if (!$reset) {
            // Log if no token is found or it is expired
            error_log("No valid token found or expired.");
            $error = "Invalid or expired reset link.";
        } else {
            // Log successful token validation
            error_log("Valid token found for: " . $reset['email']);
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                if (empty($password)) {
                    $error = "Please enter a new password.";
                } elseif (strlen($password) < 6) {
                    $error = "Password must be at least 6 characters long.";
                } elseif ($password !== $confirm_password) {
                    $error = "Passwords do not match.";
                } else {
                    // Update password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
                    $stmt->execute([$hashed_password, $reset['email']]);
                    // Delete used token
                    $stmt = $pdo->prepare("DELETE FROM password_resets WHERE token = ?");
                    $stmt->execute([$token]);
                    $success = "Password has been reset successfully. You can now login with your new password.";
                }
            }
        }
    } catch (PDOException $e) {
        error_log("PDO Error: " . $e->getMessage()); // Log the full error message
    $error = "An error occurred. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Fitness Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Reset Password</h3>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success">
                                <?php echo $success; ?>
                                <div class="mt-3">
                                    <a href="login.php" class="btn btn-primary">Go to Login</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Reset Password</button>
                                </div>
                            </form>
                        <?php endif; ?>
                        
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