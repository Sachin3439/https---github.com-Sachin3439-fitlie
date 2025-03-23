<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get user's BMI from database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT bmi FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !$user['bmi']) {
    header('Location: bmi-calculator.php');
    exit();
}

$bmi = $user['bmi'];

// AI Diet Recommendation Logic
function getDietRecommendation($bmi) {
    $recommendations = [
        'underweight' => [
            'title' => 'Calorie Surplus Diet',
            'description' => 'Focus on nutrient-dense foods to gain healthy weight',
            'foods' => [
                'Lean proteins: Chicken, fish, eggs, legumes',
                'Healthy fats: Avocados, nuts, olive oil',
                'Complex carbs: Whole grains, sweet potatoes, quinoa',
                'Calorie-dense foods: Dried fruits, nut butters, whole milk'
            ],
            'meal_plan' => [
                'Breakfast' => 'Oatmeal with banana, honey, and almond butter',
                'Lunch' => 'Grilled chicken salad with avocado and olive oil dressing',
                'Dinner' => 'Salmon with quinoa and roasted vegetables',
                'Snacks' => 'Mixed nuts, dried fruits, protein shakes'
            ],
            'tips' => [
                'Eat 5-6 meals throughout the day',
                'Include protein in every meal',
                'Add healthy fats to meals',
                'Stay hydrated with water and milk'
            ]
        ],
        'normal' => [
            'title' => 'Balanced Maintenance Diet',
            'description' => 'Maintain your healthy weight with a balanced diet',
            'foods' => [
                'Lean proteins: Fish, poultry, eggs',
                'Healthy fats: Nuts, seeds, olive oil',
                'Complex carbs: Whole grains, fruits, vegetables',
                'Dairy: Yogurt, cheese, milk'
            ],
            'meal_plan' => [
                'Breakfast' => 'Greek yogurt with berries and granola',
                'Lunch' => 'Tuna salad with whole grain bread',
                'Dinner' => 'Grilled chicken with brown rice and vegetables',
                'Snacks' => 'Fruits, nuts, yogurt'
            ],
            'tips' => [
                'Eat mindfully and listen to hunger cues',
                'Include variety in your meals',
                'Stay active and maintain regular exercise',
                'Practice portion control'
            ]
        ],
        'overweight' => [
            'title' => 'Calorie Deficit Diet',
            'description' => 'Focus on portion control and nutrient-rich foods',
            'foods' => [
                'Lean proteins: Fish, chicken breast, tofu',
                'Low-calorie vegetables: Leafy greens, broccoli, cauliflower',
                'Complex carbs: Quinoa, brown rice, sweet potatoes',
                'Healthy fats: Olive oil, avocado, nuts (in moderation)'
            ],
            'meal_plan' => [
                'Breakfast' => 'Egg white omelette with vegetables',
                'Lunch' => 'Grilled chicken salad with light dressing',
                'Dinner' => 'Baked fish with steamed vegetables',
                'Snacks' => 'Fresh fruits, raw vegetables'
            ],
            'tips' => [
                'Track your calorie intake',
                'Eat more protein to stay full',
                'Include fiber-rich foods',
                'Stay hydrated and avoid sugary drinks'
            ]
        ],
        'obese' => [
            'title' => 'Weight Management Diet',
            'description' => 'Focus on sustainable weight loss with medical supervision',
            'foods' => [
                'High-protein foods: Lean meats, fish, eggs',
                'Non-starchy vegetables: Leafy greens, broccoli, zucchini',
                'Limited complex carbs: Quinoa, brown rice',
                'Healthy fats: Olive oil, avocado (in moderation)'
            ],
            'meal_plan' => [
                'Breakfast' => 'Protein smoothie with spinach and berries',
                'Lunch' => 'Grilled chicken with mixed vegetables',
                'Dinner' => 'Baked fish with steamed broccoli',
                'Snacks' => 'Raw vegetables, boiled eggs'
            ],
            'tips' => [
                'Consult with a healthcare provider',
                'Track all food intake',
                'Practice portion control',
                'Stay hydrated and avoid processed foods'
            ]
        ]
    ];

    // Determine BMI category
    if ($bmi < 18.5) {
        return $recommendations['underweight'];
    } elseif ($bmi < 25) {
        return $recommendations['normal'];
    } elseif ($bmi < 30) {
        return $recommendations['overweight'];
    } else {
        return $recommendations['obese'];
    }
}

$diet_plan = getDietRecommendation($bmi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Diet Recommendations - FitLife</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .diet-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            margin-bottom: 2rem;
        }

        .diet-card:hover {
            transform: translateY(-5px);
        }

        .diet-header {
            background: linear-gradient(135deg, #00f2fe, #4facfe);
            color: white;
            padding: 2rem;
            border-radius: 15px 15px 0 0;
        }

        .diet-content {
            padding: 2rem;
        }

        .food-list {
            list-style: none;
            padding: 0;
        }

        .food-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }

        .food-list li:last-child {
            border-bottom: none;
        }

        .meal-plan-item {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .tip-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .tip-icon {
            width: 40px;
            height: 40px;
            background: rgba(0, 242, 254, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .tip-icon i {
            color: #00f2fe;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="display-4">Your Personalized Diet Plan</h1>
                <p class="lead">Based on your BMI: <?php echo number_format($bmi, 1); ?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="diet-card">
                    <div class="diet-header">
                        <h2><?php echo $diet_plan['title']; ?></h2>
                        <p class="mb-0"><?php echo $diet_plan['description']; ?></p>
                    </div>
                    <div class="diet-content">
                        <h3 class="mb-4">Recommended Foods</h3>
                        <ul class="food-list">
                            <?php foreach ($diet_plan['foods'] as $food): ?>
                                <li><i class="fas fa-check-circle text-success me-2"></i><?php echo $food; ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <h3 class="mt-4 mb-4">Sample Meal Plan</h3>
                        <?php foreach ($diet_plan['meal_plan'] as $meal => $food): ?>
                            <div class="meal-plan-item">
                                <h5 class="mb-2"><?php echo $meal; ?></h5>
                                <p class="mb-0"><?php echo $food; ?></p>
                            </div>
                        <?php endforeach; ?>

                        <h3 class="mt-4 mb-4">Tips for Success</h3>
                        <?php foreach ($diet_plan['tips'] as $tip): ?>
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <p class="mb-0"><?php echo $tip; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="diet-plans.php" class="btn btn-outline-primary">View All Diet Plans</a>
                    <a href="bmi-calculator.php" class="btn btn-primary ms-2">Update BMI</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 