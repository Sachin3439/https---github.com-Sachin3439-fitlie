# FitLife - Fitness Website

A comprehensive fitness website with user authentication, BMI calculator, AI-powered diet plans, and exercise tips.

## Features

- User Registration and Authentication
- Password Reset Functionality
- BMI Calculator with History Tracking
- AI-Powered Diet Plans
- Exercise Tips with Videos and Images
- Responsive Design
- Modern UI/UX

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Modern web browser

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/fitlife.git
cd fitlife
```

2. Create a MySQL database and import the schema:
```bash
mysql -u root -p < database.sql
```

3. Configure the database connection:
- Open `config/database.php`
- Update the database credentials according to your setup

4. Set up the web server:
- Configure your web server to point to the project directory
- Ensure the `images` directory has write permissions

5. Create required directories:
```bash
mkdir -p images/exercises
chmod 755 images/exercises
```

## Directory Structure

```
fitlife/
├── config/
│   └── database.php
├── css/
│   └── style.css
├── images/
│   └── exercises/
├── includes/
│   ├── navbar.php
│   └── footer.php
├── index.php
├── login.php
├── register.php
├── forgot-password.php
├── bmi-calculator.php
├── diet-plans.php
├── exercise-tips.php
├── database.sql
└── README.md
```

## Usage

1. Start your web server and MySQL service
2. Navigate to the website in your browser
3. Register a new account or login
4. Access features:
   - Calculate and track your BMI
   - Get personalized diet plans
   - View exercise tutorials and tips

## Security Considerations

- All user passwords are hashed using PHP's password_hash()
- SQL injection prevention using prepared statements
- XSS protection through proper output escaping
- CSRF protection implemented
- Secure password reset mechanism

## Customization

- Add more exercise categories in `exercise-tips.php`
- Extend diet plan options in `diet-plans.php`
- Customize the UI by modifying `css/style.css`
- Add more features to the BMI tracking system

## Contributing

1. Fork the repository
2. Create a new branch
3. Make your changes
4. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, please open an issue in the GitHub repository or contact the maintainers. 