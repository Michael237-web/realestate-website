<?php
include_once 'config.php';
include_once 'includes/header.php';

// Ensure $conn is available
global $conn;

$featured_query = "SELECT * FROM " . table('properties') . " WHERE status = 'available' ORDER BY created_at DESC LIMIT 6";
$featured_result = mysqli_query($conn, $featured_query);
?>

<main>
    <section class="hero">
        <div class="hero-slider">
            <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1920&q=80');">
                <div class="hero-overlay"></div>
            </div>
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=1920&q=80');">
                <div class="hero-overlay"></div>
            </div>
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1920&q=80');">
                <div class="hero-overlay"></div>
            </div>
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1523217582562-09d0def993a6?w=1920&q=80');">
                <div class="hero-overlay"></div>
            </div>
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1920&q=80');">
                <div class="hero-overlay"></div>
            </div>
        </div>
        <button class="hero-arrow prev" onclick="changeSlide(-1)">❮</button>
        <button class="hero-arrow next" onclick="changeSlide(1)">❯</button>
        <div class="hero-dots">
            <span class="hero-dot active" onclick="currentSlide(0)"></span>
            <span class="hero-dot" onclick="currentSlide(1)"></span>
            <span class="hero-dot" onclick="currentSlide(2)"></span>
            <span class="hero-dot" onclick="currentSlide(3)"></span>
            <span class="hero-dot" onclick="currentSlide(4)"></span>
        </div>
        <div class="hero-content container">
            <h1>Find Your <span>Dream Home</span></h1>
            <p>Discover the perfect property in Kenya's most desirable locations</p>
            <div class="hero-search">
                <form action="properties.php" method="GET">
                    <div class="search-row">
                        <div class="search-group">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" name="location" placeholder="Location (Nairobi, Mombasa, etc.)">
                        </div>
                        <div class="search-group">
                            <i class="fas fa-home"></i>
                            <select name="property_type">
                                <option value="">Property Type</option>
                                <option value="sale">For Sale</option>
                                <option value="rent">For Rent</option>
                                <option value="commercial">Commercial</option>
                                <option value="land">Land</option>
                            </select>
                        </div>
                        <div class="search-group">
                            <i class="fas fa-dollar-sign"></i>
                            <select name="price_range">
                                <option value="">Price Range</option>
                                <option value="0-1000000">0 - 1M</option>
                                <option value="1000000-5000000">1M - 5M</option>
                                <option value="5000000-10000000">5M - 10M</option>
                                <option value="10000000-50000000">10M - 50M</option>
                                <option value="50000000+">50M+</option>
                            </select>
                        </div>
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </form>
                <div class="quick-filters">
                    <a href="properties.php?type=sale" class="filter-btn">Buy</a>
                    <a href="properties.php?type=rent" class="filter-btn">Rent</a>
                    <a href="properties.php?type=commercial" class="filter-btn">Commercial</a>
                    <a href="properties.php?type=land" class="filter-btn">Land</a>
                </div>
            </div>
        </div>
    </section>
    <section class="featured-properties">
        <div class="container">
            <div class="section-header">
                <h2>Featured Properties</h2>
                <p>Handpicked properties just for you</p>
                <a href="properties.php" class="view-all">View All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="property-grid">
                <?php if(mysqli_num_rows($featured_result) > 0): ?>
                    <?php while($property = mysqli_fetch_assoc($featured_result)): ?>
                    <div class="property-card">
                        <div class="property-image">
                            <img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=800&q=80" alt="<?php echo $property['title']; ?>">
                            <span class="property-badge <?php echo $property['property_type']; ?>">
                                <?php echo ucfirst($property['property_type']); ?>
                            </span>
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
                <?php else: ?>
                    <p style="grid-column: 1/-1; text-align: center; padding: 40px;">No properties available yet. Check back soon!</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <section class="why-choose-us">
        <div class="container">
            <div class="section-header">
                <h2>Why Choose <?php echo SITE_NAME; ?></h2>
                <p>We make your property journey seamless and successful</p>
            </div>
            <div class="features-grid">
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <h3>Trusted & Reliable</h3>
                    <p>Over 10 years of experience in the Kenyan real estate market</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-users"></i>
                    <h3>Expert Agents</h3>
                    <p>Professional agents dedicated to finding your perfect property</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Secure Transactions</h3>
                    <p>Safe and transparent property transactions with legal support</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-headset"></i>
                    <h3>24/7 Support</h3>
                    <p>Round-the-clock customer service for all your queries</p>
                </div>
            </div>
        </div>
    </section>
    <section class="agents-section">
        <div class="container">
            <div class="section-header">
                <h2>Our Expert Agents</h2>
                <p>Meet the professionals ready to help you</p>
                <a href="agents.php" class="view-all">View All Agents <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="agents-grid">
                <?php
                $agents_query = "SELECT * FROM " . table('agents') . " ORDER BY id DESC LIMIT 3";
                $agents_result = mysqli_query($conn, $agents_query);
                while($agent = mysqli_fetch_assoc($agents_result)):
                ?>
                <div class="agent-card">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($agent['name']); ?>&size=120&background=1a3a5c&color=fff" alt="<?php echo $agent['name']; ?>">
                    <h3><?php echo $agent['name']; ?></h3>
                    <p><?php echo $agent['specialty']; ?></p>
                    <a href="tel:<?php echo $agent['phone']; ?>"><i class="fas fa-phone"></i> <?php echo $agent['phone']; ?></a>
                    <div class="agent-social">
                        <?php if($agent['facebook']): ?>
                            <a href="<?php echo $agent['facebook']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if($agent['instagram']): ?>
                            <a href="<?php echo $agent['instagram']; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if($agent['linkedin']): ?>
                            <a href="<?php echo $agent['linkedin']; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <section class="testimonials">
        <div class="container">
            <div class="section-header">
                <h2>What Our Clients Say</h2>
                <p>Real stories from happy property owners</p>
            </div>
            <div class="testimonial-grid">
                <?php
                $test_query = "SELECT * FROM " . table('testimonials') . " WHERE status = 'approved' ORDER BY id DESC LIMIT 3";
                $test_result = mysqli_query($conn, $test_query);
                while($test = mysqli_fetch_assoc($test_result)):
                ?>
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <?php for($i=1; $i<=5; $i++): ?>
                            <i class="fas fa-star <?php echo $i <= $test['rating'] ? 'active' : ''; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p>"<?php echo $test['content']; ?>"</p>
                    <div class="testimonial-author">
                        <strong><?php echo $test['client_name']; ?></strong>
                        <span>Happy Client</span>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Find Your Dream Home?</h2>
                <p>Let our expert agents guide you through the journey</p>
                <a href="contact.php" class="btn-cta">Contact Us Today</a>
            </div>
        </div>
    </section>
</main>

<?php include_once 'includes/footer.php'; ?>
<script src="assets/js/script.js"></script>