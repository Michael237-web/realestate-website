<?php
// No need to include config again since it's already included in index.php
// But we need to ensure $conn is available
global $conn;

// Determine base path for assets
$base_path = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false ? '../' : '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Find Your Dream Home</title>
    <!-- CSS - Main stylesheet -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/js/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header class="professional-header">
    <div class="header-top">
        <div class="container">
            <div class="contact-info">
                <a href="tel:<?php echo PHONE_NUMBER; ?>"><i class="fas fa-phone-alt"></i> <span class="contact-text"><?php echo PHONE_NUMBER; ?></span></a>
                <span class="divider">|</span>
                <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>" target="_blank"><i class="fab fa-whatsapp"></i> <span class="contact-text">WhatsApp</span></a>
                <span class="divider">|</span>
                <a href="mailto:<?php echo ADMIN_EMAIL; ?>"><i class="far fa-envelope"></i> <span class="contact-text"><?php echo ADMIN_EMAIL; ?></span></a>
            </div>
            <div class="user-actions">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo $base_path; ?>admin/dashboard.php"><i class="fas fa-user-circle"></i> <span class="action-text">My Account</span></a>
                    <a href="<?php echo $base_path; ?>logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> <span class="action-text">Logout</span></a>
                <?php else: ?>
                    <a href="<?php echo $base_path; ?>login.php"><i class="fas fa-sign-in-alt"></i> <span class="action-text">Login</span></a>
                    <a href="<?php echo $base_path; ?>register.php" class="btn-register"><i class="fas fa-user-plus"></i> <span class="action-text">Register</span></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="header-main">
        <div class="container">
            <div class="logo">
                <a href="<?php echo $base_path; ?>index.php">
                    <img src="https://img.icons8.com/color/48/000000/real-estate.png" alt="<?php echo SITE_NAME; ?>">
                    <span><?php echo SITE_NAME; ?></span>
                </a>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="<?php echo $base_path; ?>index.php" <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>>Home</a></li>
                    <li class="dropdown">
                        <a href="javascript:void(0)">Properties <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $base_path; ?>properties.php?type=sale">🏠 For Sale</a></li>
                            <li><a href="<?php echo $base_path; ?>properties.php?type=rent">🔑 For Rent</a></li>
                            <li><a href="<?php echo $base_path; ?>properties.php?type=commercial">🏢 Commercial</a></li>
                            <li><a href="<?php echo $base_path; ?>properties.php?type=land">🌍 Land</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0)">Buy <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $base_path; ?>properties.php?category=apartment">🏢 Apartments</a></li>
                            <li><a href="<?php echo $base_path; ?>properties.php?category=villa">🏡 Villas</a></li>
                            <li><a href="<?php echo $base_path; ?>properties.php?category=townhouse">🏘️ Townhouses</a></li>
                            <li><a href="<?php echo $base_path; ?>properties.php?category=land">🌳 Land</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0)">Rent <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $base_path; ?>properties.php?rent=apartment">🏢 Apartments</a></li>
                            <li><a href="<?php echo $base_path; ?>properties.php?rent=house">🏡 Houses</a></li>
                            <li><a href="<?php echo $base_path; ?>properties.php?rent=commercial">🏢 Commercial</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo $base_path; ?>agents.php" <?php echo basename($_SERVER['PHP_SELF']) == 'agents.php' ? 'class="active"' : ''; ?>>Agents</a></li>
                    <li><a href="<?php echo $base_path; ?>about.php" <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'class="active"' : ''; ?>>About</a></li>
                    <li><a href="<?php echo $base_path; ?>blog.php" <?php echo basename($_SERVER['PHP_SELF']) == 'blog.php' ? 'class="active"' : ''; ?>>Blog</a></li>
                    <li><a href="<?php echo $base_path; ?>contact.php" <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'class="active"' : ''; ?>>Contact</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <a href="<?php echo $base_path; ?>admin/list-property.php" class="btn-list-property">
                    <i class="fas fa-plus-circle"></i> <span>List Property</span>
                </a>
                <button class="mobile-toggle" aria-label="Menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</header>
<div class="mobile-nav">
    <ul>
        <li><a href="<?php echo $base_path; ?>index.php"><i class="fas fa-home"></i> Home</a></li>
        <li>
            <a href="javascript:void(0)" class="dropdown-toggle"><i class="fas fa-building"></i> Properties <i class="fas fa-chevron-down"></i></a>
            <ul class="mobile-sub-menu">
                <li><a href="<?php echo $base_path; ?>properties.php?type=sale">🏠 For Sale</a></li>
                <li><a href="<?php echo $base_path; ?>properties.php?type=rent">🔑 For Rent</a></li>
                <li><a href="<?php echo $base_path; ?>properties.php?type=commercial">🏢 Commercial</a></li>
                <li><a href="<?php echo $base_path; ?>properties.php?type=land">🌍 Land</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)" class="dropdown-toggle"><i class="fas fa-shopping-cart"></i> Buy <i class="fas fa-chevron-down"></i></a>
            <ul class="mobile-sub-menu">
                <li><a href="<?php echo $base_path; ?>properties.php?category=apartment">🏢 Apartments</a></li>
                <li><a href="<?php echo $base_path; ?>properties.php?category=villa">🏡 Villas</a></li>
                <li><a href="<?php echo $base_path; ?>properties.php?category=townhouse">🏘️ Townhouses</a></li>
                <li><a href="<?php echo $base_path; ?>properties.php?category=land">🌳 Land</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)" class="dropdown-toggle"><i class="fas fa-hand-holding-usd"></i> Rent <i class="fas fa-chevron-down"></i></a>
            <ul class="mobile-sub-menu">
                <li><a href="<?php echo $base_path; ?>properties.php?rent=apartment">🏢 Apartments</a></li>
                <li><a href="<?php echo $base_path; ?>properties.php?rent=house">🏡 Houses</a></li>
                <li><a href="<?php echo $base_path; ?>properties.php?rent=commercial">🏢 Commercial</a></li>
            </ul>
        </li>
        <li><a href="<?php echo $base_path; ?>agents.php"><i class="fas fa-user-tie"></i> Agents</a></li>
        <li><a href="<?php echo $base_path; ?>about.php"><i class="fas fa-info-circle"></i> About</a></li>
        <li><a href="<?php echo $base_path; ?>blog.php"><i class="fas fa-newspaper"></i> Blog</a></li>
        <li><a href="<?php echo $base_path; ?>contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
        <li><a href="<?php echo $base_path; ?>admin/list-property.php" class="mobile-list-btn"><i class="fas fa-plus-circle"></i> List Property</a></li>
    </ul>
</div>
<script src="assets/js/script.js"></script>
</body>
</html>