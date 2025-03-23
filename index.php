<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife - Your Fitness Journey Starts Here</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        :root {
            --logo-primary: #00f2fe;
            --logo-secondary: #4facfe;
            --navbar-bg: rgba(10, 10, 10, 0.95);
        }

        .navbar {
            background: var(--navbar-bg) !important;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            --navbar-bg: rgba(0, 0, 0, 0.98);
        }

        .logo-container {
            display: flex;
            align-items: center;
            padding: 0.5rem 1.5rem;
            border-radius: 15px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .logo-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                135deg,
                var(--logo-primary),
                var(--logo-secondary)
            );
            opacity: 0.1;
            transition: opacity 0.3s ease;
        }

        .logo-container:hover::before {
            opacity: 0.2;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(
                135deg,
                var(--logo-primary),
                var(--logo-secondary)
            );
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .logo-icon::after {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: linear-gradient(
                45deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .logo-container:hover .logo-icon::after {
            transform: translateX(100%);
        }

        .logo-icon i {
            color: #fff;
            font-size: 1.5rem;
            position: relative;
            z-index: 1;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(
                135deg,
                var(--logo-primary),
                var(--logo-secondary)
            );
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        @media (max-width: 768px) {
            .logo-text {
                font-size: 1.5rem;
            }
        }

        /* Fitness Importance Section Styles */
        .fitness-importance {
            background-color: #f8f9fa;
        }

        .fitness-image-card {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .fitness-image-card:hover {
            transform: translateY(-5px);
        }

        .fitness-image-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .fitness-image-card:hover img {
            transform: scale(1.05);
        }

        .section-title {
            color: #333;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 1rem;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: #28a745;
        }

        .benefit-item {
            padding: 1.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .benefit-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .benefit-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(40, 167, 69, 0.1);
            border-radius: 50%;
        }

        .benefit-icon i {
            font-size: 1.3rem;
        }

        .benefit-item h4 {
            color: #333;
            font-weight: 600;
        }

        .benefit-item p {
            margin-left: 3.5rem;
            line-height: 1.6;
            color: #666;
        }

        .lead {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
        }

        /* New Stylish Logo Styles */
        .navbar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            padding: 0.5rem 0;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: linear-gradient(135deg, #2b2b2b, #1a1a1a);
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .logo-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
            transition: all 0.3s ease;
        }

        .logo-container:hover::before {
            opacity: 0.15;
            transform: translateY(-2px);
        }

        .logo-icon {
            position: relative;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #00f2fe, #4facfe);
            border-radius: 10px;
            transform: rotate(-5deg);
            transition: all 0.3s ease;
        }

        .logo-icon::after {
            content: '';
            position: absolute;
            inset: -1px;
            background: linear-gradient(135deg, #00f2fe, #4facfe);
            filter: blur(8px);
            opacity: 0.4;
            transition: all 0.3s ease;
            z-index: -1;
        }

        .logo-container:hover .logo-icon {
            transform: rotate(0deg) scale(1.05);
        }

        .logo-container:hover .logo-icon::after {
            opacity: 0.6;
            filter: blur(12px);
        }

        .logo-icon i {
            color: #fff;
            font-size: 1.5rem;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            background: linear-gradient(135deg, #fff 30%, #b8b8b8);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .logo-text span {
            color: #00f2fe;
            position: relative;
        }

        .logo-text span::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #00f2fe, transparent);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .logo-container:hover .logo-text span::after {
            transform: scaleX(1);
        }

        @media (max-width: 768px) {
            .logo-text {
                font-size: 1.5rem;
            }
            .logo-icon {
                width: 35px;
                height: 35px;
            }
            .logo-icon i {
                font-size: 1.2rem;
            }
        }

        /* Navbar Styles */
        .navbar {
            background: #0a0a0a !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: #0a0a0a !important;
            padding: 0.8rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            margin: 0 0.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #00f2fe, #4facfe);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .navbar-toggler {
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
        }

        .navbar-toggler:focus {
            box-shadow: none;
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Hero Section Styles */
        .hero-section {
            position: relative;
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                        url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            text-align: center;
            color: #fff;
            margin-top: -76px;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-section .lead {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .hero-section .btn-primary {
            padding: 1rem 2.5rem;
            font-size: 1.2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: linear-gradient(135deg, #00f2fe, #4facfe);
            border: none;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
            transition: all 0.3s ease;
        }

        .hero-section .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 172, 254, 0.4);
        }

        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.5rem;
            }
            .hero-section .lead {
                font-size: 1.2rem;
            }
        }

        /* Exercise Tips Section Styles */
        .exercise-tips .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .exercise-tips .card:hover {
            transform: translateY(-5px);
        }

        .exercise-tips .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .exercise-tips .card-body {
            padding: 1.5rem;
        }

        .exercise-tips .card-title {
            color: #333;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .exercise-tips .card-text {
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <header class="hero-section">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 text-center text-white">
                    <h1 class="display-4">Transform Your Life with FitLife</h1>
                    <p class="lead">Your personal AI-powered fitness companion</p>
                    <a href="register.php" class="btn btn-primary btn-lg">Start Your Journey</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Why Fitness is Important Section -->
    <section class="fitness-importance py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Why Fitness is Important</h2>
                    <p class="lead text-muted">Discover the transformative power of regular exercise and healthy living</p>
                </div>
            </div>
            
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="fitness-image-card">
                        <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" 
                             alt="Physical Fitness" 
                             class="img-fluid rounded">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fitness-image-card">
                        <img src="https://images.unsplash.com/photo-1518611012118-696072aa579a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" 
                             alt="Mental Wellness" 
                             class="img-fluid rounded">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fitness-image-card">
                        <img src="https://images.unsplash.com/photo-1571902943202-507ec2618e8f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" 
                             alt="Group Fitness" 
                             class="img-fluid rounded">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="fitness-benefits">
                        <div class="benefit-item mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="benefit-icon me-3">
                                    <i class="fas fa-heart text-success"></i>
                                </div>
                                <h4 class="h5 mb-0">Physical Health</h4>
                            </div>
                            <p class="text-muted">Regular exercise strengthens your heart, improves circulation, and boosts your immune system. It helps maintain a healthy weight and reduces the risk of chronic diseases.</p>
                        </div>
                        
                        <div class="benefit-item mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="benefit-icon me-3">
                                    <i class="fas fa-brain text-success"></i>
                                </div>
                                <h4 class="h5 mb-0">Mental Well-being</h4>
                            </div>
                            <p class="text-muted">Exercise releases endorphins that reduce stress and anxiety. It improves sleep quality, enhances focus, and boosts self-confidence.</p>
                        </div>
                        
                        <div class="benefit-item mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="benefit-icon me-3">
                                    <i class="fas fa-bolt text-success"></i>
                                </div>
                                <h4 class="h5 mb-0">Energy & Productivity</h4>
                            </div>
                            <p class="text-muted">Regular physical activity increases energy levels and improves productivity. It helps you stay active throughout the day and perform better in daily tasks.</p>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="d-flex align-items-center mb-3">
                                <div class="benefit-icon me-3">
                                    <i class="fas fa-users text-success"></i>
                                </div>
                                <h4 class="h5 mb-0">Social Benefits</h4>
                            </div>
                            <p class="text-muted">Fitness activities provide opportunities to meet like-minded people, build friendships, and create a supportive community.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-calculator fa-3x mb-3 text-primary"></i>
                            <h3>BMI Calculator</h3>
                            <p>Track your Body Mass Index and set realistic fitness goals.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-utensils fa-3x mb-3 text-primary"></i>
                            <h3>AI Diet Plans</h3>
                            <p>Get personalized diet recommendations powered by AI.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-dumbbell fa-3x mb-3 text-primary"></i>
                            <h3>Exercise Tips</h3>
                            <p>Access expert workout guides with videos and images.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Exercise Tips Section -->
    <section class="exercise-tips py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Exercise Tips</h2>
                    <p class="lead">Get started with these expert-approved tips</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="assets\images\wormup.jpg" 
                             class="card-img-top" alt="Warm-up exercises">
                        <div class="card-body">
                            <h5 class="card-title">Warm Up Properly</h5>
                            <p class="card-text">Start with dynamic stretches and light cardio to prepare your body for exercise.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="assets\images\hydrated.jpg"
                             class="card-img-top" alt="Stay hydrated">
                        <div class="card-body">
                            <h5 class="card-title">Stay Hydrated</h5>
                            <p class="card-text">Drink water before, during, and after your workout to maintain optimal performance.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="assets\images\properfit.jpg"
                             class="card-img-top" alt="Proper form">
                        <div class="card-body">
                            <h5 class="card-title">Maintain Proper Form</h5>
                            <p class="card-text">Focus on correct technique to prevent injuries and maximize results.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>FitLife</h5>
                    <p>Your journey to a healthier lifestyle starts here.</p>
                </div>
                
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to update logo colors based on scroll position
        function updateLogoColors() {
            const scrollPosition = window.scrollY;
            const navbar = document.querySelector('.navbar');
            const root = document.documentElement;

            if (scrollPosition > 50) {
                navbar.classList.add('scrolled');
                root.style.setProperty('--logo-primary', '#00e5ff');
                root.style.setProperty('--logo-secondary', '#2979ff');
            } else {
                navbar.classList.remove('scrolled');
                root.style.setProperty('--logo-primary', '#00f2fe');
                root.style.setProperty('--logo-secondary', '#4facfe');
            }
        }

        // Add scroll event listener
        window.addEventListener('scroll', updateLogoColors);

        // Initialize colors on page load
        document.addEventListener('DOMContentLoaded', updateLogoColors);

        // Function to change logo colors on navbar hover
        document.querySelector('.navbar').addEventListener('mouseenter', () => {
            const root = document.documentElement;
            root.style.setProperty('--logo-primary', '#00e5ff');
            root.style.setProperty('--logo-secondary', '#2979ff');
        });

        document.querySelector('.navbar').addEventListener('mouseleave', () => {
            const root = document.documentElement;
            if (!document.querySelector('.navbar').classList.contains('scrolled')) {
                root.style.setProperty('--logo-primary', '#00f2fe');
                root.style.setProperty('--logo-secondary', '#4facfe');
            }
        });
    </script>
</body>
</html> 