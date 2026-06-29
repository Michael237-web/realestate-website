<?php
include_once 'config.php';
include_once 'includes/header.php';

$where = "WHERE status = 'available'";
if(isset($_GET['type']) && !empty($_GET['type'])) {
    $type = mysqli_real_escape_string($conn, $_GET['type']);
    $where .= " AND property_type = '$type'";
}
if(isset($_GET['category']) && !empty($_GET['category'])) {
    $category = mysqli_real_escape_string($conn, $_GET['category']);
    $where .= " AND category = '$category'";
}
if(isset($_GET['location']) && !empty($_GET['location'])) {
    $location = mysqli_real_escape_string($conn, $_GET['location']);
    $where .= " AND location LIKE '%$location%'";
}
if(isset($_GET['rent']) && !empty($_GET['rent'])) {
    $rent = mysqli_real_escape_string($conn, $_GET['rent']);
    $where .= " AND category = '$rent' AND property_type = 'rent'";
}
$query = "SELECT * FROM " . table('properties') . " $where ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
$count = mysqli_num_rows($result);

$page_title = "All Properties";
if(isset($_GET['type'])) {
    $type_labels = ['sale' => 'Properties For Sale', 'rent' => 'Properties For Rent', 'commercial' => 'Commercial Properties', 'land' => 'Land For Sale'];
    $page_title = isset($type_labels[$_GET['type']]) ? $type_labels[$_GET['type']] : 'Properties';
}

function getPropertyImage($property) {
    $images = ['sale' => ['apartment' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&q=80', 'villa' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80', 'townhouse' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800&q=80', 'default' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=800&q=80'], 'rent' => ['apartment' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800&q=80', 'house' => 'https://images.unsplash.com/photo-1560185127-6ed189bf02f4?w=800&q=80', 'commercial' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80', 'default' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&q=80'], 'commercial' => ['default' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80'], 'land' => ['default' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&q=80']];
    $type = $property['property_type'];
    $category = $property['category'] ?? 'default';
    if(isset($images[$type])) {
        if(isset($images[$type][$category])) {
            return $images[$type][$category];
        }
        return $images[$type]['default'];
    }
    return 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=800&q=80';
}
?>
<main>
    <section class="page-banner" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 80px 0; color: white; text-align: center;">
        <div class="container">
            <h1 style="font-size: 42px; font-weight: 800;"><?php echo $page_title; ?></h1>
            <p style="font-size: 18px; opacity: 0.9;"><?php echo $count; ?> properties found</p>
        </div>
    </section>
    <section style="padding: 60px 0; background: var(--bg-light);">
        <div class="container">
            <?php if($count > 0): ?>
                <div class="property-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
                    <?php while($property = mysqli_fetch_assoc($result)): 
                        $image_url = getPropertyImage($property);
                    ?>
                    <div class="property-card">
                        <div class="property-image">
                            <img src="<?php echo $image_url; ?>" alt="<?php echo $property['title']; ?>">
                            <span class="property-badge <?php echo $property['property_type']; ?>">
                                <?php echo ucfirst($property['property_type']); ?>
                            </span>
                            <?php if($property['property_type'] == 'sale'): ?>
                                <span class="property-badge price-badge">For Sale</span>
                            <?php elseif($property['property_type'] == 'rent'): ?>
                                <span class="property-badge price-badge rent-badge">For Rent</span>
                            <?php endif; ?>
                        </div>
                        <div class="property-details">
                            <h3><?php echo $property['title']; ?></h3>
                            <p class="property-location"><i class="fas fa-map-marker-alt"></i> <?php echo $property['location']; ?></p>
                            <p class="property-price">KES <?php echo number_format($property['price']); ?></p>
                            <div class="property-features">
                                <span><i class="fas fa-bed"></i> <?php echo $property['bedrooms']; ?> Beds</span>
                                <span><i class="fas fa-bath"></i> <?php echo $property['bathrooms']; ?> Baths</span>
                                <span><i class="fas fa-vector-square"></i> <?php echo $property['land_size']; ?></span>
                            </div>
                            <a href="property-detail.php?id=<?php echo $property['id']; ?>" class="btn-view-details">
                                View Details <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 60px 20px; background: var(--white); border-radius: 16px; box-shadow: var(--shadow);">
                    <i class="fas fa-home" style="font-size: 64px; color: var(--text-light); margin-bottom: 20px;"></i>
                    <h2 style="color: var(--text-dark); margin-bottom: 10px;">No Properties Found</h2>
                    <p style="color: var(--text-light);">Try adjusting your search filters or browse our other property categories.</p>
                    <a href="properties.php" style="display: inline-block; margin-top: 20px; background: var(--secondary); color: var(--primary); padding: 12px 30px; border-radius: 30px; font-weight: 600;">View All Properties</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include_once 'includes/footer.php'; ?>