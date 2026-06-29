<?php
// Define base path if not already defined
if (!isset($base_path)) {
    $base_path = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false ? '../' : '');
}
?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col company-col">
                <div class="footer-logo">
                    <img src="<?php echo $base_path; ?>logo-white.png" alt="<?php echo SITE_NAME; ?>" onerror="this.style.display='none'">
                    <h3><?php echo SITE_NAME; ?></h3>
                </div>
                <p>Your trusted partner in finding the perfect property. We connect people with their dream homes across Kenya.</p>
                <div class="footer-contact">
                    <p><i class="fas fa-phone"></i> <?php echo PHONE_NUMBER; ?></p>
                    <p><i class="fab fa-whatsapp"></i> <?php echo WHATSAPP_NUMBER; ?></p>
                    <p><i class="fas fa-envelope"></i> <?php echo ADMIN_EMAIL; ?></p>
                    <p><i class="fas fa-map-marker-alt"></i> Nairobi, Kenya</p>
                </div>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="<?php echo $base_path; ?>about.php">About Us</a></li>
                    <li><a href="<?php echo $base_path; ?>agents.php">Our Agents</a></li>
                    <li><a href="<?php echo $base_path; ?>careers.php">Careers</a></li>
                    <li><a href="<?php echo $base_path; ?>blog.php">Blog</a></li>
                    <li><a href="<?php echo $base_path; ?>contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Properties</h4>
                <ul>
                    <li><a href="<?php echo $base_path; ?>properties.php?type=sale">For Sale</a></li>
                    <li><a href="<?php echo $base_path; ?>properties.php?type=rent">For Rent</a></li>
                    <li><a href="<?php echo $base_path; ?>properties.php?type=commercial">Commercial</a></li>
                    <li><a href="<?php echo $base_path; ?>properties.php?type=land">Land</a></li>
                    <li><a href="<?php echo $base_path; ?>admin/list-property.php">List Your Property</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Legal</h4>
                <ul>
                    <li><a href="<?php echo $base_path; ?>terms.php">Terms & Conditions</a></li>
                    <li><a href="<?php echo $base_path; ?>privacy.php">Privacy Policy</a></li>
                    <li><a href="<?php echo $base_path; ?>cookies.php">Cookie Policy</a></li>
                    <li><a href="<?php echo $base_path; ?>disclaimer.php">Disclaimer</a></li>
                </ul>
            </div>
            <div class="footer-col newsletter-col">
                <h4>Stay Updated</h4>
                <p>Subscribe to our newsletter for the latest properties and market insights.</p>
                <form class="newsletter-form" method="POST" action="<?php echo $base_path; ?>subscribe.php">
                    <input type="email" placeholder="Your email address" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
                <div class="social-links">
                    <h4>Follow Us</h4>
                    <div class="social-icons">
                        <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All Rights Reserved.</p>
                <p class="footer-credit">Built with <i class="fas fa-heart"></i> by Michael</p>
            </div>
        </div>
    </div>
</footer>
<script src="<?php echo $base_path; ?>assets/js/script.js"></script>
</body>
</html>
<?php
if (isset($conn)) {
    mysqli_close($conn);
}
?>