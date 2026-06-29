<?php
include_once 'config.php';
include_once 'includes/header.php';

$message = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
    $query = "INSERT INTO " . table('inquiries') . " (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$msg')";
    if(mysqli_query($conn, $query)) {
        $message = '<div class="alert alert-success">Thank you! We\'ll get back to you shortly.</div>';
    } else {
        $message = '<div class="alert alert-error">Something went wrong. Please try again.</div>';
    }
}
?>
<main>
    <section class="page-banner" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 60px 0; color: white; text-align: center;">
        <div class="container">
            <h1>Contact Us</h1>
            <p>We're here to help with all your real estate needs</p>
        </div>
    </section>
    <section style="padding: 80px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px;">
                <div>
                    <h2 style="color: var(--primary); font-size: 32px; margin-bottom: 30px;">Get In Touch</h2>
                    <?php echo $message; ?>
                    <form method="POST">
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Full Name</label>
                            <input type="text" name="name" required style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px;">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Email Address</label>
                            <input type="email" name="email" required style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px;">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Phone Number</label>
                            <input type="tel" name="phone" style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px;">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Message</label>
                            <textarea name="message" required rows="5" style="width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; resize: vertical;"></textarea>
                        </div>
                        <button type="submit" style="background: var(--secondary); color: var(--primary); padding: 16px 40px; border: none; border-radius: 50px; font-weight: 700; font-size: 18px; cursor: pointer; transition: var(--transition);">
                            Send Message
                        </button>
                    </form>
                </div>
                <div>
                    <h2 style="color: var(--primary); font-size: 32px; margin-bottom: 30px;">Contact Information</h2>
                    <div style="background: var(--bg-light); padding: 30px; border-radius: 16px;">
                        <div style="margin-bottom: 25px; display: flex; gap: 15px; align-items: flex-start;">
                            <i class="fas fa-map-marker-alt" style="font-size: 24px; color: var(--secondary); margin-top: 5px;"></i>
                            <div>
                                <h4 style="font-weight: 700; margin-bottom: 5px;">Office Location</h4>
                                <p style="color: var(--text-light);">Nairobi, Kenya</p>
                            </div>
                        </div>
                        <div style="margin-bottom: 25px; display: flex; gap: 15px; align-items: flex-start;">
                            <i class="fas fa-phone" style="font-size: 24px; color: var(--secondary); margin-top: 5px;"></i>
                            <div>
                                <h4 style="font-weight: 700; margin-bottom: 5px;">Phone</h4>
                                <p style="color: var(--text-light);"><?php echo PHONE_NUMBER; ?></p>
                            </div>
                        </div>
                        <div style="margin-bottom: 25px; display: flex; gap: 15px; align-items: flex-start;">
                            <i class="fab fa-whatsapp" style="font-size: 24px; color: var(--secondary); margin-top: 5px;"></i>
                            <div>
                                <h4 style="font-weight: 700; margin-bottom: 5px;">WhatsApp</h4>
                                <p style="color: var(--text-light);"><?php echo WHATSAPP_NUMBER; ?></p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 15px; align-items: flex-start;">
                            <i class="fas fa-envelope" style="font-size: 24px; color: var(--secondary); margin-top: 5px;"></i>
                            <div>
                                <h4 style="font-weight: 700; margin-bottom: 5px;">Email</h4>
                                <p style="color: var(--text-light);"><?php echo ADMIN_EMAIL; ?></p>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 30px; background: var(--white); padding: 30px; border-radius: 16px; box-shadow: var(--shadow);">
                        <h3 style="color: var(--primary); margin-bottom: 15px;">Office Hours</h3>
                        <p><strong>Monday - Friday:</strong> 8:00 AM - 6:00 PM</p>
                        <p><strong>Saturday:</strong> 9:00 AM - 4:00 PM</p>
                        <p><strong>Sunday:</strong> Closed</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include_once 'includes/footer.php'; ?>
<script src="assets/js/script.js"></script>