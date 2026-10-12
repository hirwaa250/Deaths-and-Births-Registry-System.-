<?php

$host = 'localhost';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS village_register";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}


$conn->select_db('village_register');

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'officer') DEFAULT 'officer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Users table created successfully<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}
$sql = "CREATE TABLE IF NOT EXISTS birth_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    child_name VARCHAR(100) NOT NULL,
    dob DATE NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    mother_name VARCHAR(100) NOT NULL,
    father_name VARCHAR(100) NOT NULL,
    village VARCHAR(100) NOT NULL,
    sector VARCHAR(100) NOT NULL,
    registered_by INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (registered_by) REFERENCES users(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Birth records table created successfully<br>";
} else {
    echo "Error creating birth_records table: " . $conn->error . "<br>";
}


$admin_password = password_hash('admin123', PASSWORD_DEFAULT);
$sql = "INSERT IGNORE INTO users (name, email, password, role) VALUES 
        ('Administrator', 'admin@village.com', '$admin_password', 'admin'),
        ('Officer One', 'officer@village.com', '" . password_hash('officer123', PASSWORD_DEFAULT) . "', 'officer')";

if ($conn->query($sql) === TRUE) {
    echo "Default users created successfully<br>";
    echo "<strong>Default Login Credentials:</strong><br>";
    echo "Admin: admin@village.com / admin123<br>";
    echo "Officer: officer@village.com / officer123<br>";
} else {
    echo "Error creating default users: " . $conn->error . "<br>";
}

$conn->close();

echo "<br><a href='index.php'>Go to System</a>";
?>
