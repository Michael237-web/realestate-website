<?php
include_once 'config.php';
include_once 'includes/header.php';

$agents_query = "SELECT * FROM " . table('agents') . " ORDER BY id DESC";
$agents_result = mysqli_query($conn, $agents_query);
?>
<main>
    <section class="page-banner" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 60px 0; color: white; text-align: center;">
        <div class="container">
            <h1>Our Expert Agents</h1>
            <p>Meet the professionals dedicated to helping you</p>
        </div>
    </section>
    <section style="padding: 80px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
                <?php while($agent = mysqli_fetch_assoc($agents_result)): ?>
                <div style="background: var(--white); padding: 30px; border-radius: 16px; box-shadow: var(--shadow); text-align: center; transition: var(--transition);">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($agent['name']); ?>&size=150&background=1a3a5c&color=fff" alt="<?php echo $agent['name']; ?>" style="width: 150px; height: 150px; border-radius: 50%; margin-bottom: 20px;">
                    <h3 style="color: var(--primary); font-size: 22px; margin-bottom: 5px;"><?php echo $agent['name']; ?></h3>
                    <p style="color: var(--secondary); font-weight: 600; margin-bottom: 15px;"><?php echo $agent['specialty']; ?></p>
                    <p style="color: var(--text-light); margin-bottom: 15px;"><?php echo $agent['bio']; ?></p>
                    <a href="tel:<?php echo $agent['phone']; ?>" style="display: inline-block; background: var(--primary); color: white; padding: 10px 25px; border-radius: 30px; margin-bottom: 15px;">
                        <i class="fas fa-phone"></i> <?php echo $agent['phone']; ?>
                    </a>
                    <div style="display: flex; justify-content: center; gap: 12px;">
                        <?php if($agent['facebook']): ?>
                            <a href="<?php echo $agent['facebook']; ?>" target="_blank" style="display: inline-block; width: 40px; height: 40px; line-height: 40px; border-radius: 50%; background: var(--primary); color: white; transition: var(--transition);">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        <?php endif; ?>
                        <?php if($agent['instagram']): ?>
                            <a href="<?php echo $agent['instagram']; ?>" target="_blank" style="display: inline-block; width: 40px; height: 40px; line-height: 40px; border-radius: 50%; background: var(--primary); color: white; transition: var(--transition);">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                        <?php if($agent['linkedin']): ?>
                            <a href="<?php echo $agent['linkedin']; ?>" target="_blank" style="display: inline-block; width: 40px; height: 40px; line-height: 40px; border-radius: 50%; background: var(--primary); color: white; transition: var(--transition);">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
</main>
<?php include_once 'includes/footer.php'; ?>
<script src="assets/js/script.js"></script>