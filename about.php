<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About us — PiNK AURA</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/about.css">

  <link rel="icon" href="assets/images/site-images/logo.png" />
</head>

<body>

  <?php include "header.php" ?>

  <!-- HERO -->
  <section class="about-hero">
    <div class="wrap about-hero-grid">
      <div class="about-hero-copy">
        <p class="eyebrow">Our story</p>
        <h1>Skincare that gives your <em>skin the mic</em></h1>
        <p>PiNK AURA started with a simple frustration: routines with fifteen steps and ingredient lists nobody
          could pronounce. We build formulas that do less, better &mdash; so your skin can do the talking.</p>
        <div class="about-hero-actions">
          <a href="category.html" class="btn">Shop the range &rarr;</a>
          <a href="contact.html" class="btn outline">Get in touch</a>
        </div>
      </div>
      <div class="about-hero-image">
        <img src="assets/images/site-images/about-hero.jpg" alt="Woman holding a PiNK AURA skincare bottle">
      </div>
    </div>
  </section>

  <!-- STATS -->
  <section>
    <div class="wrap">
      <div class="about-stats">
        <div class="about-stat"><span class="num">2024</span><span class="lab">Founded in Sri Lanka</span></div>
        <div class="about-stat"><span class="num">30+</span><span class="lab">Products formulated</span></div>
        <div class="about-stat"><span class="num">10K+</span><span class="lab">Happy customers</span></div>
        <div class="about-stat"><span class="num">4.8&#9733;</span><span class="lab">Average rating</span></div>
      </div>
    </div>
  </section>

  <!-- VALUES -->
  <section class="about-values">
    <div class="wrap">
      <h2 class="section-title">What we stand for</h2>
      <div class="values-grid">

        <div class="value-card">
          <div class="value-icon">&#127793;</div>
          <h3>Clean formulas</h3>
          <p>Fragrance-free, dermatologist-tested, and never over-engineered.</p>
        </div>

        <div class="value-card">
          <div class="value-icon">&#128007;</div>
          <h3>Cruelty-free</h3>
          <p>Every formula is developed and finished without animal testing, ever.</p>
        </div>

        <div class="value-card">
          <div class="value-icon">&#127760;</div>
          <h3>Made locally</h3>
          <p>Formulated and bottled in Sri Lanka, shipped straight to your door.</p>
        </div>

        <div class="value-card">
          <div class="value-icon">&#128142;</div>
          <h3>Honest pricing</h3>
          <p>No inflated "luxury tax." Good skincare shouldn't cost a paycheck.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- STORY -->
  <section class="about-story">
    <div class="wrap story-grid">
      <div>
        <p class="eyebrow">How it began</p>
        <h2>From a cluttered bathroom shelf to PiNK AURA</h2>
      </div>
      <div class="story-copy">
        <p>It started, like most skincare obsessions do, with a shelf full of half-used bottles and a routine that
          had grown out of control. Somewhere between the tenth serum and the third "miracle" toner, we realized the
          problem wasn't our skin &mdash; it was an industry built on convincing us we needed more.</p>
        <blockquote class="story-quote">"We didn't want to sell more steps. We wanted to sell the right ones."</blockquote>
        <p>So we went back to basics: a small line of fragrance-free, peptide- and niacinamide-led formulas, tested
          on real skin in Maharagama before they ever reached a shelf. No fifteen-step routines, no ingredient lists
          you need a chemistry degree to read.</p>
        <p>Today, PiNK AURA is still a small team &mdash; but one that reads every review, tweaks every formula, and
          genuinely believes your skin deserves better than marketing hype.</p>
      </div>
    </div>
  </section>

  <!-- TEAM -->
  <section class="about-team">
    <div class="wrap">
      <h2 class="section-title">The people behind the pink</h2>
      <div class="team-grid">

        <div class="team-card">
          <div class="team-avatar">DR</div>
          <p class="team-name">Dracilla Vlad</p>
          <p class="team-role">Founder &amp; Formulator</p>
          <p class="team-bio">Started PiNK AURA in her own kitchen, obsessed with getting the barrier-repair basics
            right.</p>
        </div>

        <div class="team-card">
          <div class="team-avatar">TG</div>
          <p class="team-name">Shenul G.</p>
          <p class="team-role">Head of Operations</p>
          <p class="team-bio">Makes sure every order leaves the warehouse in Maharagama on time, every time.</p>
        </div>

        <div class="team-card">
          <div class="team-avatar">SK</div>
          <p class="team-name">Shehani Kavindi</p>
          <p class="team-role">Customer Care Lead</p>
          <p class="team-bio">Reads every single review &mdash; and actually acts on the ones that sting a little.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="about-cta">
    <div class="wrap">
      <div class="cta-inner">
        <h2>Ready to <em>meet your skin</em> halfway?</h2>
        <p>Explore the full PiNK AURA range and find your new routine essentials.</p>
        <a href="category.html" class="btn">Shop now &rarr;</a>
      </div>
    </div>
  </section>

  <?php include "footer.php" ?>

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

  <script src="assets/js/wishlist.js"></script>
  <script src="assets/js/bag.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>