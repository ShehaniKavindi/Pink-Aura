<?php include "includes/connection.php"; ?>
<?php
Database::setUpConnection();

/* ==========================================================================
   Load categories -> subcategories -> one example product (+ image) each.
   Shape: [{ key, name, size, count, subs:[{label, product, image}] }]
   ========================================================================== */

$categories = [];

$cat_rs = Database::search("SELECT * FROM `categories` ORDER BY `category_id`");
$cat_count = $cat_rs->num_rows;

for ($i = 0; $i < $cat_count; $i++) {
  $cat = $cat_rs->fetch_assoc();
  $catId = $cat['category_id'];

  $sub_rs = Database::search("SELECT * FROM `subcategories` WHERE `category_id`='" . $catId . "' ORDER BY `subcategory_id`");
  $sub_num = $sub_rs->num_rows;

  $subs = [];
  $productTotal = 0;

  for ($j = 0; $j < $sub_num; $j++) {
    $sub = $sub_rs->fetch_assoc();
    $subId = $sub['subcategory_id'];

    // how many products in this subcategory
    $count_rs = Database::search("SELECT COUNT(*) AS cnt FROM `products` WHERE `subcategory_id`='" . $subId . "'");
    $subProductCount = (int) $count_rs->fetch_assoc()['cnt'];
    $productTotal += $subProductCount;

    // one example product (most recent) + its primary image, if any
    $prod_rs = Database::search(
      "SELECT `p`.`title`, `pi`.`image_url`
             FROM `products` `p`
             LEFT JOIN `product_images` `pi`
                    ON `pi`.`product_id` = `p`.`product_id` AND `pi`.`is_primary` = '1'
             WHERE `p`.`subcategory_id` = '" . $subId . "'
             ORDER BY `p`.`created_at` DESC
             LIMIT 1"
    );
    $prod = $prod_rs->num_rows ? $prod_rs->fetch_assoc() : null;

    $subs[] = [
      'label'   => $sub['name'],
      'product' => $prod ? $prod['title'] : null,
      'image'   => ($prod && !empty($prod['image_url'])) ? $prod['image_url'] : null,
    ];
  }

  // keep the original "first tile large, last two wide" layout, now data-driven by position
  $size = '';
  if ($i === 0) {
    $size = 'large';
  } elseif ($i >= $cat_count - 2) {
    $size = 'wide';
  }

  $categories[] = [
    'key'   => $cat['slug'],
    'name'  => $cat['name'],
    'size'  => $size,
    'count' => $sub_num . ' subcategor' . ($sub_num === 1 ? 'y' : 'ies')
      . ' · ' . $productTotal . ' product' . ($productTotal === 1 ? '' : 's'),
    'subs'  => $subs,
  ];
}

$categoriesJSON = json_encode($categories, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PiNK AURA — Shop by category</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;1,400&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/category.css">

  <link rel="icon" href="assets/images/site-images/logo.png" />
</head>

<body>

  <?php include "header.php" ?>

  <div class="hero">
    <p class="eyebrow">Shop by category</p>
    <h1 class="hero-title">Find your <em>glow</em>, aisle by aisle</h1>
    <p class="hero-sub">Eight categories, everything you need. Tap one to see what's inside.</p>
  </div>

  <div class="wrap">
    <div class="grid" id="grid"></div>
  </div>

  <?php include "footer.php" ?>

  <script src="assets/js/wishlist.js"></script>
  <script src="assets/js/bag.js"></script>
  <script>
    // categories now come straight from the database (see PHP block above)
    const categories = <?php echo $categoriesJSON; ?>;

    const grid = document.getElementById('grid');
    let active = null; // null = show full grid, no category selected yet

    function escapeHtml(str) {
      if (str === null || str === undefined) return '';
      return String(str).replace(/[&<>"']/g, m => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
      } [m]));
    }

    function tileHTML(c, i, extraClass = '') {
      return `
    <div class="tile ${c.size} ${extraClass}" data-key="${c.key}">
      <div class="tile-index">${String(i+1).padStart(2,'0')}</div>
      <div>
        <p class="tile-name">${escapeHtml(c.name)}</p>
        <p class="tile-count">${escapeHtml(c.count)}</p>
      </div>
      ${c.size==='wide' ? '<div class="tile-arrow">&rarr;</div>' : ''}
    </div>
  `;
    }

    function panelHTML(cat) {
      return `
    <div class="panel-row">
      <div class="panel">
        <div class="panel-head">
          <h2>${escapeHtml(cat.name)}</h2>
          <span class="tag">${cat.subs.length} subcategor${cat.subs.length === 1 ? 'y' : 'ies'}</span>
        </div>
        ${cat.subs.length ? cat.subs.map(s => `
          <div class="sub-card">
            <p class="sub-name">${escapeHtml(s.label)}</p>
            <div class="sub-swatch"${s.image ? ` style="background-image:url('${escapeHtml(s.image)}')"` : ''}></div>
            ${s.product
              ? `<p class="prod-name">${escapeHtml(s.product)}</p>
                 <p class="prod-example">Example product <b>from ${escapeHtml(s.label)}</b></p>`
              : `<p class="prod-name">Coming soon</p>
                 <p class="prod-example">No products yet in <b>${escapeHtml(s.label)}</b></p>`
            }
          </div>
        `).join('') : '<p class="prod-example">No subcategories yet.</p>'}
      </div>
    </div>
  `;
    }

    function render() {
      if (!categories.length) {
        grid.innerHTML = '<p class="prod-example">No categories yet — add some from the admin panel.</p>';
        return;
      }

      if (active === null) {
        // ---- grid view: show every category tile, nothing selected ----
        grid.innerHTML = categories.map((c, i) => tileHTML(c, i)).join('');
      } else {
        // ---- detail view: only the selected tile, right above its subcategories ----
        const activeIndex = categories.findIndex(c => c.key === active);
        const cat = categories[activeIndex];

        grid.innerHTML = `
          <div class="back-row">
            <button type="button" class="back-link" id="backBtn">&larr; All categories</button>
          </div>
          ${tileHTML(cat, activeIndex, 'active solo')}
          ${panelHTML(cat)}
        `;

        document.getElementById('backBtn').addEventListener('click', () => {
          active = null;
          render();
        });
      }

      grid.querySelectorAll('.tile').forEach(tile => {
        tile.addEventListener('click', () => {
          active = tile.dataset.key;
          render();
        });
      });
    }

    render();
  </script>

</body>

</html>