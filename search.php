<?php
include "includes/connection.php";
Database::setUpConnection();

/* ---------- PRODUCTS: one row per product, min variant price, primary image,
   avg rating + review count (0 if no reviews yet), plus each variant's
   label/hex so the card can show size pills or color swatches ---------- */
$products_rs = Database::search("
    SELECT
        p.product_id,
        p.title,
        p.variant_type,
        p.created_at,
        c.name  AS category,
        s.name  AS sub,
        MIN(pv.price) AS price,
        (SELECT pi.image_url FROM product_images pi
            WHERE pi.product_id = p.product_id AND pi.is_primary = 1
            LIMIT 1) AS image,
        IFNULL((SELECT ROUND(AVG(r.rating)) FROM reviews r WHERE r.product_id = p.product_id), 0) AS rating,
        (SELECT COUNT(*) FROM reviews r WHERE r.product_id = p.product_id) AS reviews,
        (SELECT GROUP_CONCAT(CONCAT(pv2.label, '||', IFNULL(pv2.swatch_hex,'')) SEPARATOR ';;')
            FROM product_variants pv2 WHERE pv2.product_id = p.product_id) AS variants_raw
    FROM products p
    JOIN subcategories s ON s.subcategory_id = p.subcategory_id
    JOIN categories c ON c.category_id = s.category_id
    LEFT JOIN product_variants pv ON pv.product_id = p.product_id
    GROUP BY p.product_id
    ORDER BY p.created_at DESC
");

$products = [];
while ($row = $products_rs->fetch_assoc()) {
  // parse "label||hex;;label||hex" into [{label, hex}, ...]
  $variants = [];
  if (!empty($row['variants_raw'])) {
    foreach (explode(';;', $row['variants_raw']) as $pair) {
      [$label, $hex] = array_pad(explode('||', $pair, 2), 2, '');
      $variants[] = ['label' => $label, 'hex' => $hex];
    }
  }

  $products[] = [
    'id'          => (int) $row['product_id'],
    'name'        => $row['title'],
    'category'    => $row['category'],
    'sub'         => $row['sub'],
    'variantType' => $row['variant_type'], // 'none' | 'size' | 'shade' | 'color'
    'variants'    => $variants,
    'price'       => (float) $row['price'],
    'oldPrice'    => 0, // no discount/compare-at-price column yet — wire up later if you add one
    'rating'      => (int) $row['rating'],
    'reviews'     => (int) $row['reviews'],
    'image'       => $row['image'], // real relative path, or null if no primary image set
    'createdAt'   => date('c', strtotime($row['created_at'])), // ISO 8601 — parses reliably in JS across browsers
  ];
}

/* ---------- CATEGORIES + SUBCATEGORIES (drives the filter sidebar) ---------- */
$cats_rs = Database::search("
    SELECT c.category_id, c.name AS cat_name, s.name AS sub_name
    FROM categories c
    LEFT JOIN subcategories s ON s.category_id = c.category_id
    ORDER BY c.category_id, s.name
");

$categoriesData = []; // [category_id => ['name' => ..., 'subs' => [...]]]
while ($row = $cats_rs->fetch_assoc()) {
  $cid = $row['category_id'];
  if (!isset($categoriesData[$cid])) {
    $categoriesData[$cid] = ['name' => $row['cat_name'], 'subs' => []];
  }
  if (!empty($row['sub_name'])) {
    $categoriesData[$cid]['subs'][] = $row['sub_name'];
  }
}
$categories = array_values($categoriesData); // re-index for a clean JS array
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop in PiNK AURA</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/search.css">

  <link rel="icon" href="assets/images/site-images/logo.png" />
</head>

<body>

  <!-- <nav class="top">
    <div class="logo">PiNK <span>AURA</span></div>
    <div class="nav-links">
      <a href="index.html">Home</a>
      <a href="search.php" class="active">Shop</a>
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

  <div class="search-layout">

    <!-- ASIDE -->
    <aside class="search-aside">
      <div class="search-aside-head">
        <h2>Filters</h2>
        <button class="reset-btn" id="resetFilters">Reset all</button>
      </div>

      <!-- CATEGORIES -->
      <div class="filter-block">
        <p class="filter-label">Category</p>
        <div class="cat-list" id="catList">
          <!-- populated by JS -->
        </div>
      </div>

      <!-- SORT -->
      <div class="filter-block">
        <p class="filter-label">Sort by</p>
        <select id="sortSelect">
          <option value="">Default</option>
          <option value="price-asc">Price: Low to high</option>
          <option value="price-desc">Price: High to low</option>
          <option value="newest">Date: Newest first</option>
          <option value="oldest">Date: Oldest first</option>
        </select>
      </div>

      <!-- PRICE RANGE -->
      <div class="filter-block">
        <p class="filter-label">Price range</p>
        <div class="price-inputs">
          <div class="price-field">
            <label for="priceMin">Min</label>
            <input type="text" id="priceMin" placeholder="Rs 0">
          </div>
          <span class="price-sep">&ndash;</span>
          <div class="price-field">
            <label for="priceMax">Max</label>
            <input type="text" id="priceMax" placeholder="Rs 5000">
          </div>
        </div>
        <input type="range" id="priceRange" min="0" max="5000" value="5000" class="price-slider">
        <button class="btn outline small price-apply" id="applyPrice">Apply price</button>
      </div>

      <button class="reset-btn reset-btn-bottom" id="resetFiltersBottom">Reset all filters</button>
    </aside>

    <!-- MAIN -->
    <main class="search-main">
      <div class="search-bar-row">
        <input type="search" id="searchInput" placeholder="Search for products, categories, brands...">
        <button class="search-btn" id="searchBtn">&#9906; Search</button>
      </div>

      <div class="results-meta">
        <p id="resultsLabel">Showing all products</p>
        <span class="pill" id="resultsCount">0 results</span>
      </div>

      <div class="search-prod-grid" id="prodGrid">
        <!-- populated by JS -->
      </div>
    </main>

  </div>


  <script src="assets/js/wishlist.js"></script>
  <script src="assets/js/bag.js"></script>
  <script>
    /* ---------- CATEGORY DATA (drives the aside) — now pulled from the database ---------- */
    const categories = <?php echo json_encode($categories, JSON_UNESCAPED_UNICODE); ?>;

    /* ---------- PRODUCT DATA — now pulled from the database ---------- */
    const products = <?php echo json_encode($products, JSON_UNESCAPED_UNICODE); ?>;

    /* ---------- STATE ---------- */
    let state = {
      category: null,
      sub: null,
      query: '',
      sort: '',
      priceMin: null,
      priceMax: null
    };

    /* ---------- RENDER: ASIDE CATEGORY LIST ---------- */
    const catList = document.getElementById('catList');

    function renderCatList() {
      catList.innerHTML = categories.map(cat => `
    <div class="cat-group">
      <button class="cat-btn ${state.category===cat.name && !state.sub ? 'active' : ''}" data-cat="${cat.name}">
        ${cat.name}
      </button>
      ${cat.subs.length ? `
        <div class="sub-list">
          ${cat.subs.map(s => `
            <button class="sub-btn ${state.sub===s ? 'active' : ''}" data-cat="${cat.name}" data-sub="${s}">
              ${s}
            </button>
          `).join('')}
        </div>
      ` : ''}
    </div>
  `).join('');

      catList.querySelectorAll('.cat-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          state.category = btn.dataset.cat;
          state.sub = null;
          applyFilters();
          renderCatList();
        });
      });
      catList.querySelectorAll('.sub-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          state.category = btn.dataset.cat;
          state.sub = btn.dataset.sub;
          applyFilters();
          renderCatList();
        });
      });
    }

    /* ---------- RENDER: PRODUCT GRID ---------- */
    const prodGrid = document.getElementById('prodGrid');
    const resultsLabel = document.getElementById('resultsLabel');
    const resultsCount = document.getElementById('resultsCount');

    function renderProducts(list) {
      resultsCount.textContent = `${list.length} result${list.length === 1 ? '' : 's'}`;

      if (!list.length) {
        prodGrid.innerHTML = `<p class="no-results">No products match these filters yet.</p>`;
        return;
      }

      prodGrid.innerHTML = list.map(p => `
    <div class="search-prod-card">
      <a class="search-prod-image" href="product-view.php?id=${p.id}">
        <img src="${p.image ? p.image : 'https://placehold.co/320x260/F3D6E2/4A1E30?text=' + encodeURIComponent(p.name)}" alt="${p.name}">
        <div class="wishlist">&#9825;</div>
      </a>
      <div class="search-prod-body">
        <p class="search-prod-cat">${p.sub} &middot; ${p.category}</p>
        <a class="search-prod-name" href="product-view.php?id=${p.id}">${p.name}</a>
        <div class="search-prod-rating">
          <span class="stars">${'&#9733;'.repeat(p.rating)}${'&#9734;'.repeat(5-p.rating)}</span> (${p.reviews})
        </div>
        ${renderVariants(p)}
        <div class="search-prod-price-row">
          <div class="search-prod-price">
            ${p.variantType !== 'none' ? 'From ' : ''}Rs ${p.price.toLocaleString()}
            ${p.oldPrice ? `<span class="old">Rs ${p.oldPrice.toLocaleString()}</span>` : ''}
          </div>
          <button class="prod-cart" aria-label="Add to cart">&#128722;</button>
        </div>
      </div>
    </div>
  `).join('');
    }

    /* -- size pills for 'size' variants, color/shade circles for 'shade'/'color' -- */
    function renderVariants(p) {
      if (p.variantType === 'none' || !p.variants.length) return '';

      if (p.variantType === 'size') {
        return `<div class="search-prod-variants">
      ${p.variants.map(v => `<span class="search-size-pill">${v.label}</span>`).join('')}
    </div>`;
      }

      // shade / color
      return `<div class="search-prod-variants">
    ${p.variants.map(v => `<span class="search-swatch" style="background:${v.hex || '#F4B9CE'}" title="${v.label}"></span>`).join('')}
  </div>`;
    }

    /* ---------- FILTER LOGIC (category + search text are live; sort/price are UI-ready stubs) ---------- */
    function applyFilters() {
      let list = products;

      if (state.category) {
        list = list.filter(p => p.category === state.category);
      }
      if (state.sub) {
        list = list.filter(p => p.sub === state.sub);
      }
      if (state.query) {
        const q = state.query.toLowerCase();
        list = list.filter(p =>
          p.name.toLowerCase().includes(q) ||
          p.category.toLowerCase().includes(q) ||
          p.sub.toLowerCase().includes(q)
        );
      }

      if (state.priceMin !== null) {
        list = list.filter(p => p.price >= state.priceMin);
      }
      if (state.priceMax !== null) {
        list = list.filter(p => p.price <= state.priceMax);
      }

      // sort — clone before sorting so we never mutate the master `products` array
      if (state.sort) {
        list = [...list];
        if (state.sort === 'price-asc') list.sort((a, b) => a.price - b.price);
        else if (state.sort === 'price-desc') list.sort((a, b) => b.price - a.price);
        else if (state.sort === 'newest') list.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
        else if (state.sort === 'oldest') list.sort((a, b) => new Date(a.createdAt) - new Date(b.createdAt));
      }

      let label = 'Showing all products';
      if (state.sub) label = `Showing results for "${state.sub}"`;
      else if (state.category) label = `Showing results for "${state.category}"`;
      if (state.query) label += ` matching "${state.query}"`;
      resultsLabel.textContent = label;

      renderProducts(list);
    }

    /* ---------- SEARCH BAR ---------- */
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');

    function runSearch() {
      state.query = searchInput.value.trim();
      applyFilters();
    }
    searchBtn.addEventListener('click', runSearch);
    searchInput.addEventListener('keydown', e => {
      if (e.key === 'Enter') runSearch();
    });

    /* ---------- SORT ---------- */
    document.getElementById('sortSelect').addEventListener('change', (e) => {
      state.sort = e.target.value;
      applyFilters();
    });

    /* ---------- PRICE RANGE ---------- */
    const priceRange = document.getElementById('priceRange');
    const priceMax = document.getElementById('priceMax');
    priceRange.addEventListener('input', () => {
      priceMax.value = priceRange.value;
    });
    document.getElementById('applyPrice').addEventListener('click', () => {
      const minVal = document.getElementById('priceMin').value.trim();
      const maxVal = priceMax.value.trim();
      state.priceMin = minVal === '' ? null : Number(minVal);
      state.priceMax = maxVal === '' ? null : Number(maxVal);
      applyFilters();
    });

    /* ---------- RESET ---------- */
    function resetFilters() {
      state = {
        category: null,
        sub: null,
        query: '',
        sort: '',
        priceMin: null,
        priceMax: null
      };
      searchInput.value = '';
      document.getElementById('sortSelect').value = '';
      document.getElementById('priceMin').value = '';
      priceMax.value = '';
      priceRange.value = 5000;
      renderCatList();
      applyFilters();
    }
    document.getElementById('resetFilters').addEventListener('click', resetFilters);
    document.getElementById('resetFiltersBottom').addEventListener('click', resetFilters);

    /* ---------- INIT ---------- */
    renderCatList();
    applyFilters();
  </script>

</body>

</html>