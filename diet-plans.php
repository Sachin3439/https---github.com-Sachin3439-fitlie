<?php
session_start();
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diet Plans - Fitness & Wellness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .diet-card {
            transition: all 0.3s ease;
            margin-bottom: 20px;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            height: 100%;
        }
        .diet-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .diet-header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }
        .diet-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 25%, transparent 25%),
                        linear-gradient(-45deg, rgba(255,255,255,0.1) 25%, transparent 25%);
            background-size: 60px 60px;
            opacity: 0.1;
        }
        .card-body {
            padding: 25px;
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
        }
        .card-title {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 1.2rem;
            position: relative;
            padding-bottom: 10px;
        }
        .card-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(to right, #4CAF50, #45a049);
            border-radius: 2px;
        }
        .card-text {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 1.2rem;
        }
        .card ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 1.5rem;
        }
        .card ul li {
            padding: 8px 0;
            color: #555;
            position: relative;
            padding-left: 25px;
        }
        .card ul li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #4CAF50;
            font-weight: bold;
        }
        .card p strong {
            color: #2c3e50;
            font-size: 1.1rem;
        }
        .bmi-calculator {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .bmi-result {
            display: none;
            margin-top: 20px;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .bmi-normal {
            background-color: #d4edda;
            color: #155724;
        }
        .bmi-overweight {
            background-color: #fff3cd;
            color: #856404;
        }
        .bmi-underweight {
            background-color: #cce5ff;
            color: #004085;
        }
        .bmi-obese {
            background-color: #f8d7da;
            color: #721c24;
        }
        .recommended-plans {
            display: none;
            padding: 25px;
            margin-top: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .list-group-item {
            border: none;
            padding: 12px 20px;
            margin-bottom: 8px;
            border-radius: 8px;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }
        .list-group-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }
        .meal-plan {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .meal-plan h4 {
            color: #2c3e50;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }
        .meal-plan ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 15px;
        }
        .meal-plan ul li {
            padding: 5px 0;
            color: #555;
            position: relative;
            padding-left: 20px;
        }
        .meal-plan ul li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: #4CAF50;
            font-weight: bold;
        }
        .meal-time {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .diet-category {
            margin-bottom: 40px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
            display: none; /* Hide initially */
        }
        
        .category-header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .category-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 25%, transparent 25%),
                        linear-gradient(-45deg, rgba(255,255,255,0.1) 25%, transparent 25%);
            background-size: 60px 60px;
            opacity: 0.1;
        }
        
        .category-header h2 {
            margin: 0;
            font-size: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .category-header p {
            margin: 10px 0 0;
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .diet-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            transform: translateY(20px);
        }
        
        .diet-card.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .diet-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .diet-type-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 1;
        }
        
        .veg-badge {
            background: #4CAF50;
            color: white;
        }
        
        .nonveg-badge {
            background: #f44336;
            color: white;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .meal-plan {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .meal-plan:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .meal-time {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="diet-header text-center">
        <h1>Diet Plans</h1>
        <p class="lead">Choose from our collection of healthy and nutritious diet plans</p>
    </div>

    <div class="container">
        <?php
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo '<div class="alert alert-info">Please <a href="login.php">login</a> to select a diet plan.</div>';
        }
        ?>

        <!-- Vegetarian Diet Plans -->
        <div class="diet-category">
            <div class="category-header">
                <h2>Vegetarian Diet Plans</h2>
                <p>Healthy and nutritious plant-based meal options</p>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <!-- Mediterranean Diet -->
                <div class="col">
                    <div class="card diet-card">
                        <div class="diet-type-badge veg-badge">Vegetarian</div>
                        <div class="card-body">
                            <h3 class="card-title">Mediterranean Diet</h3>
                            <p class="card-text">Heart-healthy eating plan emphasizing:</p>
                            <ul>
                                <li>Fresh fruits and vegetables</li>
                                <li>Whole grains</li>
                                <li>Lean proteins</li>
                                <li>Healthy fats (olive oil)</li>
                                <li>Fish and seafood</li>
                            </ul>
                            <p><strong>Calories:</strong> 1,500-2,000 per day</p>
                            
                            <?php if (isset($_SESSION['user_id'])): ?>
                            <form action="save_diet_plan.php" method="POST" class="mt-3">
                                <input type="hidden" name="diet_name" value="Mediterranean Diet">
                                <input type="hidden" name="diet_type" value="vegetarian">
                                <input type="hidden" name="daily_calories" value="1,500-2,000">
                                <button type="submit" class="btn btn-success">Select This Plan</button>
                            </form>
                            <?php endif; ?>

                            <div class="meal-plan">
                                <h4>Weekly Indian Meal Plan</h4>
                                <div class="meal-time">Breakfast Options:</div>
                                <ul>
                                    <li>Oats upma with vegetables</li>
                                    <li>Poha with peanuts and curry leaves</li>
                                    <li>Idli with sambar and coconut chutney</li>
                                    <li>Quinoa dosa with mint chutney</li>
                                    <li>Ragi porridge with fruits</li>
                                    <li>Multigrain paratha with curd</li>
                                    <li>Moong dal chilla with vegetables</li>
                                </ul>
                                
                                <div class="meal-time">Lunch Options:</div>
                                <ul>
                                    <li>Brown rice with dal, sabzi, and salad</li>
                                    <li>Quinoa biryani with raita</li>
                                    <li>Whole wheat roti with palak paneer</li>
                                    <li>Millet khichdi with vegetables</li>
                                    <li>Brown rice with fish curry</li>
                                    <li>Multigrain roti with dal makhani</li>
                                    <li>Quinoa pulao with mixed vegetables</li>
                                </ul>
                                
                                <div class="meal-time">Dinner Options:</div>
                                <ul>
                                    <li>Grilled fish with brown rice</li>
                                    <li>Chicken tikka with whole wheat naan</li>
                                    <li>Vegetable curry with quinoa</li>
                                    <li>Dal with multigrain roti</li>
                                    <li>Fish curry with brown rice</li>
                                    <li>Paneer tikka with whole wheat roti</li>
                                    <li>Mixed vegetable curry with quinoa</li>
                                </ul>
                                
                                <div class="meal-time">Snacks Options:</div>
                                <ul>
                                    <li>Mixed nuts and seeds</li>
                                    <li>Fresh fruits with curd</li>
                                    <li>Roasted chana dal</li>
                                    <li>Vegetable sticks with hummus</li>
                                    <li>Makhana (fox nuts)</li>
                                    <li>Mixed fruit chaat</li>
                                    <li>Roasted peanuts with jaggery</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vegetarian Diet -->
                <div class="col">
                    <div class="card diet-card">
                        <div class="diet-type-badge veg-badge">Vegetarian</div>
                        <div class="card-body">
                            <h3 class="card-title">Vegetarian Diet</h3>
                            <p class="card-text">Plant-based nutrition focusing on:</p>
                            <ul>
                                <li>Legumes and beans</li>
                                <li>Nuts and seeds</li>
                                <li>Whole grains</li>
                                <li>Fresh produce</li>
                                <li>Dairy and eggs (optional)</li>
                            </ul>
                            <p><strong>Calories:</strong> 1,400-1,800 per day</p>
                            
                            <?php if (isset($_SESSION['user_id'])): ?>
                            <form action="save_diet_plan.php" method="POST" class="mt-3">
                                <input type="hidden" name="diet_name" value="Vegetarian Diet">
                                <input type="hidden" name="diet_type" value="vegetarian">
                                <input type="hidden" name="daily_calories" value="1,400-1,800">
                                <button type="submit" class="btn btn-success">Select This Plan</button>
                            </form>
                            <?php endif; ?>

                            <div class="meal-plan">
                                <h4>Weekly Indian Vegetarian Meal Plan</h4>
                                <div class="meal-time">Breakfast Options:</div>
                                <ul>
                                    <li>Oats upma with vegetables</li>
                                    <li>Poha with peanuts</li>
                                    <li>Idli with sambar</li>
                                    <li>Moong dal chilla</li>
                                    <li>Ragi porridge</li>
                                    <li>Multigrain paratha with curd</li>
                                    <li>Quinoa upma</li>
                                </ul>
                                
                                <div class="meal-time">Lunch Options:</div>
                                <ul>
                                    <li>Dal with brown rice and sabzi</li>
                                    <li>Quinoa biryani with raita</li>
                                    <li>Whole wheat roti with palak paneer</li>
                                    <li>Millet khichdi with vegetables</li>
                                    <li>Brown rice with dal makhani</li>
                                    <li>Multigrain roti with mixed vegetables</li>
                                    <li>Quinoa pulao with dal</li>
                                </ul>
                                
                                <div class="meal-time">Dinner Options:</div>
                                <ul>
                                    <li>Paneer tikka with whole wheat roti</li>
                                    <li>Dal with multigrain roti</li>
                                    <li>Vegetable curry with brown rice</li>
                                    <li>Paneer butter masala with roti</li>
                                    <li>Mixed vegetable curry with quinoa</li>
                                    <li>Dal makhani with brown rice</li>
                                    <li>Vegetable biryani with raita</li>
                                </ul>
                                
                                <div class="meal-time">Snacks Options:</div>
                                <ul>
                                    <li>Mixed nuts and seeds</li>
                                    <li>Fresh fruits with curd</li>
                                    <li>Roasted chana dal</li>
                                    <li>Vegetable sticks with hummus</li>
                                    <li>Makhana (fox nuts)</li>
                                    <li>Mixed fruit chaat</li>
                                    <li>Roasted peanuts with jaggery</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Intermittent Fasting (Veg) -->
                <div class="col">
                    <div class="card diet-card">
                        <div class="diet-type-badge veg-badge">Vegetarian</div>
                        <div class="card-body">
                            <h3 class="card-title">Intermittent Fasting</h3>
                            <p class="card-text">Time-restricted eating pattern:</p>
                            <ul>
                                <li>16/8 method</li>
                                <li>5:2 diet</li>
                                <li>Eat-Stop-Eat</li>
                                <li>Flexible eating windows</li>
                                <li>Regular exercise</li>
                            </ul>
                            <p><strong>Schedule:</strong> Varies by method</p>
                            
                            <?php if (isset($_SESSION['user_id'])): ?>
                            <form action="save_diet_plan.php" method="POST" class="mt-3">
                                <input type="hidden" name="diet_name" value="Intermittent Fasting">
                                <input type="hidden" name="diet_type" value="vegetarian">
                                <input type="hidden" name="daily_calories" value="Varies by method">
                                <button type="submit" class="btn btn-success">Select This Plan</button>
                            </form>
                            <?php endif; ?>

                            <div class="meal-plan">
                                <h4>Weekly Indian Intermittent Fasting Meal Plan (16/8 Method)</h4>
                                <div class="meal-time">Breakfast (10:00 AM):</div>
                                <ul>
                                    <li>Oats upma with vegetables</li>
                                    <li>Poha with peanuts and curry leaves</li>
                                    <li>Idli with sambar</li>
                                    <li>Moong dal chilla with vegetables</li>
                                    <li>Ragi porridge with fruits</li>
                                    <li>Multigrain paratha with curd</li>
                                    <li>Quinoa upma with vegetables</li>
                                </ul>
                                
                                <div class="meal-time">Lunch (2:00 PM):</div>
                                <ul>
                                    <li>Brown rice with dal and sabzi</li>
                                    <li>Quinoa biryani with raita</li>
                                    <li>Whole wheat roti with palak paneer</li>
                                    <li>Millet khichdi with vegetables</li>
                                    <li>Brown rice with fish curry</li>
                                    <li>Multigrain roti with dal makhani</li>
                                    <li>Quinoa pulao with mixed vegetables</li>
                                </ul>
                                
                                <div class="meal-time">Dinner (6:00 PM):</div>
                                <ul>
                                    <li>Grilled fish with brown rice</li>
                                    <li>Chicken tikka with whole wheat naan</li>
                                    <li>Vegetable curry with quinoa</li>
                                    <li>Dal with multigrain roti</li>
                                    <li>Fish curry with brown rice</li>
                                    <li>Paneer tikka with whole wheat roti</li>
                                    <li>Mixed vegetable curry with quinoa</li>
                                </ul>
                                
                                <div class="meal-time">Snacks (Between Meals):</div>
                                <ul>
                                    <li>Mixed nuts and seeds</li>
                                    <li>Fresh fruits with curd</li>
                                    <li>Roasted chana dal</li>
                                    <li>Vegetable sticks with hummus</li>
                                    <li>Makhana (fox nuts)</li>
                                    <li>Mixed fruit chaat</li>
                                    <li>Roasted peanuts with jaggery</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Non-Vegetarian Diet Plans -->
        <div class="diet-category">
            <div class="category-header">
                <h2>Non-Vegetarian Diet Plans</h2>
                <p>Protein-rich meal options including meat and seafood</p>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <!-- Keto Diet -->
                <div class="col">
                    <div class="card diet-card">
                        <div class="diet-type-badge nonveg-badge">Non-Vegetarian</div>
                        <div class="card-body">
                            <h3 class="card-title">Ketogenic Diet</h3>
                            <p class="card-text">Low-carb, high-fat diet including:</p>
                            <ul>
                                <li>Healthy fats (75%)</li>
                                <li>Moderate protein (20%)</li>
                                <li>Very low carbs (5%)</li>
                                <li>Meat and fatty fish</li>
                                <li>Eggs and dairy</li>
                            </ul>
                            <p><strong>Calories:</strong> 1,600-2,200 per day</p>
                            
                            <?php if (isset($_SESSION['user_id'])): ?>
                            <form action="save_diet_plan.php" method="POST" class="mt-3">
                                <input type="hidden" name="diet_name" value="Ketogenic Diet">
                                <input type="hidden" name="diet_type" value="non-vegetarian">
                                <input type="hidden" name="daily_calories" value="1,600-2,200">
                                <button type="submit" class="btn btn-success">Select This Plan</button>
                            </form>
                            <?php endif; ?>

                            <div class="meal-plan">
                                <h4>Weekly Indian Keto Meal Plan</h4>
                                <div class="meal-time">Breakfast Options:</div>
                                <ul>
                                    <li>Egg bhurji with cheese</li>
                                    <li>Paneer paratha with butter</li>
                                    <li>Keto upma with vegetables</li>
                                    <li>Egg curry with cauliflower rice</li>
                                    <li>Cheese omelette with vegetables</li>
                                    <li>Paneer bhurji with butter</li>
                                    <li>Keto dosa with coconut chutney</li>
                                </ul>
                                
                                <div class="meal-time">Lunch Options:</div>
                                <ul>
                                    <li>Chicken curry with cauliflower rice</li>
                                    <li>Paneer tikka with salad</li>
                                    <li>Mutton curry with cauliflower rice</li>
                                    <li>Fish curry with vegetables</li>
                                    <li>Egg curry with cauliflower rice</li>
                                    <li>Chicken tikka with salad</li>
                                    <li>Paneer butter masala with vegetables</li>
                                </ul>
                                
                                <div class="meal-time">Dinner Options:</div>
                                <ul>
                                    <li>Grilled fish with vegetables</li>
                                    <li>Chicken tikka with salad</li>
                                    <li>Paneer curry with vegetables</li>
                                    <li>Mutton curry with cauliflower rice</li>
                                    <li>Fish curry with vegetables</li>
                                    <li>Chicken curry with cauliflower rice</li>
                                    <li>Paneer tikka with salad</li>
                                </ul>
                                
                                <div class="meal-time">Snacks Options:</div>
                                <ul>
                                    <li>Cheese cubes</li>
                                    <li>Roasted peanuts</li>
                                    <li>Almonds and walnuts</li>
                                    <li>Paneer cubes</li>
                                    <li>Boiled eggs</li>
                                    <li>Keto ladoo (made with nuts)</li>
                                    <li>Cheese chips</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Low-Carb Diet -->
                <div class="col">
                    <div class="card diet-card">
                        <div class="diet-type-badge nonveg-badge">Non-Vegetarian</div>
                        <div class="card-body">
                            <h3 class="card-title">Low-Carb Diet</h3>
                            <p class="card-text">Reduced carbohydrate intake:</p>
                            <ul>
                                <li>High protein foods</li>
                                <li>Healthy fats</li>
                                <li>Limited grains</li>
                                <li>No refined sugars</li>
                                <li>Plenty of vegetables</li>
                            </ul>
                            <p><strong>Calories:</strong> 1,500-1,800 per day</p>
                            
                            <?php if (isset($_SESSION['user_id'])): ?>
                            <form action="save_diet_plan.php" method="POST" class="mt-3">
                                <input type="hidden" name="diet_name" value="Low-Carb Diet">
                                <input type="hidden" name="diet_type" value="non-vegetarian">
                                <input type="hidden" name="daily_calories" value="1,500-1,800">
                                <button type="submit" class="btn btn-success">Select This Plan</button>
                            </form>
                            <?php endif; ?>

                            <div class="meal-plan">
                                <h4>Weekly Indian Low-Carb Meal Plan</h4>
                                <div class="meal-time">Breakfast Options:</div>
                                <ul>
                                    <li>Egg bhurji with vegetables</li>
                                    <li>Paneer paratha with curd</li>
                                    <li>Moong dal chilla with vegetables</li>
                                    <li>Egg curry with cauliflower rice</li>
                                    <li>Paneer bhurji with vegetables</li>
                                    <li>Low-carb dosa with coconut chutney</li>
                                    <li>Vegetable omelette with cheese</li>
                                </ul>
                                
                                <div class="meal-time">Lunch Options:</div>
                                <ul>
                                    <li>Chicken curry with cauliflower rice</li>
                                    <li>Paneer tikka with salad</li>
                                    <li>Fish curry with vegetables</li>
                                    <li>Egg curry with cauliflower rice</li>
                                    <li>Chicken tikka with salad</li>
                                    <li>Paneer butter masala with vegetables</li>
                                    <li>Mutton curry with cauliflower rice</li>
                                </ul>
                                
                                <div class="meal-time">Dinner Options:</div>
                                <ul>
                                    <li>Grilled fish with vegetables</li>
                                    <li>Chicken tikka with salad</li>
                                    <li>Paneer curry with vegetables</li>
                                    <li>Mutton curry with cauliflower rice</li>
                                    <li>Fish curry with vegetables</li>
                                    <li>Chicken curry with cauliflower rice</li>
                                    <li>Paneer tikka with salad</li>
                                </ul>
                                
                                <div class="meal-time">Snacks Options:</div>
                                <ul>
                                    <li>Cheese cubes</li>
                                    <li>Roasted peanuts</li>
                                    <li>Almonds and walnuts</li>
                                    <li>Paneer cubes</li>
                                    <li>Boiled eggs</li>
                                    <li>Mixed nuts and seeds</li>
                                    <li>Vegetable sticks with hummus</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paleo Diet -->
                <div class="col">
                    <div class="card diet-card">
                        <div class="diet-type-badge nonveg-badge">Non-Vegetarian</div>
                        <div class="card-body">
                            <h3 class="card-title">Paleo Diet</h3>
                            <p class="card-text">Ancient eating patterns including:</p>
                            <ul>
                                <li>Lean meats</li>
                                <li>Fish and seafood</li>
                                <li>Fruits and vegetables</li>
                                <li>Nuts and seeds</li>
                                <li>No processed foods</li>
                            </ul>
                            <p><strong>Calories:</strong> 1,800-2,200 per day</p>
                            
                            <?php if (isset($_SESSION['user_id'])): ?>
                            <form action="save_diet_plan.php" method="POST" class="mt-3">
                                <input type="hidden" name="diet_name" value="Paleo Diet">
                                <input type="hidden" name="diet_type" value="non-vegetarian">
                                <input type="hidden" name="daily_calories" value="1,800-2,200">
                                <button type="submit" class="btn btn-success">Select This Plan</button>
                            </form>
                            <?php endif; ?>

                            <div class="meal-plan">
                                <h4>Weekly Indian Paleo Meal Plan</h4>
                                <div class="meal-time">Breakfast Options:</div>
                                <ul>
                                    <li>Egg bhurji with vegetables</li>
                                    <li>Paleo upma with vegetables</li>
                                    <li>Egg curry with cauliflower rice</li>
                                    <li>Vegetable omelette with coconut</li>
                                    <li>Paleo dosa with coconut chutney</li>
                                    <li>Egg and vegetable scramble</li>
                                    <li>Paleo paratha with vegetables</li>
                                </ul>
                                
                                <div class="meal-time">Lunch Options:</div>
                                <ul>
                                    <li>Chicken curry with cauliflower rice</li>
                                    <li>Fish curry with vegetables</li>
                                    <li>Mutton curry with cauliflower rice</li>
                                    <li>Egg curry with vegetables</li>
                                    <li>Chicken tikka with salad</li>
                                    <li>Fish tikka with vegetables</li>
                                    <li>Mutton tikka with salad</li>
                                </ul>
                                
                                <div class="meal-time">Dinner Options:</div>
                                <ul>
                                    <li>Grilled fish with vegetables</li>
                                    <li>Chicken tikka with salad</li>
                                    <li>Paneer tikka with vegetables</li>
                                    <li>Mutton curry with cauliflower rice</li>
                                    <li>Fish curry with vegetables</li>
                                    <li>Chicken curry with cauliflower rice</li>
                                    <li>Mixed meat curry with vegetables</li>
                                </ul>
                                
                                <div class="meal-time">Snacks Options:</div>
                                <ul>
                                    <li>Mixed nuts and seeds</li>
                                    <li>Fresh fruits</li>
                                    <li>Roasted peanuts</li>
                                    <li>Almonds and walnuts</li>
                                    <li>Boiled eggs</li>
                                    <li>Mixed fruit chaat</li>
                                    <li>Roasted coconut pieces</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show all diet categories
        document.querySelectorAll('.diet-category').forEach(category => {
            category.style.display = 'block';
        });

        // Initialize animations
        animateCards();
    });

    // Add animation for diet cards
    function animateCards() {
        const cards = document.querySelectorAll('.diet-card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1
        });

        cards.forEach(card => {
            observer.observe(card);
        });
    }
    </script>
</body>
</html> 