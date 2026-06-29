<?php
include_once 'config.php';

if(isset($_SESSION['user_id'])) {
    header('Location: admin/dashboard.php');
    exit();
}

$error = '';
$success = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $check = "SELECT * FROM " . table('users') . " WHERE email = '$email'";
    $result = mysqli_query($conn, $check);
    if(mysqli_num_rows($result) > 0) {
        $error = 'Email already registered!';
    } else {
        $query = "INSERT INTO " . table('users') . " (fullname, email, password) VALUES ('$fullname', '$email', '$password')";
        if(mysqli_query($conn, $query)) {
            $success = 'Registration successful! You can now login.';
        } else {
            $error = 'Registration failed. Please try again.';
        }
    }
}
?>
<?php include_once 'includes/header.php'; ?>
<style>
    .auth-page { padding: 80px 0; background: var(--bg-light); }
    .auth-box { max-width: 450px; margin: 0 auto; background: var(--white); padding: 40px; border-radius: 16px; box-shadow: var(--shadow); }
    .auth-box h2 { text-align: center; color: var(--primary); margin-bottom: 30px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 8px; }
    .form-group input { width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; transition: var(--transition); }
    .form-group input:focus { border-color: var(--primary); outline: none; }
    .btn-primary { background: var(--primary); color: white; padding: 16px; border: none; border-radius: 50px; font-weight: 700; font-size: 18px; cursor: pointer; transition: var(--transition); width: 100%; }
    .btn-primary:hover { background: var(--primary-light); }
    .auth-link { text-align: center; margin-top: 20px; color: var(--text-light); }
    .auth-link a { color: var(--primary); font-weight: 600; }
    .alert { padding: 15px; border-radius: 10px; margin-bottom: 20px; }
    .alert-error { background: #fee; color: #c00; border: 1px solid #fcc; }
    .alert-success { background: #efe; color: #060; border: 1px solid #cfc; }
</style>
<div class="auth-page">
    <div class="container">
        <div class="auth-box">
            <h2>Create Account</h2>
            <?php if($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="fullname" required placeholder="Enter your full name">
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Create a password">
                </div>
                <button type="submit" class="btn-primary">Register</button>
            </form>
            <p class="auth-link">Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>