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
          <a href="#" class="btn">Shop now &rarr;</a>
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
  <section>
    <div class="wrap">
      <div class="bestsellers-head">
        <h2>Our bestsellers</h2>
        <a href="#" class="btn outline small">View all</a>
      </div>
      <div class="prod-grid">
        
        <div class="prod-card">
          <div class="prod-image">
            <img src="https://placehold.co/320x300/F3D6E2/4A1E30?text=Vitamin+C+Serum"
              alt="Vitamin C serum — placeholder">
            <div class="wishlist">&#9825;</div>
          </div>
          <div class="prod-body">
            <p class="prod-name">Vitamin C serum</p>
            <div class="prod-rating"><span class="stars">&#9733;&#9733;&#9733;&#9733;&#9734;</span> (128)</div>
            <div class="prod-price-row">
              <div class="prod-price">Rs 899<span class="old">Rs 1,199</span></div>
              <button class="prod-bag" aria-label="Add to bag"
                onclick="addToBag({id:'vitamin-c-serum-30ml', name:'Vitamin C Serum', variant:'30ml', price:899, img:'https://placehold.co/120x120/F3D6E2/4A1E30?text=VCS'})">&#128722;</button>
            </div>
          </div>
        </div>
        <div class="prod-card">
          <div class="prod-image">
            <img src="https://placehold.co/320x300/F4B9CE/4A1E30?text=Hydrating+Moisturizer"
              alt="Hydrating moisturizer — placeholder">
            <div class="wishlist">&#9825;</div>
          </div>
          <div class="prod-body">
            <p class="prod-name">Hydrating moisturizer</p>
            <div class="prod-rating"><span class="stars">&#9733;&#9733;&#9733;&#9733;&#9734;</span> (96)</div>
            <div class="prod-price-row">
              <div class="prod-price">Rs 699<span class="old">Rs 999</span></div>
              <button class="prod-bag" aria-label="Add to bag"
                onclick="addToBag({id:'hydrating-moisturizer-50ml', name:'Hydrating Moisturizer', variant:'50ml', price:699, img:'https://placehold.co/120x120/F4B9CE/4A1E30?text=HM'})">&#128722;</button>
            </div>
          </div>
        </div>
        <div class="prod-card">
          <div class="prod-image">
            <img src="https://placehold.co/320x300/FBE7EE/8C7580?text=Glow+Sunscreen"
              alt="Glow sunscreen SPF 50 — placeholder">
            <div class="wishlist">&#9825;</div>
          </div>
          <div class="prod-body">
            <p class="prod-name">Glow sunscreen SPF 50</p>
            <div class="prod-rating"><span class="stars">&#9733;&#9733;&#9733;&#9733;&#9734;</span> (74)</div>
            <div class="prod-price-row">
              <div class="prod-price">Rs 599<span class="old">Rs 799</span></div>
              <button class="prod-bag" aria-label="Add to bag"
                onclick="addToBag({id:'glow-sunscreen-spf50', name:'Glow Sunscreen SPF 50', variant:'SPF 50', price:599, img:'https://placehold.co/120x120/FBE7EE/8C7580?text=Sun'})">&#128722;</button>
            </div>
          </div>
        </div>
        <div class="prod-card">
          <div class="prod-image">
            <img src="https://placehold.co/320x300/E58EAD/FFFFFF?text=Rose+Clay+Mask"
              alt="Rose clay mask — placeholder">
            <div class="wishlist">&#9825;</div>
          </div>
          <div class="prod-body">
            <p class="prod-name">Rose clay mask</p>
            <div class="prod-rating"><span class="stars">&#9733;&#9733;&#9733;&#9733;&#9734;</span> (64)</div>
            <div class="prod-price-row">
              <div class="prod-price">Rs 499<span class="old">Rs 699</span></div>
              <button class="prod-bag" aria-label="Add to bag"
                onclick="addToBag({id:'rose-clay-mask-100g', name:'Rose Clay Mask', variant:'100g', price:499, img:'https://placehold.co/120x120/E58EAD/FFFFFF?text=RCM'})">&#128722;</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <?php include "footer.php" ?>

  <script src="assets/js/wishlist.js"></script>
  <script src="assets/js/bag.js"></script>
  <script src="assets/js/main.js"></script>

</body>

</html>