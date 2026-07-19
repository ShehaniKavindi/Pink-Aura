<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PiNK AURA — Reveal your natural glow</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/home.css">
  <link rel="stylesheet" href="assets/css/search.css">

  <link rel="icon" href="assets/images/site-images/logo.png" />

</head>

<body>

  <!-- <nav class="top">
    <div class="logo">PiNK <span>AURA</span></div>
    <div class="nav-links">
      <a href="index.html" class="active">Home</a>
      <a href="search.html">Shop</a>
      <a href="category.html">Categories</a>
      <a href="about.html">About us</a>
      <a href="blog.html">Blog</a>
      <a href="contact.html">Contact</a>
    </div>
    <div class="nav-icons">
      <div class="icon-btn" aria-label="Search">&#9906;</div>
      <div class="icon-btn" aria-label="Account">&#128100;</div>
      <button class="icon-btn" aria-label="Wishlist" data-wishlist-toggle>&#9825;<span
          class="wishlist-count">0</span></button>
      <button class="icon-btn" aria-label="Bag" data-bag-toggle>&#128722;<span class="bag-count">0</span></button>
    </div>
  </nav> -->

  <?php include "header.php" ?>

  <!-- HERO -->
  <section class="hero">
    <img class="hero-bg" src="assets/images/site-images/hero-image.jpg" alt="Model applying skincare — placeholder">

    <div class="hero-content">
      <p class="eyebrow">New collection</p>
      <h1 class="hero-title">Reveal your <em>natural glow</em></h1>
      <div class="hero-stats">
        <div class="stat"><span class="num">10K+</span><span class="lab">Happy customers</span></div>
        <div class="stat"><span class="num">4.8★</span><span class="lab">Average rating</span></div>
      </div>
      <a href="#" class="btn">Shop now &rarr;</a>
    </div>

    <div class="hero-badge">
      <div class="pct">20% off</div>
      <div class="txt">For new customers</div>
    </div>
  </section>

  <!-- CATEGORIES -->
  <section>
    <div class="wrap">
      <h2 class="section-title">Shop by category</h2>
      <div class="cat-grid">
        <a class="cat-card" href="category.php">
          <img src="assets/images/site-images/moisturizer.jpg" alt="Moisturizers — placeholder">
          <div class="cat-body">
            <p class="cat-name">Moisturizers</p>
            <p class="cat-count">18 products</p>
          </div>
        </a>
        <a class="cat-card" href="category.php">
          <img src="assets/images/site-images/facemask.jpg" alt="Masks — placeholder">
          <div class="cat-body">
            <p class="cat-name">Masks</p>
            <p class="cat-count">8 products</p>
          </div>
        </a>
        <a class="cat-card" href="category.php">
          <img src="assets/images/site-images/cleanser.jpg" alt="Cleansers — placeholder">
          <div class="cat-body">
            <p class="cat-name">Bath & Body</p>
            <p class="cat-count">12 products</p>
          </div>
        </a>
        <a class="cat-card" href="category.php">
          <img src="assets/images/site-images/serum.jpg" alt="Serums — placeholder">
          <div class="cat-body">
            <p class="cat-name">Serums</p>
            <p class="cat-count">15 products</p>
          </div>
        </a>
        <a class="cat-card" href="category.php">
          <img src="assets/images/site-images/sunscreen.jpg" alt="Sunscreen — placeholder">
          <div class="cat-body">
            <p class="cat-name">Skin Care</p>
            <p class="cat-count">10 products</p>
          </div>
        </a>

      </div>
    </div>
  </section>

  <!-- PROMO BANNER -->
  <section>
    <div class="wrap">
      <div class="promo">
        <div class="promo-copy">
          <p class="eyebrow">&#10022; Glow every day</p>
          <h2>Skincare that<br><em>loves</em> you back</h2>
          <p>Flat 20% off on our best-selling products. Limited time offer.</p>
          <a href="serach.php" class="btn">Shop now &rarr;</a>
        </div>
        <div class="promo-image">
          <img src="assets/images/site-images/4.jpg" alt="Product lineup — placeholder">
        </div>
        <div class="promo-stats">
          <div class="stat">
            <div class="num">10K+</div>
            <div class="lab">Happy customers</div>
          </div>
          <div class="stat">
            <div class="num">4.8</div>
            <div class="lab">Average rating</div>
            <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- BESTSELLERS -->
  <?php
  include "includes/connection.php" ;
  /* ---------- BESTSELLERS: no orders/sales table yet, so this just shows the
   4 most recently added products for now. Once an orders table exists,
   swap the ORDER BY for a real "units sold" count. ---------- */
  $bestsellers_rs = Database::search("
    SELECT
        p.product_id,
        p.title,
        p.variant_type,
        c.name  AS category,
        s.name  AS sub,
        MIN(pv.price) AS price,
        (SELECT pi.image_url FROM product_images pi
            WHERE pi.product_id = p.product_id AND pi.is_primary = 1
            LIMIT 1) AS image,
        IFNULL((SELECT ROUND(AVG(r.rating)) FROM reviews r WHERE r.product_id = p.product_id), 0) AS rating,
        (SELECT COUNT(*) FROM reviews r WHERE r.product_id = p.product_id) AS reviews,
        (SELECT GROUP_CONCAT(CONCAT(pv2.variant_id, '::', pv2.label, '||', IFNULL(pv2.swatch_hex,'')) SEPARATOR ';;')
            FROM product_variants pv2 WHERE pv2.product_id = p.product_id) AS variants_raw
    FROM products p
    JOIN subcategories s ON s.subcategory_id = p.subcategory_id
    JOIN categories c ON c.category_id = s.category_id
    LEFT JOIN product_variants pv ON pv.product_id = p.product_id
    GROUP BY p.product_id
    ORDER BY p.created_at DESC
    LIMIT 4
");

  $bestsellers = [];
  while ($row = $bestsellers_rs->fetch_assoc()) {
    $variants = [];
    if (!empty($row['variants_raw'])) {
      foreach (explode(';;', $row['variants_raw']) as $pair) {
        [$idAndLabel, $hex] = array_pad(explode('||', $pair, 2), 2, '');
        [$vid, $label] = array_pad(explode('::', $idAndLabel, 2), 2, '');
        $variants[] = ['id' => (int) $vid, 'label' => $label, 'hex' => $hex];
      }
    }

    $bestsellers[] = [
      'id'          => (int) $row['product_id'],
      'name'        => $row['title'],
      'category'    => $row['category'],
      'sub'         => $row['sub'],
      'variantType' => $row['variant_type'],
      'variants'    => $variants,
      'price'       => (float) $row['price'],
      'rating'      => (int) $row['rating'],
      'reviews'     => (int) $row['reviews'],
      'image'       => $row['image'],
    ];
  }
  ?>
  <section>
    <div class="wrap">
      <div class="bestsellers-head">
        <h2>Our bestsellers</h2>
        <a href="search.php" class="btn outline small">View all</a>
      </div>
      <div class="prod-grid" id="bestsellerGrid">

        <?php foreach ($bestsellers as $p): ?>
          <div class="prod-card">
            <div class="prod-image">
              <a href="product-view.php?id=<?php echo $p['id']; ?>">
                <img src="<?php echo $p['image'] ? htmlspecialchars($p['image']) : 'https://placehold.co/320x300/F3D6E2/4A1E30?text=' . urlencode($p['name']); ?>"
                  alt="<?php echo htmlspecialchars($p['name']); ?>">
              </a>
              <div class="wishlist">&#9825;</div>
            </div>
            <div class="prod-body">
              <a class="prod-name" href="product-view.php?id=<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?></a>
              <div class="prod-rating">
                <span class="stars"><?php echo str_repeat('&#9733;', $p['rating']) . str_repeat('&#9734;', 5 - $p['rating']); ?></span>
                (<?php echo $p['reviews']; ?>)
              </div>

              <?php if ($p['variantType'] !== 'none' && count($p['variants']) > 1): ?>
                <div class="prod-variants">
                  <?php if ($p['variantType'] === 'size'): ?>
                    <?php foreach ($p['variants'] as $v): ?>
                      <span class="prod-size-pill"><?php echo htmlspecialchars($v['label']); ?></span>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <?php foreach ($p['variants'] as $v): ?>
                      <span class="prod-swatch" style="background:<?php echo htmlspecialchars($v['hex'] ?: '#F4B9CE'); ?>" title="<?php echo htmlspecialchars($v['label']); ?>"></span>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              <?php endif; ?>

              <div class="prod-price-row">
                <div class="prod-price">
                  <?php echo $p['variantType'] !== 'none' ? 'From ' : ''; ?>Rs <?php echo number_format($p['price']); ?>
                </div>
                <button class="prod-bag" data-product-id="<?php echo $p['id']; ?>" aria-label="Add to bag">&#128722;</button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
    </div>
  </section>

  <script>
    /* ---------- BESTSELLERS: add-to-bag / variant-select redirect ---------- */
    const bestsellerProducts = <?php echo json_encode($bestsellers, JSON_UNESCAPED_UNICODE); ?>;
    const BESTSELLER_VARIANT_WORD = {
      size: 'size',
      shade: 'shade',
      color: 'color'
    };

    function handleBestsellerAddToCart(productId) {
      const product = bestsellerProducts.find(p => p.id === productId);
      if (!product) return;

      if (product.variantType !== 'none') {
        const word = BESTSELLER_VARIANT_WORD[product.variantType] || 'option';
        bagToast(`Please select a ${word} first.`, 'warning');
        setTimeout(() => {
          window.location.href = `product-view.php?id=${product.id}`;
        }, 1100);
        return;
      }

      const variant = product.variants[0];
      if (!variant) {
        bagToast('This product is unavailable right now.', 'error');
        return;
      }

      addToBag(variant.id, 1);
    }

    document.getElementById('bestsellerGrid').addEventListener('click', (e) => {
      const btn = e.target.closest('.prod-bag');
      if (!btn) return;
      e.preventDefault();
      handleBestsellerAddToCart(Number(btn.dataset.productId));
    });
  </script>

  <?php include "footer.php" ?>

  <script src="assets/js/wishlist.js"></script>
  <script src="assets/js/bag.js"></script>
  <script src="assets/js/main.js"></script>

</body>

</html>