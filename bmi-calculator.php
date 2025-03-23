<?php
session_start();
require_once 'config/database.php';

$bmi = '';
$bmi_category = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $height = floatval($_POST['height']); // in cm
    $weight = floatval($_POST['weight']); // in kg
    $age = intval($_POST['age']);

    if ($height <= 0 || $weight <= 0 || $age <= 0) {
        $error = 'Please enter valid values';
    } else {
        // Convert height to meters
        $height_m = $height / 100;
        
        // Calculate BMI
        $bmi = round($weight / ($height_m * $height_m), 1);
        
        // Determine BMI category
        if ($bmi < 18.5) {
            $bmi_category = 'Underweight';
        } elseif ($bmi < 25) {
            $bmi_category = 'Normal weight';
        } elseif ($bmi < 30) {
            $bmi_category = 'Overweight';
        } else {
            $bmi_category = 'Obese';
        }

        // If user is logged in, save BMI history
        if (isset($_SESSION['user_id'])) {
            $stmt = $pdo->prepare("INSERT INTO bmi_history (user_id, bmi, weight, height, age, calculated_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$_SESSION['user_id'], $bmi, $weight, $height, $age]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator - FitLife</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container">
        <div class="bmi-calculator">
            <h2 class="text-center mb-4">BMI Calculator</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="bmi-calculator.php">
                <div class="mb-3">
                    <label for="height" class="form-label">Height (cm)</label>
                    <input type="number" class="form-control" id="height" name="height" required min="1" step="0.1">
                </div>
                <div class="mb-3">
                    <label for="weight" class="form-label">Weight (kg)</label>
                    <input type="number" class="form-control" id="weight" name="weight" required min="1" step="0.1">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age" name="age" required min="1">
                </div>
                <button type="submit" class="btn btn-primary w-100">Calculate BMI</button>
            </form>

            <?php if ($bmi): ?>
                <div class="mt-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3>Your BMI Result</h3>
                            <div class="display-4 my-3"><?php echo $bmi; ?></div>
                            <p class="lead">Category: <strong><?php echo $bmi_category; ?></strong></p>
                            
                            <div class="mt-3">
                                <h4>What does this mean?</h4>
                                <p class="mb-2">BMI Categories:</p>
                                <ul class="list-unstyled">
                                    <li>Underweight = <18.5</li>
                                    <li>Normal weight = 18.5–24.9</li>
                                    <li>Overweight = 25–29.9</li>
                                    <li>Obesity = BMI of 30 or greater</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mt-4">
                <div class="alert alert-info">
                    <h4>Tips for a Healthy BMI</h4>
                    <ul>
                        <li>Maintain a balanced diet</li>
                        <li>Exercise regularly</li>
                        <li>Stay hydrated</li>
                        <li>Get adequate sleep</li>
                        <li>Manage stress levels</li>
                    </ul>
                    <p class="mb-0">
                        <a href="diet-plans.php" class="alert-link">Check out our diet plans</a> or 
                        <a href="exercise-tips.php" class="alert-link">view exercise tips</a> for more guidance.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 