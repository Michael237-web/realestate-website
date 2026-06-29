<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'realestate_db');

// Site configuration
define('SITE_NAME', 'MH Properties');
define('SITE_URL', 'http://localhost/realestate/');
define('ADMIN_EMAIL', 'admin@gmail.com');
define('PHONE_NUMBER', '+254 700 123 456');
define('WHATSAPP_NUMBER', '+254 700 123 456');

// Database table prefix
define('DB_PREFIX', 'realestate_');

// Database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set timezone
date_default_timezone_set('Africa/Nairobi');

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper function to get prefixed table name
function table($name) {
    return DB_PREFIX . $name;
}

// Make $conn available globally
global $conn;
?>