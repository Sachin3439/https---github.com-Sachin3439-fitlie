-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS fitness_db;
USE fitness_db;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- BMI history table
CREATE TABLE IF NOT EXISTS bmi_history (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    bmi DECIMAL(4,1) NOT NULL,
    weight DECIMAL(5,2) NOT NULL,
    height DECIMAL(5,2) NOT NULL,
    age INT NOT NULL,
    calculated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Diet plans table
CREATE TABLE IF NOT EXISTS diet_plans (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    goal ENUM('weight_loss', 'weight_gain', 'maintenance', 'muscle_gain') NOT NULL,
    dietary_restrictions VARCHAR(255),
    activity_level ENUM('sedentary', 'light', 'moderate', 'very_active') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);




-- Create password_resets table
CREATE TABLE IF NOT EXISTS password_resets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL
);

-- Insert sample data for testing (optional)
INSERT INTO users (name, email, password) VALUES
('Test User', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- password: password

-- Sample BMI history
INSERT INTO bmi_history (user_id, bmi, weight, height, age) VALUES
(1, 22.5, 70.5, 175.0, 30),
(1, 22.1, 69.8, 175.0, 30),
(1, 21.8, 68.5, 175.0, 30),
(1, 21.5, 67.9, 175.0, 30),
(1, 21.2, 67.0, 175.0, 30);
