<?php
include_once 'config.php';
include_once 'includes/header.php';
?>
<main>
    <section class="page-banner" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 60px 0; color: white; text-align: center;">
        <div class="container">
            <h1>About <?php echo SITE_NAME; ?></h1>
            <p>Your trusted partner in real estate since 2016</p>
        </div>
    </section>
    <section class="about-content" style="padding: 80px 0;">
        <div class="container">
            <div class="about-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center;">
                <div>
                    <h2 style="color: var(--primary); font-size: 36px; margin-bottom: 20px;">Who We Are</h2>
                    <p style="font-size: 18px; line-height: 1.8; color: var(--text-light); margin-bottom: 20px;">
                        <?php echo SITE_NAME; ?> is a premier real estate agency dedicated to helping Kenyans find their dream homes and investment properties. With over 10 years of experience, we've built a reputation for excellence, integrity, and customer satisfaction.
                    </p>
                    <p style="font-size: 18px; line-height: 1.8; color: var(--text-light); margin-bottom: 20px;">
                        Our team of expert agents understands the Kenyan property market inside out. We leverage our deep local knowledge and extensive network to connect buyers with the perfect properties and help sellers achieve the best returns.
                    </p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 30px;">
                        <div style="background: var(--bg-light); padding: 20px; border-radius: 12px; text-align: center;">
                            <h3 style="color: var(--primary); font-size: 32px;">10+</h3>
                            <p style="color: var(--text-light);">Years Experience</p>
                        </div>
                        <div style="background: var(--bg-light); padding: 20px; border-radius: 12px; text-align: center;">
                            <h3 style="color: var(--primary); font-size: 32px;">500+</h3>
                            <p style="color: var(--text-light);">Properties Sold</p>
                        </div>
                        <div style="background: var(--bg-light); padding: 20px; border-radius: 12px; text-align: center;">
                            <h3 style="color: var(--primary); font-size: 32px;">98%</h3>
                            <p style="color: var(--text-light);">Client Satisfaction</p>
                        </div>
                        <div style="background: var(--bg-light); padding: 20px; border-radius: 12px; text-align: center;">
                            <h3 style="color: var(--primary); font-size: 32px;">50+</h3>
                            <p style="color: var(--text-light);">Expert Agents</p>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- Animated Image Container -->
                    <div class="about-image-container">
                        <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800&q=80" alt="About Us" class="about-animated-image">
                        <div class="image-ring"></div>
                    </div>
                </div>
            </div>
            <div style="margin-top: 80px;">
                <h2 style="text-align: center; color: var(--primary); font-size: 36px; margin-bottom: 40px;">Our Mission & Vision</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                    <div style="background: var(--white); padding: 40px; border-radius: 16px; box-shadow: var(--shadow); text-align: center;">
                        <i class="fas fa-bullseye" style="font-size: 48px; color: var(--secondary); margin-bottom: 20px;"></i>
                        <h3 style="color: var(--primary); font-size: 24px; margin-bottom: 15px;">Our Mission</h3>
                        <p style="color: var(--text-light); font-size: 16px; line-height: 1.8;">To provide exceptional real estate services that exceed client expectations, creating lasting value and building lifelong relationships.</p>
                    </div>
                    <div style="background: var(--white); padding: 40px; border-radius: 16px; box-shadow: var(--shadow); text-align: center;">
                        <i class="fas fa-eye" style="font-size: 48px; color: var(--secondary); margin-bottom: 20px;"></i>
                        <h3 style="color: var(--primary); font-size: 24px; margin-bottom: 15px;">Our Vision</h3>
                        <p style="color: var(--text-light); font-size: 16px; line-height: 1.8;">To be Kenya's most trusted and innovative real estate company, transforming the way people buy, sell, and invest in property.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include_once 'includes/footer.php'; ?>
<script src="assets/js/script.js"></script>