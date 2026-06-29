<?php
include_once '../config.php';

// Ensure $conn is available
global $conn;

include_once '../includes/header.php';

$is_admin = false;
$is_logged_in = false;
if(isset($_SESSION['user_id'])) {
    $is_logged_in = true;
    $user_id = $_SESSION['user_id'];
    $check_admin = mysqli_query($conn, "SELECT role FROM " . table('users') . " WHERE id = $user_id");
    if($check_admin && mysqli_num_rows($check_admin) > 0) {
        $user_data = mysqli_fetch_assoc($check_admin);
        if($user_data['role'] == 'admin') {
            $is_admin = true;
        }
    }
}

$message = '';
$message_type = '';

if($_SERVER['REQUEST_METHOD'] == 'POST' && $is_admin) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $property_type = mysqli_real_escape_string($conn, $_POST['property_type']);
    $category = mysqli_real_escape_string($conn, $_POST['category'] ?? '');
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $bedrooms = intval($_POST['bedrooms'] ?? 0);
    $bathrooms = intval($_POST['bathrooms'] ?? 0);
    $land_size = mysqli_real_escape_string($conn, $_POST['land_size'] ?? '');
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
    $furnished = isset($_POST['furnished']) ? 1 : 0;
    if(empty($title) || empty($property_type) || empty($price) || empty($location)) {
        $message = 'Please fill in all required fields.';
        $message_type = 'error';
    } else {
        $query = "INSERT INTO " . table('properties') . " (title, property_type, category, price, location, bedrooms, bathrooms, land_size, furnished, description, agent_id, status) 
                  VALUES ('$title', '$property_type', '$category', '$price', '$location', $bedrooms, $bathrooms, '$land_size', $furnished, '$description', {$_SESSION['user_id']}, 'available')";
        if(mysqli_query($conn, $query)) {
            $message = '✅ Property listed successfully! It will appear on the site immediately.';
            $message_type = 'success';
        } else {
            $message = '❌ Failed to list property. Error: ' . mysqli_error($conn);
            $message_type = 'error';
        }
    }
}

