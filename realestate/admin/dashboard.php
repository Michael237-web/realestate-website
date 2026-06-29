<?php
include_once '../config.php';

// Ensure $conn is available
global $conn;

include_once '../includes/header.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

$props_query = "SELECT * FROM " . table('properties') . " WHERE agent_id = $user_id ORDER BY created_at DESC";
$props_result = mysqli_query($conn, $props_query);
$props_count = mysqli_num_rows($props_result);

$inquiries_query = "SELECT * FROM " . table('inquiries') . " ORDER BY created_at DESC LIMIT 5";
$inquiries_result = mysqli_query($conn, $inquiries_query);
?>

<main>
    <section style="padding: 80px 0;">
        <div class="container">
            <h1 style="color: var(--primary); font-size: 36px; margin-bottom: 10px;">Welcome, <?php echo $user_name; ?>!</h1>
            <p style="color: var(--text-light); margin-bottom: 40px;">Here's an overview of your real estate activity</p>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px;">
                <div style="background: var(--white); padding: 25px; border-radius: 16px; box-shadow: var(--shadow); text-align: center;">
                    <i class="fas fa-home" style="font-size: 32px; color: var(--secondary);"></i>
                    <h3 style="font-size: 28px; margin: 10px 0;"><?php echo $props_count; ?></h3>
                    <p style="color: var(--text-light);">Your Properties</p>
                </div>
                <div style="background: var(--white); padding: 25px; border-radius: 16px; box-shadow: var(--shadow); text-align: center;">
                    <i class="fas fa-eye" style="font-size: 32px; color: var(--secondary);"></i>
                    <h3 style="font-size: 28px; margin: 10px 0;">0</h3>
                    <p style="color: var(--text-light);">Total Views</p>
                </div>
                <div style="background: var(--white); padding: 25px; border-radius: 16px; box-shadow: var(--shadow); text-align: center;">
                    <i class="fas fa-envelope" style="font-size: 32px; color: var(--secondary);"></i>
                    <h3 style="font-size: 28px; margin: 10px 0;">0</h3>
                    <p style="color: var(--text-light);">Inquiries</p>
                </div>
                <div style="background: var(--white); padding: 25px; border-radius: 16px; box-shadow: var(--shadow); text-align: center;">
                    <i class="fas fa-heart" style="font-size: 32px; color: var(--secondary);"></i>
                    <h3 style="font-size: 28px; margin: 10px 0;">0</h3>
                    <p style="color: var(--text-light);">Wishlist</p>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
                <div style="background: var(--white); padding: 30px; border-radius: 16px; box-shadow: var(--shadow);">
                    <h2 style="color: var(--primary); font-size: 24px; margin-bottom: 20px;">Your Properties</h2>
                    <?php if($props_count > 0): ?>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead style="background: var(--bg-light);">
                                    <tr>
                                        <th style="padding: 12px; text-align: left;">Title</th>
                                        <th style="padding: 12px; text-align: left;">Price</th>
                                        <th style="padding: 12px; text-align: left;">Status</th>
                                        <th style="padding: 12px; text-align: left;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($prop = mysqli_fetch_assoc($props_result)): ?>
                                    <tr>
                                        <td style="padding: 12px; border-bottom: 1px solid #eee;"><?php echo $prop['title']; ?></td>
                                        <td style="padding: 12px; border-bottom: 1px solid #eee;">KES <?php echo number_format($prop['price']); ?></td>
                                        <td style="padding: 12px; border-bottom: 1px solid #eee;">
                                            <span style="background: <?php echo $prop['status'] == 'available' ? '#2ecc71' : '#e74c3c'; ?>; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                                                <?php echo ucfirst($prop['status']); ?>
                                            </span>
                                        </td>
                                        <td style="padding: 12px; border-bottom: 1px solid #eee;">
                                            <a href="../property-detail.php?id=<?php echo $prop['id']; ?>" style="color: var(--primary); font-weight: 600;">View</a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p style="color: var(--text-light);">You haven't listed any properties yet. <a href="list-property.php" style="color: var(--secondary); font-weight: 600;">List your first property</a></p>
                    <?php endif; ?>
                </div>
                <div style="background: var(--white); padding: 30px; border-radius: 16px; box-shadow: var(--shadow);">
                    <h2 style="color: var(--primary); font-size: 24px; margin-bottom: 20px;">Recent Inquiries</h2>
                    <?php if(mysqli_num_rows($inquiries_result) > 0): ?>
                        <?php while($inq = mysqli_fetch_assoc($inquiries_result)): ?>
                            <div style="padding: 15px 0; border-bottom: 1px solid #eee;">
                                <p style="font-weight: 600;"><?php echo $inq['name']; ?></p>
                                <p style="color: var(--text-light); font-size: 14px;"><?php echo $inq['message']; ?></p>
                                <p style="color: var(--text-light); font-size: 12px;"><?php echo date('M d, Y', strtotime($inq['created_at'])); ?></p>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="color: var(--text-light);">No inquiries yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once '../includes/footer.php'; ?>