<?php
include_once 'config.php';
include_once 'header.php';
?>
<main>
    <section class="page-banner" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 60px 0; color: white; text-align: center;">
        <div class="container">
            <h1>Terms & Conditions</h1>
            <p>Please read our terms carefully</p>
        </div>
    </section>
    <section style="padding: 80px 0;">
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto; background: var(--white); padding: 40px; border-radius: 16px; box-shadow: var(--shadow);">
                <h2 style="color: var(--primary); margin-bottom: 20px;">1. Introduction</h2>
                <p style="color: var(--text-light); line-height: 1.8; margin-bottom: 20px;">Welcome to <?php echo SITE_NAME; ?>. By using our website, you agree to these terms and conditions. Please read them carefully.</p>
                
                <h2 style="color: var(--primary); margin-bottom: 20px;">2. Property Listings</h2>
                <p style="color: var(--text-light); line-height: 1.8; margin-bottom: 20px;">All property listings on this website are provided for informational purposes. We strive to ensure accuracy but cannot guarantee all information is current or correct.</p>
                
                <h2 style="color: var(--primary); margin-bottom: 20px;">3. User Accounts</h2>
                <p style="color: var(--text-light); line-height: 1.8; margin-bottom: 20px;">Users are responsible for maintaining the confidentiality of their account credentials. Any activity under your account is your responsibility.</p>
                
                <h2 style="color: var(--primary); margin-bottom: 20px;">4. Privacy</h2>
                <p style="color: var(--text-light); line-height: 1.8; margin-bottom: 20px;">We respect your privacy. Please see our Privacy Policy for details on how we handle your personal information.</p>
                
                <h2 style="color: var(--primary); margin-bottom: 20px;">5. Contact</h2>
                <p style="color: var(--text-light); line-height: 1.8;">If you have questions about these terms, please <a href="contact.php" style="color: var(--secondary);">contact us</a>.</p>
            </div>
        </div>
    </section>
</main>
<?php include_once 'footer.php'; ?>