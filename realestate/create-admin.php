<?php
include_once 'config.php';

// First, check if users table has any data
$check = "SELECT * FROM users";
$result = mysqli_query($conn, $check);
$count = mysqli_num_rows($result);

echo "<h2>Current Users: $count</h2>";

if($count > 0) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['fullname']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['role']}</td>";
        echo "</tr>";
    }
    echo "</table><br>";
}

// Delete existing admin if any
mysqli_query($conn, "DELETE FROM users WHERE email = 'admin@gmail.com' OR fullname = 'admin'");

// Create new admin
$password = password_hash('admin123', PASSWORD_DEFAULT);
$query = "INSERT INTO users (fullname, email, password, role) VALUES 
    ('admin', 'admin@gmail.com', '$password', 'admin')";

if(mysqli_query($conn, $query)) {
    echo "✅ Admin user created successfully!<br><br>";
    
    // Show the new admin
    $result = mysqli_query($conn, "SELECT id, fullname, email, role FROM users");
    echo "<strong>All Users Now:</strong><br>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['fullname']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['role']}</td>";
        echo "</tr>";
    }
    echo "</table><br>";
    
    echo "🔐 <strong>Login Details:</strong><br>";
    echo "Username: <strong>admin</strong><br>";
    echo "Email: <strong>admin@gmail.com</strong><br>";
    echo "Password: <strong>admin123</strong><br><br>";
    
    echo "<a href='login.php' style='display:inline-block; background:#e8a838; color:#1a3a5c; padding:12px 30px; border-radius:30px; font-weight:700; text-decoration:none;'>Go to Login</a>";
} else {
    echo "❌ Error: " . mysqli_error($conn);
}
?>