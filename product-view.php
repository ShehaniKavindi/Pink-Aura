<?php
include "includes/connection.php";
Database::setUpConnection();

$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$product = null;
$variants = [];
$generalImages = [];

if ($product_id > 0) {
    $product_rs = Database::search("
        SELECT p.product_id, p.title, p.description, p.key_ingredients, p.how_to_use, p.variant_type,
               c.name AS category, s.name AS sub,
               IFNULL((SELECT ROUND(AVG(r.rating),1) FROM reviews r WHERE r.product_id = p.product_id), 0) AS rating,
               (SELECT COUNT(*) FROM reviews r WHERE r.product_id = p.product_id) AS reviews
        FROM products p
        JOIN subcategories s ON s.subcategory_id = p.subcategory_id
        JOIN categories c ON c.category_id = s.category_id
        WHERE p.product_id = '" . $product_id . "'
        LIMIT 1
    ");
    $product = $product_rs->num_rows ? $product_rs->fetch_assoc() : null;

    if ($product) {
        // ---------- variants (always at least one row — 'Standard' for variant_type = none) ----------
        $variants_rs = Database::search("
            SELECT variant_id, label, swatch_hex, price, stock_qty, is_default
            FROM product_variants
            WHERE product_id = '" . $product_id . "'
            ORDER BY is_default DESC, variant_id ASC
        ");
        while ($v = $variants_rs->fetch_assoc()) {
            // each variant may have its own dedicated photo (product_images.variant_id)
            $vimg_rs = Database::search("
                SELECT image_url FROM product_images
                WHERE variant_id = '" . $v['variant_id'] . "'
                LIMIT 1
            ");
            $vimg = $vimg_rs->num_rows ? $vimg_rs->fetch_assoc()['image_url'] : null;

            $variants[] = [
                'id'       => (int) $v['variant_id'],
                'label'    => $v['label'],
                'hex'      => $v['swatch_hex'],
                'price'    => (float) $v['price'],
                'stock'    => (int) $v['stock_qty'],
                'isDefault'=> (bool) $v['is_default'],
                'image'    => $vimg,
            ];
        }

        // ---------- general gallery images (variant_id IS NULL) ----------
        $img_rs = Database::search("
            SELECT image_url FROM product_images
            WHERE product_id = '" . $product_id . "' AND variant_id IS NULL
            ORDER BY is_primary DESC, sort_order ASC
        ");
        while ($img = $img_rs->fetch_assoc()) {
            $generalImages[] = $img['image_url'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $product ? htmlspecialchars($product['title']) . ' — PiNK AURA' : 'Product not found — PiNK AURA'; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/product-view.css">

<link rel="icon" href="assets/images/site-images/logo.png" />
</head>
<body>

<nav class="top">
  <div class="logo">PiNK <span>AURA</span></div>
  <div class="nav-links">
    <a href="index.html">Home</a>
    <a href="search.php">Shop</a>
    <a href="category.html">Categories</a>
    <a href="#">About us</a>
    <a href="#">Blog</a>
    <a href="#">Contact</a>
  </div>
  <div class="nav-icons">
    <div class="icon-btn" aria-label="Search">&#9906;</div>
    <div class="icon-btn" aria-label="Account">&#128100;</div>
    <div class="icon-btn" aria-label="Cart">&#128722;<span class="cart-count" id="cartCount">0</span></div>
  </div>
</nav>

<div class="wrap">

<?php if (!$product): ?>

  <div class="not-found">
    <h1>Product not found</h1>
    <p>The product you're looking for doesn't exist or may have been removed.</p>
    <a href="search.php" class="btn">Back to shop</a>
  </div>

<?php else: ?>

  <div class="breadcrumb">
    <a href="index.html">Home</a><span class="sep">/</span>
    <a href="category.html"><?php echo htmlspecialchars($product['category']); ?></a><span class="sep">/</span>
    <a href="category.html"><?php echo htmlspecialchars($product['sub']); ?></a><span class="sep">/</span>
    <span class="current"><?php echo htmlspecialchars($product['title']); ?></span>
  </div>

  <div class="product-layout">

    <!-- GALLERY (LHS) -->
    <div class="gallery">
      <div class="gallery-main">
        <button class="gallery-wishlist" id="wishlistBtn" aria-label="Add to wishlist">&#9825;</button>
        <img id="mainImage" src="" alt="<?php echo htmlspecialchars($product['title']); ?> — main product photo">
      </div>
      <div class="gallery-thumbs" id="thumbs"></div>
    </div>

    <!-- DETAILS (RHS) -->
    <div class="details">
      <p class="eyebrow"><?php echo htmlspecialchars($product['category']); ?> &middot; <?php echo htmlspecialchars($product['sub']); ?></p>
      <h1 class="product-title"><?php echo htmlspecialchars($product['title']); ?></h1>

      <div class="detail-rating">
        <span class="stars" id="ratingStars"></span>
        <span id="ratingVal"><?php echo $product['rating']; ?></span>
        <a href="#reviews" class="link">(<?php echo $product['reviews']; ?> reviews)</a>
      </div>

      <div class="detail-price-row">
        <div class="detail-price" id="detailPrice">Rs 0</div>
      </div>

      <p class="detail-desc"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

      <!-- option-group: only shown when the product actually has size/shade/color variants -->
      <div class="option-group" id="optionGroup" hidden>
        <p class="option-label"><span id="optionLabelText">Option</span>: <b id="sizeVal"></b></p>
        <div class="option-pills" id="sizePills"></div>
      </div>

      <div class="buy-row">
        <div class="qty-stepper">
          <button type="button" id="qtyMinus" aria-label="Decrease quantity">&minus;</button>
          <span class="qty-val" id="qtyVal">1</span>
          <button type="button" id="qtyPlus" aria-label="Increase quantity">&plus;</button>
        </div>
        <button class="btn" id="addToCartBtn">Add to cart &rarr;</button>
        <button class="icon-btn lg" id="wishlistBtn2" aria-label="Add to wishlist">&#9825;</button>
      </div>

      <p class="stock-note" id="stockNote"><span class="dot"></span>In stock</p>

      <div class="trust-strip">
        <div class="trust-item"><span class="ic">&#128666;</span>Free delivery over Rs 3,000</div>
        <div class="trust-item"><span class="ic">&#8635;</span>7-day easy returns</div>
        <div class="trust-item"><span class="ic">&#128274;</span>Secure checkout</div>
      </div>

      <div class="accordion">
        <details class="acc-item" open>
          <summary>Key ingredients <span class="chev">&#43;</span></summary>
          <div class="acc-body">
            <?php echo nl2br(htmlspecialchars($product['key_ingredients'] ?: 'Not specified.')); ?>
          </div>
        </details>
        <details class="acc-item">
          <summary>How to use <span class="chev">&#43;</span></summary>
          <div class="acc-body">
            <?php echo nl2br(htmlspecialchars($product['how_to_use'] ?: 'Not specified.')); ?>
          </div>
        </details>
        <details class="acc-item">
          <summary>Shipping &amp; returns <span class="chev">&#43;</span></summary>
          <div class="acc-body">
            Orders ship within 24 hours on business days. Unopened items can be
            returned within 7 days of delivery for a full refund.
          </div>
        </details>
      </div>
    </div>
  </div>

<?php endif; ?>

</div>

<footer>
  <div class="logo">PiNK <span style="color:var(--color-primary-strong);">AURA</span></div>
  <div>&copy; 2026 PiNK AURA.</div>
</footer>

<?php if ($product): ?>
<script>
  /* ---------- data from the database ---------- */
  const variantType = <?php echo json_encode($product['variant_type']); ?>; // 'none' | 'size' | 'shade' | 'color'
  const variants = <?php echo json_encode($variants, JSON_UNESCAPED_UNICODE); ?>;
  const generalImages = <?php echo json_encode($generalImages, JSON_UNESCAPED_UNICODE); ?>;
  const fallbackImg = 'https://placehold.co/600x600/F3D6E2/4A1E30?text=<?php echo urlencode($product['title']); ?>';

  let selectedVariant = variants.find(v => v.isDefault) || variants[0] || null;

  /* ---------- GALLERY ---------- */
  const mainImage = document.getElementById('mainImage');
  const thumbsEl = document.getElementById('thumbs');

  // gallery = general product images; a selected variant's own photo (if any)
  // is shown as the main image on top, without disturbing the thumbnail strip
  function renderThumbs(){
    const imgs = generalImages.length ? generalImages : [fallbackImg];
    thumbsEl.innerHTML = imgs.map((src, i) => `
      <button class="gallery-thumb ${i === 0 ? 'active' : ''}" data-full="${src}">
        <img src="${src}" alt="thumbnail ${i + 1}">
      </button>
    `).join('');

    thumbsEl.querySelectorAll('.gallery-thumb').forEach(thumb => {
      thumb.addEventListener('click', () => {
        thumbsEl.querySelector('.gallery-thumb.active')?.classList.remove('active');
        thumb.classList.add('active');
        mainImage.src = thumb.dataset.full;
      });
    });
  }

  function setMainImage(){
    // prefer the selected variant's own photo, fall back to the first general image
    if(selectedVariant && selectedVariant.image){
      mainImage.src = selectedVariant.image;
    } else if(generalImages.length){
      mainImage.src = generalImages[0];
    } else {
      mainImage.src = fallbackImg;
    }
  }

  renderThumbs();
  setMainImage();

  /* ---------- RATING STARS ---------- */
  const ratingRounded = Math.round(<?php echo (float) $product['rating']; ?>);
  document.getElementById('ratingStars').textContent = '\u2605'.repeat(ratingRounded) + '\u2606'.repeat(5 - ratingRounded);

  /* ---------- OPTION GROUP (size / shade / color) — hidden entirely for 'none' ---------- */
  const optionGroup = document.getElementById('optionGroup');
  const optionLabelText = document.getElementById('optionLabelText');
  const sizeVal = document.getElementById('sizeVal');
  const sizePills = document.getElementById('sizePills');

  const optionLabels = { size: 'Size', shade: 'Shade', color: 'Color' };

  function renderOptions(){
    if(variantType === 'none' || variants.length <= 1){
      optionGroup.hidden = true;
      return;
    }

    optionGroup.hidden = false;
    optionLabelText.textContent = optionLabels[variantType] || 'Option';
    sizeVal.textContent = selectedVariant ? selectedVariant.label : '';

    const hasSwatch = variantType === 'shade' || variantType === 'color';

    sizePills.innerHTML = variants.map(v => `
      <button class="option-pill ${hasSwatch ? 'swatch-pill' : ''} ${selectedVariant && v.id === selectedVariant.id ? 'active' : ''}"
              data-id="${v.id}"
              ${hasSwatch ? `style="--pill-color:${v.hex || '#F4B9CE'}"` : ''}>
        ${hasSwatch ? '' : v.label}
      </button>
    `).join('');

    sizePills.querySelectorAll('.option-pill').forEach(pill => {
      pill.addEventListener('click', () => {
        const id = Number(pill.dataset.id);
        selectedVariant = variants.find(v => v.id === id);
        sizePills.querySelector('.option-pill.active')?.classList.remove('active');
        pill.classList.add('active');
        sizeVal.textContent = selectedVariant.label;
        updatePriceAndStock();
        setMainImage();
      });
    });
  }

  /* ---------- PRICE + STOCK NOTE ---------- */
  const detailPrice = document.getElementById('detailPrice');
  const stockNote = document.getElementById('stockNote');
  const addToCartBtn = document.getElementById('addToCartBtn');

  function updatePriceAndStock(){
    if(!selectedVariant){
      detailPrice.textContent = 'Rs 0';
      stockNote.innerHTML = '<span class="dot"></span>Currently unavailable';
      addToCartBtn.disabled = true;
      return;
    }

    detailPrice.textContent = 'Rs ' + selectedVariant.price.toLocaleString();

    if(selectedVariant.stock > 0){
      stockNote.innerHTML = '<span class="dot"></span>In stock &middot; Ships within 24 hours';
      addToCartBtn.disabled = false;
    } else {
      stockNote.innerHTML = '<span class="dot" style="background:#C4536B;"></span>Out of stock';
      addToCartBtn.disabled = true;
    }
  }

  renderOptions();
  updatePriceAndStock();

  /* ---------- QUANTITY STEPPER ---------- */
  let qty = 1;
  const qtyVal = document.getElementById('qtyVal');
  document.getElementById('qtyMinus').addEventListener('click', () => {
    if (qty > 1) qty--;
    qtyVal.textContent = qty;
  });
  document.getElementById('qtyPlus').addEventListener('click', () => {
    qty++;
    qtyVal.textContent = qty;
  });

  /* ---------- WISHLIST TOGGLE ---------- */
  const wishlistBtns = [document.getElementById('wishlistBtn'), document.getElementById('wishlistBtn2')];
  wishlistBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const isActive = btn.classList.toggle('active');
      wishlistBtns.forEach(b => {
        b.classList.toggle('active', isActive);
        b.innerHTML = isActive ? '&#9829;' : '&#9825;';
      });
    });
  });

  /* ---------- ADD TO CART ---------- */
  const cartCount = document.getElementById('cartCount');
  addToCartBtn.addEventListener('click', () => {
    if(addToCartBtn.disabled) return;
    cartCount.textContent = parseInt(cartCount.textContent, 10) + qty;
    // TODO: persist to cart_items for logged-in users — currently front-end only
  });
</script>
<?php endif; ?>

</body>
</html>