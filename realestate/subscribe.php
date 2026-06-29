<?php
include_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $create_table = "CREATE TABLE IF NOT EXISTS " . table('subscribers') . " (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(100) UNIQUE NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
    mysqli_query($conn, $create_table);
    $query = "INSERT IGNORE INTO " . table('subscribers') . " (email) VALUES ('$email')";
    mysqli_query($conn, $query);
    echo json_encode(['status' => 'success']);
}
?>