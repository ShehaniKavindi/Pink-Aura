<?php
// Detect the current page filename (e.g. "index.php", "search.php") so the
// matching nav link gets the .active class automatically, instead of it
// being hardcoded to "Home" on every page.
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="top">
    <div class="logo">PiNK <span>AURA</span></div>
    <div class="nav-links">
      <a href="index.php" class="<?php echo $current_page === 'index.php' ? 'active' : ''; ?>">Home</a>
      <a href="search.php" class="<?php echo $current_page === 'search.php' ? 'active' : ''; ?>">Shop</a>
      <a href="category.php" class="<?php echo $current_page === 'category.php' ? 'active' : ''; ?>">Categories</a>
      <a href="about.php" class="<?php echo $current_page === 'about.php' ? 'active' : ''; ?>">About us</a>
      <a href="blog.php" class="<?php echo $current_page === 'blog.php' ? 'active' : ''; ?>">Blog</a>
      <a href="contact.php" class="<?php echo $current_page === 'contact.php' ? 'active' : ''; ?>">Contact</a>
    </div>
    <div class="nav-icons">
      <div class="icon-btn" aria-label="Search">&#9906;</div>
      <div class="icon-btn" aria-label="Account">&#128100;</div>
      <button class="icon-btn" aria-label="Wishlist" data-wishlist-toggle>&#9825;<span
          class="wishlist-count">0</span></button>
      <button class="icon-btn" aria-label="Bag" data-bag-toggle>&#128722;<span class="bag-count">0</span></button>
    </div>
</nav>


<!-- BAG DRAWER (shared — copied from index.html) -->
  <div class="bag-overlay" id="bagOverlay" data-bag-close></div>
  <div class="bag-drawer" id="bagModal" role="dialog" aria-modal="true" aria-labelledby="bagModalLabel">

    <div class="bag-header">
      <h2 class="bag-title" id="bagModalLabel">My <span>bag</span></h2>
      <button type="button" class="bag-close" data-bag-close aria-label="Close bag">&#10005;</button>
    </div>

    <div class="bag-body" id="bagBody">
      <!-- populated by bag.js -->
    </div>

    <div class="bag-footer">
      <div class="bag-total-row">
        <span class="bag-total-label">Total</span>
        <span class="bag-total-amount" id="bagTotalAmount">Rs 0</span>
      </div>
      <a href="#" class="btn bag-checkout-btn">Checkout</a>
    </div>

  </div>
  <!-- WISHLIST DRAWER (shared — copied from index.html) -->
  <div class="wishlist-overlay" id="wishlistOverlay" data-wishlist-close></div>
  <div class="wishlist-drawer" id="wishlistModal" role="dialog" aria-modal="true" aria-labelledby="wishlistModalLabel">

    <div class="wishlist-header">
      <h2 class="wishlist-title" id="wishlistModalLabel">My <span>wishlist</span></h2>
      <button type="button" class="wishlist-close" data-wishlist-close aria-label="Close wishlist">&#10005;</button>
    </div>

    <div class="wishlist-body" id="wishlistBody">
      <!-- populated by wishlist.js -->
    </div>

  </div>