$properties_query = "SELECT * FROM " . table('properties') . " ORDER BY created_at DESC";
$properties_result = mysqli_query($conn, $properties_query);
$properties_count = mysqli_num_rows($properties_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Your Property - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; font-weight: 500; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark); }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; transition: var(--transition); font-family: 'Inter', sans-serif; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 4px rgba(26, 58, 92, 0.1); }
        .form-group textarea { resize: vertical; min-height: 120px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input[type="checkbox"] { width: 20px; height: 20px; cursor: pointer; }
        .checkbox-group label { margin-bottom: 0; cursor: pointer; }
        .btn-submit { background: var(--secondary); color: var(--primary); padding: 16px 40px; border: none; border-radius: 50px; font-weight: 700; font-size: 18px; cursor: pointer; transition: var(--transition); width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-submit:hover { background: var(--secondary-light); transform: translateY(-2px); box-shadow: 0 8px 25px rgba(232, 168, 56, 0.4); }
        .btn-login { background: var(--primary); color: white; padding: 16px 40px; border: none; border-radius: 50px; font-weight: 700; font-size: 18px; cursor: pointer; transition: var(--transition); display: inline-flex; align-items: center; gap: 10px; text-decoration: none; }
        .btn-login:hover { background: var(--primary-light); transform: translateY(-2px); box-shadow: 0 8px 25px rgba(26, 58, 92, 0.3); }
        .toast-message { position: fixed; top: 100px; right: 30px; padding: 20px 30px; border-radius: 12px; color: white; font-weight: 600; font-size: 16px; z-index: 9999; opacity: 0; transform: translateX(100%); transition: all 0.5s ease; box-shadow: 0 10px 40px rgba(0,0,0,0.2); max-width: 450px; border-left: 5px solid rgba(255,255,255,0.3); }
        .toast-message.show { opacity: 1; transform: translateX(0); }
        .toast-message.error { background: linear-gradient(135deg, #e74c3c, #c0392b); }
        .toast-message.success { background: linear-gradient(135deg, #2ecc71, #27ae60); }
        .toast-message.info { background: linear-gradient(135deg, #3498db, #2980b9); }
        .toast-message.warning { background: linear-gradient(135deg, #f39c12, #e67e22); }
        .toast-message .toast-icon { margin-right: 12px; font-size: 20px; }
        .toast-message .toast-close { position: absolute; top: 8px; right: 12px; cursor: pointer; opacity: 0.7; font-size: 18px; }
        .toast-message .toast-close:hover { opacity: 1; }
        .properties-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px; margin-top: 30px; }
        .property-item { background: var(--white); border-radius: 12px; overflow: hidden; box-shadow: var(--shadow); transition: var(--transition); }
        .property-item:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
        .property-item .prop-image { height: 200px; overflow: hidden; position: relative; }
        .property-item .prop-image img { width: 100%; height: 100%; object-fit: cover; transition: var(--transition); }
        .property-item:hover .prop-image img { transform: scale(1.05); }
        .property-item .prop-image .prop-badge { position: absolute; top: 12px; left: 12px; padding: 4px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: white; }
        .prop-badge.sale { background: #e74c3c; }
        .prop-badge.rent { background: #2ecc71; }
        .prop-badge.commercial { background: #3498db; }
        .prop-badge.land { background: #f39c12; }
        .property-item .prop-details { padding: 18px 20px; }
        .property-item .prop-details h3 { font-size: 18px; font-weight: 700; margin-bottom: 4px; color: var(--text-dark); }
        .property-item .prop-details .prop-location { color: var(--text-light); font-size: 14px; margin-bottom: 6px; }
        .property-item .prop-details .prop-price { font-size: 20px; font-weight: 800; color: var(--primary); }
        .property-item .prop-details .prop-features { display: flex; gap: 15px; font-size: 13px; color: var(--text-light); margin-top: 8px; }
        .property-item .prop-details .prop-features i { color: var(--primary); margin-right: 4px; }
        .admin-badge { background: var(--secondary); color: var(--primary); padding: 4px 16px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; margin-left: 10px; }
        @media (max-width: 768px) { .form-row { grid-template-columns: 1fr; } .properties-grid { grid-template-columns: 1fr; } .toast-message { top: 80px; right: 15px; left: 15px; max-width: none; font-size: 14px; padding: 15px 20px; } }
    </style>
</head>
<body>
<header class="professional-header">
    <div class="header-top">
        <div class="container">
            <div class="contact-info">
                <a href="tel:<?php echo PHONE_NUMBER; ?>"><i class="fas fa-phone-alt"></i> <?php echo PHONE_NUMBER; ?></a>
                <span class="divider">|</span>
                <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                <span class="divider">|</span>
                <a href="mailto:<?php echo ADMIN_EMAIL; ?>"><i class="far fa-envelope"></i> <?php echo ADMIN_EMAIL; ?></a>
            </div>
            <div class="user-actions">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php"><i class="fas fa-user-circle"></i> My Account</a>
                    <a href="../logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
                <?php else: ?>
                    <a href="../login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <a href="../register.php" class="btn-register"><i class="fas fa-user-plus"></i> Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="header-main">
        <div class="container">
            <div class="logo">
                <a href="../index.php">
                    <img src="https://img.icons8.com/color/48/000000/real-estate.png" alt="<?php echo SITE_NAME; ?>">
                    <span><?php echo SITE_NAME; ?></span>
                </a>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li class="dropdown">
                        <a href="javascript:void(0)">Properties <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="../properties.php?type=sale">🏠 For Sale</a></li>
                            <li><a href="../properties.php?type=rent">🔑 For Rent</a></li>
                            <li><a href="../properties.php?type=commercial">🏢 Commercial</a></li>
                            <li><a href="../properties.php?type=land">🌍 Land</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0)">Buy <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="../properties.php?category=apartment">🏢 Apartments</a></li>
                            <li><a href="../properties.php?category=villa">🏡 Villas</a></li>
                            <li><a href="../properties.php?category=townhouse">🏘️ Townhouses</a></li>
                            <li><a href="../properties.php?category=land">🌳 Land</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0)">Rent <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="../properties.php?rent=apartment">🏢 Apartments</a></li>
                            <li><a href="../properties.php?rent=house">🏡 Houses</a></li>
                            <li><a href="../properties.php?rent=commercial">🏢 Commercial</a></li>
                        </ul>
                    </li>
                    <li><a href="../agents.php">Agents</a></li>
                    <li><a href="../about.php">About</a></li>
                    <li><a href="../blog.php">Blog</a></li>
                    <li><a href="../contact.php">Contact</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <a href="list-property.php" class="btn-list-property">
                    <i class="fas fa-plus-circle"></i> List Property
                </a>
                <button class="mobile-toggle" aria-label="Menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<div id="toastMessage" class="toast-message">
    <span class="toast-close" onclick="hideToast()">&times;</span>
    <span id="toastContent"></span>
</div>

<main>
    <section class="page-banner" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 60px 0; color: white; text-align: center;">
        <div class="container">
            <h1 style="font-size: 42px; font-weight: 800;">
                <?php if($is_admin): ?>
                    <i class="fas fa-plus-circle"></i> List Your Property
                <?php else: ?>
                    <i class="fas fa-building"></i> Property Management
                <?php endif; ?>
            </h1>
            <p style="font-size: 18px; opacity: 0.9;">
                <?php if($is_admin): ?>
                    Reach thousands of potential buyers and tenants
                <?php else: ?>
                    View all properties
                <?php endif; ?>
            </p>
            <?php if($is_admin): ?>
                <span class="admin-badge"><i class="fas fa-crown"></i> Admin Access</span>
            <?php endif; ?>
        </div>
    </section>

    <section style="padding: 60px 0; background: var(--bg-light);">
        <div class="container">
            <div style="margin-bottom: 40px;">
                <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 20px;">
                    <i class="fas fa-list"></i> All Properties
                </h2>
                <?php if($properties_count > 0): ?>
                    <div class="properties-grid">
                        <?php while($property = mysqli_fetch_assoc($properties_result)): 
                            $image_url = 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=400&q=80';
                            if($property['property_type'] == 'sale') {
                                $image_url = 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=400&q=80';
                            } elseif($property['property_type'] == 'rent') {
                                $image_url = 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=400&q=80';
                            } elseif($property['property_type'] == 'commercial') {
                                $image_url = 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=400&q=80';
                            } elseif($property['property_type'] == 'land') {
                                $image_url = 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=400&q=80';
                            }
                        ?>
                        <div class="property-item">
                            <div class="prop-image">
                                <img src="<?php echo $image_url; ?>" alt="<?php echo $property['title']; ?>">
                                <span class="prop-badge <?php echo $property['property_type']; ?>">
                                    <?php echo ucfirst($property['property_type']); ?>
                                </span>
                            </div>
                            <div class="prop-details">
                                <h3><?php echo $property['title']; ?></h3>
                                <p class="prop-location"><i class="fas fa-map-marker-alt"></i> <?php echo $property['location']; ?></p>
                                <p class="prop-price">KES <?php echo number_format($property['price']); ?></p>
                                <div class="prop-features">
                                    <span><i class="fas fa-bed"></i> <?php echo $property['bedrooms']; ?></span>
                                    <span><i class="fas fa-bath"></i> <?php echo $property['bathrooms']; ?></span>
                                    <span><i class="fas fa-vector-square"></i> <?php echo $property['land_size'] ?: 'N/A'; ?></span>
                                    <?php if($property['furnished']): ?>
                                        <span><i class="fas fa-couch"></i> Furnished</span>
                                    <?php endif; ?>
                                </div>
                                <div style="margin-top: 10px; font-size: 12px; color: var(--text-light);">
                                    <i class="far fa-calendar-alt"></i> Added: <?php echo date('M d, Y', strtotime($property['created_at'])); ?>
                                    <span style="margin-left: 10px; background: <?php echo $property['status'] == 'available' ? '#2ecc71' : '#e74c3c'; ?>; color: white; padding: 2px 12px; border-radius: 12px; font-size: 10px; text-transform: uppercase;">
                                        <?php echo $property['status']; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 60px 20px; background: var(--white); border-radius: 16px; box-shadow: var(--shadow);">
                        <i class="fas fa-home" style="font-size: 64px; color: var(--text-light); margin-bottom: 20px;"></i>
                        <h3 style="color: var(--text-dark);">No Properties Found</h3>
                        <p style="color: var(--text-light);">There are no properties in the database yet.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($is_admin): ?>
                <div style="max-width: 800px; margin: 0 auto; background: var(--white); padding: 40px; border-radius: 16px; box-shadow: var(--shadow); border-top: 5px solid var(--secondary);">
                    <h3 style="color: var(--primary); font-size: 24px; margin-bottom: 10px;">
                        <i class="fas fa-plus-circle" style="color: var(--secondary);"></i> Add New Property
                    </h3>
                    <p style="color: var(--text-light); margin-bottom: 25px;">Fill in the details below to list a new property.</p>
                    <?php if($message): ?>
                        <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="form-group">
                            <label>Property Title <span style="color: red;">*</span></label>
                            <input type="text" name="title" required placeholder="e.g., Modern 3BR Apartment in Westlands">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Property Type <span style="color: red;">*</span></label>
                                <select name="property_type" required>
                                    <option value="sale">For Sale</option>
                                    <option value="rent">For Rent</option>
                                    <option value="commercial">Commercial</option>
                                    <option value="land">Land</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category">
                                    <option value="">Select Category</option>
                                    <option value="apartment">Apartment</option>
                                    <option value="villa">Villa</option>
                                    <option value="townhouse">Townhouse</option>
                                    <option value="house">House</option>
                                    <option value="office">Office</option>
                                    <option value="retail">Retail</option>
                                    <option value="warehouse">Warehouse</option>
                                    <option value="residential">Residential</option>
                                    <option value="commercial">Commercial</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Price (KES) <span style="color: red;">*</span></label>
                                <input type="number" name="price" required placeholder="e.g., 8500000">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Location <span style="color: red;">*</span></label>
                            <input type="text" name="location" required placeholder="e.g., Westlands, Nairobi">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Bedrooms</label>
                                <input type="number" name="bedrooms" value="0" min="0">
                            </div>
                            <div class="form-group">
                                <label>Bathrooms</label>
                                <input type="number" name="bathrooms" value="0" min="0">
                            </div>
                            <div class="form-group">
                                <label>Land Size</label>
                                <input type="text" name="land_size" placeholder="e.g., 120 sqm">
                            </div>
                        </div>
                        <div class="form-group checkbox-group">
                            <input type="checkbox" name="furnished" id="furnished">
                            <label for="furnished">Furnished</label>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" placeholder="Describe your property in detail..."></textarea>
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-plus-circle"></i> List Property
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 50px 30px; background: var(--white); border-radius: 16px; box-shadow: var(--shadow); border-top: 5px solid var(--accent);">
                    <i class="fas fa-lock" style="font-size: 64px; color: var(--accent); margin-bottom: 20px; opacity: 0.7;"></i>
                    <h3 style="color: var(--text-dark); font-size: 24px; margin-bottom: 10px;">Administrator Access Required</h3>
                    <p style="color: var(--text-light); max-width: 500px; margin: 0 auto 25px;">
                        The property listing feature is restricted to administrators only. 
                        Please login with your admin credentials to add new properties to the system.
                    </p>
                    <a href="../login.php" class="btn-login" onclick="showAdminToast()">
                        <i class="fas fa-sign-in-alt"></i> Login as Administrator
                    </a>
                    <p style="margin-top: 15px; font-size: 13px; color: var(--text-light);">
                        <i class="fas fa-info-circle"></i> Only users with admin privileges can list properties.
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include_once '../includes/footer.php'; ?>