<?php
session_start();
require_once 'config/database.php';

// Array of exercise categories and their details
$exercise_categories = [
    'cardio' => [
        'title' => 'Cardio Exercises',
        'description' => 'Improve your heart health and burn calories with these cardio workouts.',
        'exercises' => [
            [
                'name' => 'Running',
                'description' => 'Great for overall fitness and weight loss.',
             
                'video' => 'https://www.youtube.com/embed/5umbf4ps0GQ',
                'tips' => [
                    'Start with a proper warm-up',
                    'Maintain good posture',
                    'Land midfoot',
                    'Keep a steady pace'
                ]
            ],
            [
                'name' => 'Jump Rope',
                'description' => 'Excellent for coordination and calorie burning.',
               
                'video' => 'https://www.youtube.com/embed/FJmRQ5iTXKE',
                'tips' => [
                    'Keep your jumps small',
                    'Stay on the balls of your feet',
                    'Keep your elbows close to your body',
                    'Start with short intervals'
                ]
            ]
        ]
    ],
    'strength' => [
        'title' => 'Strength Training',
        'description' => 'Build muscle and increase strength with these exercises.',
        'exercises' => [
            [
                'name' => 'Push-ups',
                'description' => 'Classic bodyweight exercise for upper body strength.',
              
                'video' => 'https://www.youtube.com/embed/IODxDxX7oi4',
                'tips' => [
                    'Keep your body straight',
                    'Position hands shoulder-width apart',
                    'Lower your chest to the ground',
                    'Breathe steadily'
                ]
            ],
            [
                'name' => 'Squats',
                'description' => 'Essential exercise for lower body strength.',
               
                'video' => 'https://www.youtube.com/embed/YaXPRqUwItQ',
                'tips' => [
                    'Keep your feet shoulder-width apart',
                    'Keep your back straight',
                    'Push your hips back',
                    'Keep your knees aligned with your toes'
                ]
            ]
        ]
    ],
    'flexibility' => [
        'title' => 'Flexibility & Stretching',
        'description' => 'Improve your flexibility and reduce injury risk with these stretches.',
        'exercises' => [
            [
                'name' => 'Yoga Basic Poses',
                'description' => 'Fundamental yoga poses for flexibility.',
               
                'video' => 'https://www.youtube.com/embed/v7AYKMP6rOE',
                'tips' => [
                    'Breathe deeply and steadily',
                    'Move slowly and mindfully',
                    'Don\'t force positions',
                    'Listen to your body'
                ]
            ],
            [
                'name' => 'Dynamic Stretching',
                'description' => 'Active stretches to improve range of motion.',
           
                'video' => 'https://www.youtube.com/embed/nPHfEnZD1Wk',
                'tips' => [
                    'Start with gentle movements',
                    'Gradually increase range of motion',
                    'Keep movements controlled',
                    'Warm up before stretching'
                ]
            ]
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Tips - FitLife</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container">
        <h2 class="text-center mb-4">Exercise Tips & Tutorials</h2>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <h4>Before You Start</h4>
                    <ul>
                        <li>Always consult with a healthcare provider before starting a new exercise program</li>
                        <li>Start slowly and gradually increase intensity</li>
                        <li>Stay hydrated and wear appropriate clothing</li>
                        <li>Listen to your body and rest when needed</li>
                    </ul>
                </div>
            </div>
        </div>

        <?php foreach ($exercise_categories as $category => $data): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h3><?php echo $data['title']; ?></h3>
                    <p class="mb-0"><?php echo $data['description']; ?></p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($data['exercises'] as $exercise): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo $exercise['name']; ?></h4>
                                        <p class="card-text"><?php echo $exercise['description']; ?></p>
                                        
                                        <div class="ratio ratio-16x9 mb-3">
                                            <iframe src="<?php echo $exercise['video']; ?>" title="<?php echo $exercise['name']; ?>" allowfullscreen></iframe>
                                        </div>
                                        <h5>Key Tips:</h5>
                                        <ul class="list-group list-group-flush">
                                            <?php foreach ($exercise['tips'] as $tip): ?>
                                                <li class="list-group-item"><?php echo $tip; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 