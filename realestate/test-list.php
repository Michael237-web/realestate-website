<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'config.php';
include_once 'header.php';

echo "<h1>Test Page</h1>";
echo "<p>If you can see this, PHP is working.</p>";

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    echo "<p style='color:red;'>❌ You are not logged in. <a href='login.php'>Login here</a></p>";
} else {
    echo "<p style='color:green;'>✅ You are logged in as: " . $_SESSION['user_name'] . "</p>";
}

// Check database connection
if($conn) {
    echo "<p style='color:green;'>✅ Database connected successfully.</p>";
}

// Show form
?>
<style>
    .test-form { max-width: 600px; margin: 20px auto; padding: 20px; background: #f5f5f5; border-radius: 10px; }
    .test-form input, .test-form select, .test-form textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px; }
    .test-form button { background: #e8a838; color: #1a3a5c; padding: 12px 30px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; }
</style>
<div class="test-form">
    <h2>Test Property Form</h2>
    <form method="POST" action="">
        <input type="text" name="title" placeholder="Property Title" required>
        <select name="property_type">
            <option value="sale">For Sale</option>
            <option value="rent">For Rent</option>
            <option value="commercial">Commercial</option>
            <option value="land">Land</option>
        </select>
        <select name="category">
            <option value="">Select Category</option>
            <option value="apartment">Apartment</option>
            <option value="villa">Villa</option>
            <option value="townhouse">Townhouse</option>
            <option value="house">House</option>
        </select>
        <input type="number" name="price" placeholder="Price" required>
        <input type="text" name="location" placeholder="Location" required>
        <input type="number" name="bedrooms" placeholder="Bedrooms" value="0">
        <input type="number" name="bathrooms" placeholder="Bathrooms" value="0">
        <input type="text" name="land_size" placeholder="Land Size">
        <textarea name="description" placeholder="Description"></textarea>
        <button type="submit">Submit Test</button>
    </form>
</div>
<?php
// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'])) {
    echo "<h3>Form Submitted!</h3>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $property_type = mysqli_real_escape_string($conn, $_POST['property_type']);
    $category = mysqli_real_escape_string($conn, $_POST['category'] ?? '');
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $bedrooms = intval($_POST['bedrooms'] ?? 0);
    $bathrooms = intval($_POST['bathrooms'] ?? 0);
    $land_size = mysqli_real_escape_string($conn, $_POST['land_size'] ?? '');
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
    
    $query = "INSERT INTO properties (title, property_type, category, price, location, bedrooms, bathrooms, land_size, description, agent_id) 
              VALUES ('$title', '$property_type', '$category', '$price', '$location', $bedrooms, $bathrooms, '$land_size', '$description', {$_SESSION['user_id']})";
    
    echo "<p><strong>SQL Query:</strong></p>";
    echo "<code>" . $query . "</code><br><br>";
    
    if(mysqli_query($conn, $query)) {
        echo "<p style='color:green;'>✅ Property inserted successfully! ID: " . mysqli_insert_id($conn) . "</p>";
    } else {
        echo "<p style='color:red;'>❌ Error: " . mysqli_error($conn) . "</p>";
    }
}

include_once 'footer.php';
?>