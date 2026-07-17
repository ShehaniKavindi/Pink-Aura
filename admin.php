<?php include "includes/connection.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PiNK AURA — Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/admin.css">

  <link rel="icon" href="assets/images/site-images/logo.png" />
</head>

<body class="admin-body">

  <div class="admin-layout">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
      <div class="admin-brand">
        <span class="admin-mark"></span>
        <div class="admin-logo">PiNK <span>AURA</span></div>
        <div class="admin-logo-sub">Admin panel</div>
      </div>

      <nav class="admin-nav">
        <div class="admin-nav-group">
          <p class="admin-nav-label">Overview</p>
          <button class="admin-nav-link active" data-section="dashboard">
            <span class="admin-nav-icon">&#9638;</span> Dashboard
          </button>
        </div>

        <div class="admin-nav-group">
          <p class="admin-nav-label">Products</p>
          <button class="admin-nav-link" data-section="product-add">
            <span class="admin-nav-icon">&#10133;</span> Add new product
          </button>
          <button class="admin-nav-link" data-section="product-manage">
            <span class="admin-nav-icon">&#128230;</span> Manage products
          </button>
          <button class="admin-nav-link" data-section="stock-add">
            <span class="admin-nav-icon">&#128203;</span> Add new stock
          </button>
        </div>

        <div class="admin-nav-group">
          <p class="admin-nav-label">Manage</p>
          <button class="admin-nav-link" data-section="orders">
            <span class="admin-nav-icon">&#128179;</span> Orders
          </button>
          <button class="admin-nav-link" data-section="customers">
            <span class="admin-nav-icon">&#128100;</span> Customers
          </button>
          <button class="admin-nav-link" data-section="categories">
            <span class="admin-nav-icon">&#9776;</span> Categories
          </button>
          <button class="admin-nav-link" data-section="admins">
            <span class="admin-nav-icon">&#128737;</span> Admins
          </button>
        </div>

        <div class="admin-nav-group">
          <p class="admin-nav-label">System</p>
          <button class="admin-nav-link" data-section="profile">
            <span class="admin-nav-icon">&#9881;</span> Profile
          </button>
        </div>
      </nav>

      <div class="admin-user">
        <div class="admin-avatar">P</div>
        <div class="admin-user-info">
          <p class="admin-user-name">pinkaura</p>
          <p class="admin-user-role">Super admin</p>
        </div>
        <button class="admin-logout" aria-label="Log out">&#10132;</button>
      </div>
    </aside>

    <!-- MAIN -->
    <div class="admin-content-wrap">

      <!-- TOPBAR -->
      <header class="admin-topbar">
        <div class="admin-topbar-right">
          <div class="admin-datetime">
            <span id="adminDate">&mdash;</span>
            <span class="admin-dot-sep">&middot;</span>
            <span id="adminTime">&mdash;</span>
          </div>
          <div class="admin-chip">
            <span class="admin-chip-avatar">P</span>
            <span class="admin-chip-name">pinkaura</span>
          </div>
        </div>
      </header>

      <main class="admin-main">

        <!-- ================= DASHBOARD ================= -->
        <section class="content-section active" id="section-dashboard">
          <h1 class="admin-page-title">Dashboard</h1>

          <div class="admin-stats">
            <div class="admin-stat-card stat-a">
              <p class="admin-stat-label">Total revenue</p>
              <p class="admin-stat-value">Rs 128,450.00</p>
              <p class="admin-stat-note">from placed orders</p>
            </div>
            <div class="admin-stat-card stat-b">
              <p class="admin-stat-label">Total products</p>
              <p class="admin-stat-value" id="statProductCount">0</p>
              <p class="admin-stat-note">across all categories</p>
            </div>
            <div class="admin-stat-card stat-c">
              <p class="admin-stat-label">Orders</p>
              <p class="admin-stat-value">46</p>
              <p class="admin-stat-note">total orders</p>
            </div>
            <div class="admin-stat-card stat-d">
              <p class="admin-stat-label">Low stock alerts</p>
              <p class="admin-stat-value" id="statLowStockCount">0</p>
              <p class="admin-stat-note">needs restocking</p>
            </div>
          </div>

          <div class="admin-panels">
            <div class="admin-panel">
              <div class="admin-panel-head">
                <h2>Low stock products</h2>
                <span class="pill">Threshold: 5 units</span>
              </div>
              <ul class="admin-mini-list" id="lowStockList"></ul>
            </div>

            <div class="admin-panel">
              <div class="admin-panel-head">
                <h2>Best selling products</h2>
                <span class="link">View all &rarr;</span>
              </div>
              <ul class="admin-mini-list" id="bestSellerList"></ul>
            </div>

            <div class="admin-panel admin-panel-pie">
              <div class="admin-panel-head">
                <h2>Products by category</h2>
              </div>
              <div class="pie-wrap">
                <div class="pie-chart" id="pieChart"></div>
                <div class="pie-legend" id="pieLegend"></div>
              </div>
            </div>
          </div>

          <div class="admin-panels-secondary">
            <div class="admin-panel admin-panel-orders">
              <div class="admin-panel-head">
                <h2>Recent orders</h2>
                <a href="#" class="link">View all &rarr;</a>
              </div>
              <table class="admin-table">
                <thead>
                  <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>#134</td>
                    <td>Sanduni Perera</td>
                    <td>Rs 2,398.00</td>
                    <td><span class="admin-badge admin-badge-packing">Packing</span></td>
                  </tr>
                  <tr>
                    <td>#133</td>
                    <td>Dilki Fernando</td>
                    <td>Rs 1,197.00</td>
                    <td><span class="admin-badge admin-badge-delivered">Delivered</span></td>
                  </tr>
                  <tr>
                    <td>#132</td>
                    <td>Thivanka Silva</td>
                    <td>Rs 3,594.00</td>
                    <td><span class="admin-badge admin-badge-returned">Returned</span></td>
                  </tr>
                  <tr>
                    <td>#131</td>
                    <td>Shehani Kavindi</td>
                    <td>Rs 899.00</td>
                    <td><span class="admin-badge admin-badge-packing">Packing</span></td>
                  </tr>
                  <tr>
                    <td>#130</td>
                    <td>Nethmi Wickrama</td>
                    <td>Rs 1,796.00</td>
                    <td><span class="admin-badge admin-badge-delivered">Delivered</span></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="admin-panel admin-panel-activity">
              <div class="admin-panel-head">
                <h2>Activity</h2>
                <a href="#" class="link">Clear</a>
              </div>
              <ul class="admin-activity-list">
                <li><span class="admin-dot"></span> New order #134 placed by Sanduni Perera <span class="admin-time">Recent</span></li>
                <li><span class="admin-dot"></span> New order #133 placed by Dilki Fernando <span class="admin-time">Recent</span></li>
                <li><span class="admin-dot"></span> New order #132 placed by Thivanka Silva <span class="admin-time">Recent</span></li>
                <li><span class="admin-dot admin-dot-alert"></span> Low stock &ndash; Rose Clay Mask (4 left) <span class="admin-time">Now</span></li>
                <li><span class="admin-dot admin-dot-alert"></span> Low stock &ndash; Glow Sunscreen SPF 50 (2 left) <span class="admin-time">Now</span></li>
                <li><span class="admin-dot admin-dot-alert"></span> Low stock &ndash; Vitamin C Serum (3 left) <span class="admin-time">Now</span></li>
              </ul>
            </div>
          </div>
        </section>

        <!-- ================= ADD NEW PRODUCT ================= -->
        <section class="content-section" id="section-product-add">
          <h1 class="admin-page-title">Add new product</h1>

          <div class="product-add-layout">

            <!-- FORM -->
            <div class="admin-panel admin-form-panel">
              <form id="productForm" onsubmit="event.preventDefault(); saveProduct();">

                <div class="form-row">
                  <div class="form-field">
                    <label for="pMainCategory">Main category</label>
                    <select id="pMainCategory" onchange="loadSubCategories();">
                      <?php
                      $cat_rs = Database::search("SELECT * FROM `categories` ");
                      $cat_num = $cat_rs->num_rows;
                      for ($cat=0; $cat < $cat_num; $cat++) { 
                        $cat_data = $cat_rs->fetch_assoc();
                        ?>
                        <option value="<?php echo $cat_data['category_id']; ?>"><?php echo $cat_data['name']; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-field">
                    <label for="pSubCategory">Sub category</label>
                    <select id="pSubCategory"></select>
                  </div>
                </div>

                <div class="form-field">
                  <label for="pTitle">Product title</label>
                  <input type="text" id="pTitle" placeholder="e.g. Vitamin C Serum">
                </div>

                <div class="form-field">
                  <label for="pVariantType">Variant type</label>
                  <select id="pVariantType">
                    <option value="none">None &mdash; single price &amp; stock</option>
                    <option value="size">Size (e.g. 30ml, 100ml)</option>
                    <option value="shade">Shade (skin-tone matched)</option>
                    <option value="color">Color (lipstick, nail polish, etc.)</option>
                  </select>
                  <p class="field-hint">Skincare is usually Size. Foundations/concealers are Shade. Lipstick, blush,
                    nail polish are Color.</p>
                </div>

                <!-- shown when variant type = none -->
                <div class="form-row" id="singlePriceStockRow">
                  <div class="form-field">
                    <label for="pPrice">Unit price (Rs)</label>
                    <input type="text" id="pPrice" placeholder="899">
                  </div>
                  <div class="form-field">
                    <label for="pStock">Quantity in stock</label>
                    <input type="text" id="pStock" placeholder="20">
                  </div>
                </div>

                <!-- shown when variant type = size / shade / color -->
                <div class="form-field" id="variantSection" hidden>
                  <label id="variantSectionLabel">Sizes</label>
                  <div class="variant-rows" id="variantRows"></div>
                  <button type="button" class="btn outline small" id="addVariantBtn">+ Add another</button>
                  <p class="field-hint">Tap the small square on a row to attach that shade/color's own photo (optional — falls back to the general product images below).</p>
                  <input type="file" id="variantImageFileInput" accept="image/*" hidden>
                </div>

                <div class="form-field">
                  <label for="pDesc">Description</label>
                  <textarea id="pDesc" rows="4" placeholder="Short product description..."></textarea>
                </div>

                <div class="form-field">
                  <label for="pIngredients">Key ingredients / Materials used</label>
                  <textarea id="pIngredients" rows="3" placeholder="e.g. Vitamin C, Hyaluronic acid, Niacinamide"></textarea>
                </div>

                <div class="form-field">
                  <label for="pHowToUse">How to use</label>
                  <textarea id="pHowToUse" rows="3" placeholder="e.g. Apply 2-3 drops to clean skin morning and night."></textarea>
                </div>

                <div class="form-field">
                  <label>Product images (up to 4)</label>
                  <div class="image-upload-grid" id="imageUploadGrid">
                    <button type="button" class="image-add-btn" id="imageAddBtn">+</button>
                  </div>
                  <p class="image-upload-hint">First photo becomes the main product image on the card.</p>
                  <input type="file" id="imageFileInput" accept="image/*" multiple hidden>
                </div>

                <button type="submit" class="btn">Save product</button>
              </form>
            </div>

            <!-- LIVE PREVIEW -->
            <div class="admin-panel live-preview-panel">
              <div class="admin-panel-head">
                <h2>Live preview</h2>
                <span class="pill">Product card</span>
              </div>

              <div class="live-prod-card">
                <div class="live-prod-image">
                  <img id="previewImg" src="https://placehold.co/320x300/F3D6E2/4A1E30?text=Product+image" alt="Preview">
                  <div class="wishlist">&#9825;</div>
                </div>
                <div class="live-prod-body">
                  <p class="live-prod-cat" id="previewCat">Main category &middot; Sub category</p>
                  <p class="live-prod-name" id="previewName">Product title</p>
                  <div class="live-prod-variants" id="previewVariants" hidden></div>
                  <div class="live-prod-price-row">
                    <div class="live-prod-price" id="previewPrice">Rs 0</div>
                    <button class="prod-cart" type="button" aria-label="Add to bag">&#128722;</button>
                  </div>
                </div>
              </div>

              <p class="live-preview-note">Updates as you fill in the form &mdash; this is exactly how the card will look on the storefront.</p>
            </div>

          </div>
        </section>

        <!-- ================= MANAGE PRODUCTS ================= -->
        <section class="content-section" id="section-product-manage">
          <h1 class="admin-page-title">Manage products</h1>
          <div class="admin-panel">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Stock</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="manageProductsBody"></tbody>
            </table>
          </div>
        </section>

        <!-- ================= ADD NEW STOCK ================= -->
        <section class="content-section" id="section-stock-add">
          <h1 class="admin-page-title">Add new stock</h1>
          <div class="admin-panel admin-form-panel">
            <form onsubmit="event.preventDefault(); document.getElementById('stockConfirm').style.display='block';">
              <div class="form-field">
                <label for="stockProduct">Product</label>
                <select id="stockProduct"></select>
              </div>
              <div class="form-field">
                <label for="stockQty">Quantity to add</label>
                <input type="text" id="stockQty" placeholder="e.g. 25">
              </div>
              <button type="submit" class="btn">Update stock</button>
              <p class="form-confirm" id="stockConfirm">Stock updated &mdash; not yet connected to a backend, this is a UI stub.</p>
            </form>
          </div>
        </section>

        <!-- ================= ORDERS ================= -->
        <section class="content-section" id="section-orders">
          <h1 class="admin-page-title">Orders</h1>
          <div class="admin-panel">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Order</th>
                  <th>Customer</th>
                  <th>Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>#134</td>
                  <td>Sanduni Perera</td>
                  <td>Rs 2,398.00</td>
                  <td><span class="admin-badge admin-badge-packing">Packing</span></td>
                </tr>
                <tr>
                  <td>#133</td>
                  <td>Dilki Fernando</td>
                  <td>Rs 1,197.00</td>
                  <td><span class="admin-badge admin-badge-delivered">Delivered</span></td>
                </tr>
                <tr>
                  <td>#132</td>
                  <td>Thivanka Silva</td>
                  <td>Rs 3,594.00</td>
                  <td><span class="admin-badge admin-badge-returned">Returned</span></td>
                </tr>
                <tr>
                  <td>#131</td>
                  <td>Shehani Kavindi</td>
                  <td>Rs 899.00</td>
                  <td><span class="admin-badge admin-badge-packing">Packing</span></td>
                </tr>
                <tr>
                  <td>#130</td>
                  <td>Nethmi Wickrama</td>
                  <td>Rs 1,796.00</td>
                  <td><span class="admin-badge admin-badge-delivered">Delivered</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <!-- ================= CUSTOMERS ================= -->
        <section class="content-section" id="section-customers">
          <h1 class="admin-page-title">Customers</h1>
          <div class="admin-panel">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Orders</th>
                  <th>Total spent</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Sanduni Perera</td>
                  <td>sanduni.p@email.com</td>
                  <td>4</td>
                  <td>Rs 6,120.00</td>
                </tr>
                <tr>
                  <td>Dilki Fernando</td>
                  <td>dilki.f@email.com</td>
                  <td>2</td>
                  <td>Rs 2,494.00</td>
                </tr>
                <tr>
                  <td>Thivanka Silva</td>
                  <td>thivanka.s@email.com</td>
                  <td>6</td>
                  <td>Rs 9,880.00</td>
                </tr>
                <tr>
                  <td>Shehani Kavindi</td>
                  <td>shehani.k@email.com</td>
                  <td>1</td>
                  <td>Rs 899.00</td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <!-- ================= CATEGORIES ================= -->
        <section class="content-section" id="section-categories">
          <h1 class="admin-page-title">Categories</h1>
          <div class="admin-panel">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Category</th>
                  <th>Products</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="categoriesBody"></tbody>
            </table>
          </div>
        </section>

        <!-- ================= ADMINS ================= -->
        <section class="content-section" id="section-admins">
          <h1 class="admin-page-title">Admins</h1>
          <div class="admin-panel">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Last active</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Shehani Kavindi</td>
                  <td>Super admin</td>
                  <td>Now</td>
                </tr>
                <tr>
                  <td>Nethmi Wickrama</td>
                  <td>Admin</td>
                  <td>2 hours ago</td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <!-- ================= PROFILE ================= -->
        <section class="content-section" id="section-profile">
          <h1 class="admin-page-title">Profile</h1>
          <div class="admin-panel admin-form-panel">
            <form onsubmit="event.preventDefault();">
              <div class="form-field">
                <label for="profName">Name</label>
                <input type="text" id="profName" value="Shehani Kavindi">
              </div>
              <div class="form-field">
                <label for="profEmail">Email</label>
                <input type="email" id="profEmail" value="shehani@pinkaura.com">
              </div>
              <div class="form-field">
                <label for="profRole">Role</label>
                <input type="text" id="profRole" value="Super admin" disabled>
              </div>
              <button type="submit" class="btn">Save changes</button>
            </form>
          </div>
        </section>

      </main>
    </div>
  </div>

  <!-- toast -->
  <div class="toast-msg" id="toast-msg">
    <i id="toast-icon" class="fa-solid fa-circle-xmark"></i>
    <span id="toast-text" class="toast-text"></span>
  </div>

  <script src="assets/js/admin.js"></script>

</body>

</html>