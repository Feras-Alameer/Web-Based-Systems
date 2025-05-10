<?php
// Set page title
$page_title = 'منتجاتنا';

// Include header
require_once 'header.php';

// Include database functions
require_once 'db_functions.php';

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? $_SESSION['user_id'] : null;

// Get all products from database
$products = getAllProducts();
?>

<section class="hero">
    <div class="hero-content">
        <h1>منتجاتنا المميزة</h1>
        <p>اكتشف مجموعتنا الفريدة من القهوة العربية والمستلزمات</p>
    </div>
</section>


    <div class="main-content">
        <div class="products-container">
            <?php if (empty($products)): ?>
                <div class="no-products">
                    <p>لا توجد منتجات متاحة حالياً.</p>
                </div>
            <?php else: ?>
                <div class="products-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <?php if (isset($product['discount']) && $product['discount'] > 0): ?>
                                <div class="discount-badge"><?php echo $product['discount']; ?>%</div>
                            <?php endif; ?>
                            <div class="product-image">
                                <?php if (!empty($product['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($product['name'] ?? ''); ?>">
                                <?php else: ?>
                                    <img src="images/default-product.jpg" alt="Default product image">
                                <?php endif; ?>
                            </div>
                            <div class="product-info">
                                <div class="product-details">
                                    <h3><?php echo htmlspecialchars($product['name'] ?? ''); ?></h3>
                                    <?php if (isset($product['original_price']) && $product['original_price'] > $product['price']): ?>
                                        <p class="original-price"><?php echo number_format($product['original_price'], 2); ?> ريال</p>
                                    <?php endif; ?>
                                    <p class="price"><?php echo number_format($product['price'], 2); ?> ريال</p>
                                </div>
                                <button class="show-desc-btn" onclick="toggleDescription(this)">عرض الوصف</button>
                                <div class="product-description">
                                    <?php echo nl2br(htmlspecialchars($product['description'] ?? '')); ?>
                                </div>
                                <?php if ($is_logged_in): ?>
                                    <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                        <div class="quantity-control">
                                            <label for="quantity-<?php echo $product['product_id']; ?>">الكمية:</label>
                                            <input type="number" 
                                                   id="quantity-<?php echo $product['product_id']; ?>"
                                                   name="quantity" 
                                                   value="1" 
                                                   min="1" 
                                                   max="<?php echo $product['stock']; ?>">
                                        </div>
                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                        <button type="submit" class="btn-primary">أضف للسلة</button>
                                    </form>
                                <?php else: ?>
                                    <a href="login.php" class="btn-secondary">تسجيل دخول للشراء</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function toggleDescription(btn) {
    // Find the product card
    var card = btn.closest('.product-card');
    // Toggle the show-desc class on this card only
    if (card.classList.contains('show-desc')) {
        card.classList.remove('show-desc');
        btn.textContent = "عرض الوصف";
    } else {
        card.classList.add('show-desc');
        btn.textContent = "إخفاء الوصف";
    }
}
</script>

<?php
// Include footer
require_once 'footer.php';
?>
