<?php
include_once 'config.php';

echo "<h2>Check Admin User</h2>";

// Check if admin exists
$query = "SELECT id, fullname, email, password, role FROM users WHERE email = 'admin@gmail.com' OR fullname = 'admin'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Password Hash</th><th>Role</th></tr>";
    echo "<tr>";
    echo "<td>{$user['id']}</td>";
    echo "<td>{$user['fullname']}</td>";
    echo "<td>{$user['email']}</td>";
    echo "<td style='font-size:11px;'>{$user['password']}</td>";
    echo "<td>{$user['role']}</td>";
    echo "</tr>";
    echo "</table><br>";
    
    // Test the password
    $test_password = 'admin123';
    if(password_verify($test_password, $user['password'])) {
        echo "✅ Password 'admin123' is <span style='color:green;font-weight:bold;'>CORRECT</span><br><br>";
        echo "You should be able to login with:<br>";
        echo "<strong>Username:</strong> admin<br>";
        echo "<strong>Email:</strong> admin@gmail.com<br>";
        echo "<strong>Password:</strong> admin123<br><br>";
        echo "<a href='login.php' style='display:inline-block; background:#e8a838; color:#1a3a5c; padding:12px 30px; border-radius:30px; font-weight:700; text-decoration:none;'>Go to Login</a>";
    } else {
        echo "❌ Password 'admin123' is <span style='color:red;font-weight:bold;'>INCORRECT</span><br><br>";
        echo "Let's fix it...<br>";
        
        // Reset password
        $new_hash = password_hash('admin123', PASSWORD_DEFAULT);
        $update = "UPDATE users SET password = '$new_hash' WHERE id = {$user['id']}";
        if(mysqli_query($conn, $update)) {
            echo "✅ Password has been reset!<br><br>";
            echo "Try logging in now:<br>";
            echo "<strong>Username:</strong> admin<br>";
            echo "<strong>Password:</strong> admin123<br><br>";
            echo "<a href='login.php' style='display:inline-block; background:#e8a838; color:#1a3a5c; padding:12px 30px; border-radius:30px; font-weight:700; text-decoration:none;'>Go to Login</a>";
        }
    }
} else {
    echo "❌ Admin user not found!<br><br>";
    echo "Creating admin user...<br>";
    
    $password = password_hash('admin123', PASSWORD_DEFAULT);
    $insert = "INSERT INTO users (fullname, email, password, role) VALUES ('admin', 'admin@gmail.com', '$password', 'admin')";
    if(mysqli_query($conn, $insert)) {
        echo "✅ Admin created!<br><br>";
        echo "<strong>Username:</strong> admin<br>";
        echo "<strong>Email:</strong> admin@gmail.com<br>";
        echo "<strong>Password:</strong> admin123<br><br>";
        echo "<a href='login.php' style='display:inline-block; background:#e8a838; color:#1a3a5c; padding:12px 30px; border-radius:30px; font-weight:700; text-decoration:none;'>Go to Login</a>";
    }
}
?>