<?php
include_once 'config.php';
include_once 'includes/header.php';

$blog_query = "SELECT * FROM " . table('blog_posts') . " ORDER BY created_at DESC";
$blog_result = mysqli_query($conn, $blog_query);
?>
<main>
    <section class="page-banner" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 60px 0; color: white; text-align: center;">
        <div class="container">
            <h1>Real Estate Blog</h1>
            <p>Insights, tips, and market updates</p>
        </div>
    </section>
    <section style="padding: 80px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
                <?php while($post = mysqli_fetch_assoc($blog_result)): ?>
                <div style="background: var(--white); border-radius: 16px; overflow: hidden; box-shadow: var(--shadow); transition: var(--transition);">
                    <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800&q=80" alt="<?php echo $post['title']; ?>" style="width: 100%; height: 200px; object-fit: cover;">
                    <div style="padding: 25px;">
                        <h3 style="color: var(--primary); font-size: 20px; margin-bottom: 10px;"><?php echo $post['title']; ?></h3>
                        <p style="color: var(--text-light); font-size: 14px; margin-bottom: 10px;">
                            <i class="fas fa-user"></i> <?php echo $post['author']; ?> | 
                            <i class="fas fa-calendar"></i> <?php echo date('M d, Y', strtotime($post['created_at'])); ?>
                        </p>
                        <p style="color: var(--text-light); margin-bottom: 15px;"><?php echo $post['excerpt']; ?></p>
                        <a href="blog-detail.php?id=<?php echo $post['id']; ?>" style="color: var(--secondary); font-weight: 600;">
                            Read More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
</main>
<?php include_once 'includes/footer.php'; ?>
<script src="assets/js/script.js"></script>