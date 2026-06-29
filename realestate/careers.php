<?php
include_once 'config.php';
include_once 'includes/header.php';
?>
<main>
    <section class="page-banner" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 60px 0; color: white; text-align: center;">
        <div class="container">
            <h1>Careers at <?php echo SITE_NAME; ?></h1>
            <p>Join our growing team of real estate professionals</p>
        </div>
    </section>
    <section style="padding: 80px 0;">
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto; background: var(--white); padding: 40px; border-radius: 16px; box-shadow: var(--shadow);">
                <h2 style="color: var(--primary); margin-bottom: 20px;">Why Work With Us?</h2>
                <p style="color: var(--text-light); line-height: 1.8; margin-bottom: 30px;">At <?php echo SITE_NAME; ?>, we're building the future of real estate in Kenya. Join a team that values excellence, innovation, and customer service.</p>
                <h2 style="color: var(--primary); margin-bottom: 20px;">Current Openings</h2>
                <div style="margin-bottom: 30px;">
                    <div style="padding: 20px; border: 1px solid #eee; border-radius: 10px; margin-bottom: 15px;">
                        <h3 style="color: var(--primary);">Real Estate Agent</h3>
                        <p style="color: var(--text-light);">Join our sales team and help clients find their dream homes.</p>
                        <p style="color: var(--text-light); font-size: 14px;"><strong>Location:</strong> Nairobi | <strong>Type:</strong> Full-time</p>
                    </div>
                    <div style="padding: 20px; border: 1px solid #eee; border-radius: 10px; margin-bottom: 15px;">
                        <h3 style="color: var(--primary);">Property Manager</h3>
                        <p style="color: var(--text-light);">Manage our growing portfolio of properties.</p>
                        <p style="color: var(--text-light); font-size: 14px;"><strong>Location:</strong> Nairobi | <strong>Type:</strong> Full-time</p>
                    </div>
                    <div style="padding: 20px; border: 1px solid #eee; border-radius: 10px;">
                        <h3 style="color: var(--primary);">Digital Marketing Specialist</h3>
                        <p style="color: var(--text-light);">Help us reach more clients through digital channels.</p>
                        <p style="color: var(--text-light); font-size: 14px;"><strong>Location:</strong> Remote | <strong>Type:</strong> Part-time</p>
                    </div>
                </div>
                <div style="background: var(--bg-light); padding: 30px; border-radius: 12px; text-align: center;">
                    <h3 style="color: var(--primary); margin-bottom: 10px;">Interested in Joining?</h3>
                    <p style="color: var(--text-light); margin-bottom: 20px;">Send your CV and cover letter to <?php echo ADMIN_EMAIL; ?></p>
                    <a href="mailto:<?php echo ADMIN_EMAIL; ?>" style="display: inline-block; background: var(--secondary); color: var(--primary); padding: 14px 35px; border-radius: 50px; font-weight: 700; transition: var(--transition);">
                        <i class="fas fa-paper-plane"></i> Apply Now
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include_once 'includes/footer.php'; ?>
<script src="assets/js/script.js"></script>