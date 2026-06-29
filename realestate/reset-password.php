<?php
include_once 'config.php';

// New password
$new_password = 'admin123';
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Update admin password
$query = "UPDATE users SET password = '$hashed_password' WHERE email = 'admin@gmail.com' OR fullname = 'admin'";

if(mysqli_query($conn, $query)) {
    echo "✅ Admin password reset successfully!<br><br>";
    
    // Show updated admin
    $result = mysqli_query($conn, "SELECT id, fullname, email, role FROM users WHERE email = 'admin@gmail.com' OR fullname = 'admin'");
    $user = mysqli_fetch_assoc($result);
    
    echo "<strong>Admin User:</strong><br>";
    echo "ID: {$user['id']}<br>";
    echo "Name: {$user['fullname']}<br>";
    echo "Email: {$user['email']}<br>";
    echo "Role: {$user['role']}<br><br>";
    
    echo "🔐 <strong>Login Details:</strong><br>";
    echo "Username: <strong>admin</strong><br>";
    echo "Email: <strong>admin@gmail.com</strong><br>";
    echo "Password: <strong>admin123</strong>";
} else {
    echo "❌ Error: " . mysqli_error($conn);
}
?>