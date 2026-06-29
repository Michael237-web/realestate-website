<?php
include_once 'config.php';
include_once 'includes/header.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = "SELECT * FROM " . table('properties') . " WHERE id = $id";
$result = mysqli_query($conn, $query);
$property = mysqli_fetch_assoc($result);

if(!$property) {
    header('Location: properties.php');
    exit();
}
?>
<main>
    <section style="padding: 40px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px;">
                <div>
                    <img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=800&q=80" alt="<?php echo $property['title']; ?>" style="width: 100%; border-radius: 16px; box-shadow: var(--shadow);">
                </div>
                <div>
                    <h1 style="color: var(--primary); font-size: 32px; margin-bottom: 10px;"><?php echo $property['title']; ?></h1>
                    <p style="color: var(--text-light); font-size: 18px; margin-bottom: 10px;"><i class="fas fa-map-marker-alt"></i> <?php echo $property['location']; ?></p>
                    <p style="font-size: 28px; font-weight: 800; color: var(--primary); margin-bottom: 20px;">KES <?php echo number_format($property['price']); ?></p>
                    <div style="display: flex; gap: 30px; margin-bottom: 20px;">
                        <span><strong><?php echo $property['bedrooms']; ?></strong> Bedrooms</span>
                        <span><strong><?php echo $property['bathrooms']; ?></strong> Bathrooms</span>
                        <span><strong><?php echo $property['land_size']; ?></strong></span>
                    </div>
                    <p style="color: var(--text-light); line-height: 1.8; margin-bottom: 20px;"><?php echo $property['description']; ?></p>
                    <div style="display: flex; gap: 15px;">
                        <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=I'm%20interested%20in%20<?php echo urlencode($property['title']); ?>" target="_blank" style="background: #25D366; color: white; padding: 15px 30px; border-radius: 50px; font-weight: 600; transition: var(--transition);">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="contact.php" style="background: var(--primary); color: white; padding: 15px 30px; border-radius: 50px; font-weight: 600; transition: var(--transition);">
                            <i class="fas fa-envelope"></i> Contact Agent
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include_once 'includes/footer.php'; ?>