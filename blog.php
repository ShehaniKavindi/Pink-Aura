<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Journal — PiNK AURA</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/blog.css">

    <link rel="icon" href="assets/images/site-images/logo.png" />
</head>

<body>

  <!-- <nav class="top">
    <div class="logo">PiNK <span>AURA</span></div>
    <div class="nav-links">
      <a href="index.html">Home</a>
      <a href="search.html">Shop</a>
      <a href="category.html">Categories</a>
      <a href="about.html">About us</a>
      <a href="blog.html" class="active">Blog</a>
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
  <section class="blog-hero">
    <div class="wrap blog-hero-grid">
      <div class="blog-hero-copy">
        <p class="eyebrow">The journal</p>
        <h1>Stories, rituals &amp; <em>skin wisdom</em></h1>
        <p>Ingredient deep-dives, routines from the PiNK AURA team, and the small rituals that make skincare feel
          like self-care again.</p>
        <div class="search-bar blog-hero-search">
          <span class="icon">&#9906;</span>
          <input type="text" placeholder="Search the journal">
        </div>
      </div>
      <div class="blog-hero-image">
        <img src="assets/images/site-images/5.jpg" alt="PiNK AURA skincare lineup on a marble counter">
      </div>
    </div>
  </section>


  <!-- FEATURED POST -->
  <section>
    <div class="wrap">
      <a href="#" class="featured-post">
        <div class="featured-post-image">
          <img src="assets/images/site-images/skinprdcts.jpg" alt="Featured article cover">
        </div>
        <div class="featured-post-body">
          <div class="post-meta">
            <span class="pill active">Ingredients</span>
            <span class="post-date">July 2, 2026 &middot; 6 min read</span>
          </div>
          <h2>5 ingredients your skin barrier actually needs</h2>
          <p>Not every "active" belongs in every routine. Here's what to look for on the label if your skin has been
            feeling tight, reactive, or just tired lately &mdash; and what to leave on the shelf.</p>
          <div class="post-author">
            <div class="post-author-avatar">PA</div>
            <span><b>PiNK AURA Team</b> &middot; Skincare Editorial</span>
          </div>
        </div>
      </a>
    </div>
  </section>

  <!-- WATCH & LEARN -->
  <section class="blog-reels">
    <div class="wrap">
      <h2 class="section-title">Watch &amp; learn</h2>
      <div class="reels-grid">

        <div class="reel-card" data-category="rituals">
          <video class="reel-video" poster="assets/images/site-images/reel1-poster.jpg" controls playsinline
            preload="none">
            <source src="assets/videos/reel-1.mp4" type="video/mp4">
          </video>
          <div class="reel-caption">
            <p class="reel-title">Our 5-step nighttime ritual</p>
            <p class="reel-sub">Rituals &middot; 0:21</p>
          </div>
        </div>

        <div class="reel-card" data-category="skincare-101">
          <video class="reel-video" poster="assets/images/site-images/reel2-poster.jpg" controls playsinline
            preload="none">
            <source src="assets/videos/reel-2.mp4" type="video/mp4">
          </video>
          <div class="reel-caption">
            <p class="reel-title">How we layer actives, in order</p>
            <p class="reel-sub">Skincare 101 &middot; 0:22</p>
          </div>
        </div>

        <div class="reel-card" data-category="behind-the-brand">
          <video class="reel-video" poster="assets/images/site-images/reel3-poster.jpg" controls playsinline
            preload="none">
            <source src="assets/videos/reel-3.mp4" type="video/mp4">
          </video>
          <div class="reel-caption">
            <p class="reel-title">A closer look at the Peptide Glow Serum</p>
            <p class="reel-sub">Behind the brand &middot; 0:19</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- BLOG GRID -->
  <section class="blog-section">
    <div class="wrap">
      <h2 class="section-title">Latest from the journal</h2>
      <div class="blog-grid" id="blogGrid">

        <a href="#" class="blog-card" data-category="skincare-101">
          <div class="blog-card-image">
            <img src="https://placehold.co/500x375/FBE7EE/8C7580?text=Skincare+101" alt="Double cleansing guide">
          </div>
          <div class="blog-card-body">
            <div class="post-meta">
              <span class="pill">Skincare 101</span>
              <span class="post-date">June 28, 2026</span>
            </div>
            <h3 class="blog-card-title">Double cleansing: worth the extra step?</h3>
            <p class="blog-card-excerpt">We break down when it actually helps &mdash; and when it's just stripping
              your skin for no reason.</p>
            <span class="blog-card-readmore">Read more &rarr;</span>
          </div>
        </a>

        <a href="#" class="blog-card" data-category="ingredients">
          <div class="blog-card-image">
            <img src="https://placehold.co/500x375/F4B9CE/4A1E30?text=Niacinamide" alt="Niacinamide guide">
          </div>
          <div class="blog-card-body">
            <div class="post-meta">
              <span class="pill">Ingredients</span>
              <span class="post-date">June 21, 2026</span>
            </div>
            <h3 class="blog-card-title">Niacinamide, explained without the jargon</h3>
            <p class="blog-card-excerpt">What it does, how fast to expect results, and why 5% is usually the sweet
              spot.</p>
            <span class="blog-card-readmore">Read more &rarr;</span>
          </div>
        </a>

        <a href="#" class="blog-card" data-category="rituals">
          <div class="blog-card-image">
            <img src="https://placehold.co/500x375/F3D6E2/4A1E30?text=Sunday+Reset" alt="Sunday skincare ritual">
          </div>
          <div class="blog-card-body">
            <div class="post-meta">
              <span class="pill">Rituals</span>
              <span class="post-date">June 14, 2026</span>
            </div>
            <h3 class="blog-card-title">A slower Sunday reset routine</h3>
            <p class="blog-card-excerpt">Masking, gua sha, and the ten minutes we all skip on weekdays &mdash; put
              back on the calendar.</p>
            <span class="blog-card-readmore">Read more &rarr;</span>
          </div>
        </a>

        <a href="#" class="blog-card" data-category="behind-the-brand">
          <div class="blog-card-image">
            <img src="https://placehold.co/500x375/E58EAD/FFFFFF?text=Our+Story" alt="Behind the brand">
          </div>
          <div class="blog-card-body">
            <div class="post-meta">
              <span class="pill">Behind the brand</span>
              <span class="post-date">June 9, 2026</span>
            </div>
            <h3 class="blog-card-title">Why we formulate fragrance-free</h3>
            <p class="blog-card-excerpt">A look at the choices behind every PiNK AURA formula, straight from our lab
              notes.</p>
            <span class="blog-card-readmore">Read more &rarr;</span>
          </div>
        </a>

        <a href="#" class="blog-card" data-category="skincare-101">
          <div class="blog-card-image">
            <img src="https://placehold.co/500x375/FBE7EE/8C7580?text=SPF" alt="Sunscreen guide">
          </div>
          <div class="blog-card-body">
            <div class="post-meta">
              <span class="pill">Skincare 101</span>
              <span class="post-date">June 2, 2026</span>
            </div>
            <h3 class="blog-card-title">SPF isn't optional, even indoors</h3>
            <p class="blog-card-excerpt">The short science on UVA rays through windows, and how much sunscreen you
              actually need.</p>
            <span class="blog-card-readmore">Read more &rarr;</span>
          </div>
        </a>

        <a href="#" class="blog-card" data-category="ingredients">
          <div class="blog-card-image">
            <img src="https://placehold.co/500x375/F4B9CE/4A1E30?text=Peptides" alt="Peptides guide">
          </div>
          <div class="blog-card-body">
            <div class="post-meta">
              <span class="pill">Ingredients</span>
              <span class="post-date">May 26, 2026</span>
            </div>
            <h3 class="blog-card-title">Peptides 101: the patient ingredient</h3>
            <p class="blog-card-excerpt">Why peptides take weeks, not days &mdash; and how to know they're actually
              working.</p>
            <span class="blog-card-readmore">Read more &rarr;</span>
          </div>
        </a>

      </div>
    </div>
  </section>

  <!-- NEWSLETTER -->
  <section class="blog-newsletter">
    <div class="wrap">
      <div class="newsletter-inner">
        <h2>Get skin-smart, weekly</h2>
        <p>One email a week. New articles, ingredient breakdowns, and the occasional subscriber-only discount.</p>
        <form class="newsletter-form">
          <input type="email" placeholder="Your email address" required>
          <button type="submit" class="btn">Subscribe</button>
        </form>
      </div>
    </div>
  </section>

  <?php include "footer.php" ?>
  

  <script src="assets/js/wishlist.js"></script>
  <script src="assets/js/bag.js"></script>
  <script>
    /* ── Blog category filter (pills filter both reels and article cards) ── */
    const filterPills = document.querySelectorAll('#filterPills .pill');
    const filterable = document.querySelectorAll('[data-category]');

    filterPills.forEach(pill => {
      pill.addEventListener('click', () => {
        filterPills.forEach(p => p.classList.remove('active'));
        pill.classList.add('active');

        const filter = pill.dataset.filter;
        filterable.forEach(card => {
          const match = filter === 'all' || card.dataset.category === filter;
          card.hidden = !match;
        });
      });
    });
  </script>

</body>

</html>