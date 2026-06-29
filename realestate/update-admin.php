<?php
include_once 'config.php';

// Update admin user
$query = "UPDATE users SET 
    email = 'admin@gmail.com',
    fullname = 'admin'
WHERE email = 'admin@mhproperties.com' OR fullname = 'Admin'";

if(mysqli_query($conn, $query)) {
    echo "✅ Admin updated successfully!<br><br>";
    
    // Show updated admin
    $result = mysqli_query($conn, "SELECT id, fullname, email, role FROM users");
    echo "<strong>All Users:</strong><br>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "ID: {$row['id']} | Name: {$row['fullname']} | Email: {$row['email']} | Role: {$row['role']}<br>";
    }
    
    echo "<br><br>🔐 <strong>Login Details:</strong><br>";
    echo "Username: <strong>admin</strong><br>";
    echo "Email: <strong>admin@gmail.com</strong><br>";
    echo "Password: <strong>admin123</strong>";
} else {
    echo "❌ Error: " . mysqli_error($conn);
}
?>