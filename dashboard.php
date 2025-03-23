<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session and include required files
session_start();
require_once 'config/database.php';

// Define base URL - adjust this according to your setup
define('BASE_URL', '/');  // If your project is in the root of htdocs
// OR
// define('BASE_URL', '/your-project-folder/');  // If your project is in a subfolder

// Function to redirect with proper URL
//function redirectTo($path) {
 //   header('Location: ' . BASE_URL . $path);
//    exit();
//}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login to access the dashboard.";
    //redirectTo(' http://localhost/your-project-folder/login.php');
    header('location: http://localhost/your-project-folder/login.php');
}

// Function to check if file exists
function checkPageExists($page) {
    return file_exists(__DIR__ . '/' . $page);
}

// Validate requested pages
$allowed_pages = ['bmi-calculator.php', 'diet-plans.php', 'exercise-tips.php'];
foreach ($allowed_pages as $page) {
    if (!checkPageExists($page)) {
        error_log("Missing required page: " . $page);
    }
}

// Check if user exists
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT name, email, created_at FROM users WHERE id = ?");
try {
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    if (!$user) {
        die("User not found in database. Please try logging in again.");
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die("An error occurred while fetching user data. Please try again later.");
}

// Fetch latest BMI with error handling
try {
    $stmt = $pdo->prepare("
        SELECT bmi, weight, height, calculated_at 
        FROM bmi_history 
        WHERE user_id = ? 
        ORDER BY calculated_at DESC 
        LIMIT 1
    ");
    $stmt->execute([$user_id]);
    $latest_bmi = $stmt->fetch();
} catch (PDOException $e) {
    error_log("BMI fetch error: " . $e->getMessage());
    $latest_bmi = false;
}

// Fetch BMI history for chart with error handling
try {
    $stmt = $pdo->prepare("
        SELECT bmi, DATE_FORMAT(calculated_at, '%Y-%m-%d') as date
        FROM bmi_history 
        WHERE user_id = ? 
        ORDER BY calculated_at DESC 
        LIMIT 5
    ");
    $stmt->execute([$user_id]);
    $bmi_history = array_reverse($stmt->fetchAll());
} catch (PDOException $e) {
    error_log("BMI history fetch error: " . $e->getMessage());
    $bmi_history = [];
}

// Fetch current diet plan with error handling
try {
    $stmt = $pdo->prepare("
        SELECT goal, dietary_restrictions, activity_level, created_at 
        FROM diet_plans 
        WHERE user_id = ? 
        ORDER BY created_at DESC 
        LIMIT 1
    ");
    $stmt->execute([$user_id]);
    $current_diet = $stmt->fetch();
} catch (PDOException $e) {
    error_log("Diet plan fetch error: " . $e->getMessage());
    $current_diet = false;
}

// Fetch recent exercises with error handling
try {
    $stmt = $pdo->prepare("
        SELECT exercise_type, duration, intensity, completed_at 
        FROM exercise_progress 
        WHERE user_id = ? 
        ORDER BY completed_at DESC 
        LIMIT 5
    ");
    $stmt->execute([$user_id]);
    $recent_exercises = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Exercise fetch error: " . $e->getMessage());
    $recent_exercises = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FitLife</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2>Welcome, <?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?>!</h2>
                <p class="text-muted">Member since: <?php echo date('F Y', strtotime($user['created_at'])); ?></p>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Quick Actions -->
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quick Actions</h5>
                        <div class="d-flex gap-2">
                            <a href="bmi-calculator.php" class="btn btn-primary">Calculate BMI</a>
                            <a href="diet-plans.php" class="btn btn-success">Update Diet Plan</a>
                            <a href="exercise-tips.php" class="btn btn-info text-white">View Exercises</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BMI Summary -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">BMI Summary</h5>
                        <?php if ($latest_bmi): ?>
                            <div class="text-center mb-3">
                                <h2 class="display-4"><?php echo htmlspecialchars(number_format($latest_bmi['bmi'], 1), ENT_QUOTES, 'UTF-8'); ?></h2>
                                <p class="text-muted">Last updated: <?php echo htmlspecialchars(date('M d, Y', strtotime($latest_bmi['calculated_at'])), ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                            <canvas id="bmiChart"></canvas>
                        <?php else: ?>
                            <p class="text-center">No BMI data available. <a href="bmi-calculator.php">Calculate your BMI</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Current Diet Plan -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Current Diet Plan</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        // Fetch user's current diet plan
                        $stmt = $pdo->prepare("SELECT * FROM user_diet_plans WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
                        $stmt->execute([$_SESSION['user_id']]);
                        $diet_plan = $stmt->fetch();

                        if ($diet_plan) {
                            echo '<div class="diet-plan-info">';
                            echo '<h6 class="mb-3">' . htmlspecialchars($diet_plan['diet_name']) . '</h6>';
                            echo '<p class="mb-2"><strong>Type:</strong> ' . ucfirst(htmlspecialchars($diet_plan['diet_type'])) . '</p>';
                            echo '<p class="mb-2"><strong>Daily Calories:</strong> ' . htmlspecialchars($diet_plan['daily_calories']) . '</p>';
                            echo '<p class="mb-0"><strong>Started:</strong> ' . date('F j, Y', strtotime($diet_plan['created_at'])) . '</p>';
                            echo '</div>';
                        } else {
                            echo '<p class="text-muted">No diet plan selected yet. <a href="diet-plans.php">Choose a diet plan</a></p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer class="footer mt-5 py-4 bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="mb-3">About Us</h5>
                    <p class="mb-0">Your trusted partner in health and fitness. We provide personalized solutions to help you achieve your wellness goals.</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="dashboard.php" class="text-white text-decoration-none">Dashboard</a></li>
                        <li><a href="diet-plans.php" class="text-white text-decoration-none">Diet Plans</a></li>
                        <li><a href="exercise-tips.php" class="text-white text-decoration-none">Exercise Tips</a></li>
                        <li><a href="progress.php" class="text-white text-decoration-none">Progress</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> fitlife3439@gmail.com</li>
                        <li><i class="fas fa-phone me-2"></i>+91 7008624661</li>
                      
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-light">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> Fitness Tracker. All rights reserved.</p>
                </div>
               
            </div>
        </div>
    </footer>

    <style>
    .footer {
        background: linear-gradient(to right, #1a1a1a, #2d2d2d);
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .footer h5 {
        color: #4CAF50;
        font-weight: 600;
    }
    
    .footer a {
        transition: color 0.3s ease;
    }
    
    .footer a:hover {
        color: #4CAF50 !important;
    }
    
    .footer .social-icons a {
        display: inline-block;
        width: 35px;
        height: 35px;
        line-height: 35px;
        text-align: center;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .footer .social-icons a:hover {
        background: #4CAF50;
        transform: translateY(-3px);
    }
    
    .footer hr {
        opacity: 0.1;
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    
    <?php if ($latest_bmi && $bmi_history): ?>
    <script>
        // BMI Chart
        const ctx = document.getElementById('bmiChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($bmi_history, 'date')); ?>,
                datasets: [{
                    label: 'BMI History',
                    data: <?php echo json_encode(array_column($bmi_history, 'bmi')); ?>,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
    </script>
    <?php endif; ?>
</body>
</html> 