# PiNK AURA 🌸

A minimal, modern e-commerce site for **PiNK AURA**, a fictional cosmetics & skincare brand in the style of Kylie Cosmetics, Rare Beauty, Rhode, and Fenty Beauty. Front end is plain HTML/CSS/JS on a locked, reusable design system; the admin panel runs on PHP + MySQL — no frameworks, no build step.

> Status: 🚧 In active development — design system and storefront pages are done, the admin panel can create real products in the database, but the storefront itself still displays static placeholder content (not yet wired to the database), and there's no real customer auth or checkout yet.

---

## Features

- Home page with a full-bleed hero, shop-by-category grid, promo banner, and bestsellers
- Dedicated category browsing page with clickable category tiles and subcategory panels
- Product view page (static content — not yet connected to the database)
- Search page
- Auth pages: login, register, forgot password (UI only, no real authentication yet)
- Customer profile page
- Cart ("bag") and wishlist drawers (front-end only — not yet persisted per user)
- **Admin panel** (`admin.php`), backed by a real MySQL database:
  - Dashboard: revenue/orders/customers stats, recent orders table, activity feed, top products (still sample data)
  - **Add new product** — fully functional: category/subcategory selection, variant types (none / size / shade / color), per-variant price & stock, optional per-variant image (e.g. a distinct photo per lipstick shade), up to 4 general product images, and toast notifications on save
  - Manage products, Add stock, Orders, Customers, Categories, Admins — UI stubs, not yet wired up
- Fully responsive layouts (desktop → tablet → mobile)
- One shared design system reused across every page

## Tech stack

- HTML5, CSS3 (no preprocessor, no framework)
- Vanilla JavaScript (no dependencies)
- PHP (procedural, `mysqli`) for the admin panel's backend
- MySQL for product/category/variant/image storage
- Google Fonts: [Fraunces](https://fonts.google.com/specimen/Fraunces) + [Work Sans](https://fonts.google.com/specimen/Work+Sans)
- Font Awesome (icons — login/register/admin pages)

## Design system

All design tokens live in `assets/css/style.css` under `:root` and are locked — every page pulls from the same values, nothing is hardcoded per page.

`style.css` also holds every **shared component** used across pages: buttons, inputs, the search bar, pills/tags, toast notifications, header/nav, and the footer. Page-specific styles (hero, product grid, dashboard layout, etc.) live in their own file next to it, e.g. `home.css`, `category.css`, `admin.css`.

## Project structure

```
pinkaurabydracilla/
├── index.html
├── category.html
├── product-view.html
├── search.html
├── about.html
├── contact.html
├── blog.html
├── login.html
├── register.html
├── forgot-passwowrd.html
├── my-profile.html
├── admin.php
├── migration_variant_images.sql
├── includes/
│   └── connection.php        # mysqli connection (Database class)
├── process/
│   ├── saveProduct.php       # inserts into products / product_variants / product_images
│   └── loadSubCategories.php # AJAX: subcategories for a chosen main category
└── assets/
    ├── css/
    │   ├── style.css         # shared tokens + common components + toast
    │   ├── home.css
    │   ├── category.css
    │   ├── product-view.css
    │   ├── search.css
    │   ├── about.css
    │   ├── contact.css
    │   ├── blog.css
    │   ├── auth.css
    │   ├── my-profile.css
    │   └── admin.css
    ├── js/
    │   ├── admin.js
    │   ├── bag.js
    │   └── wishlist.js
    └── images/
        ├── site-images/
        └── products/
```

## Database

Schema lives in your local MySQL instance (`pinkaurabydracilla` database). Core tables: `categories`, `subcategories`, `products`, `product_variants`, `product_images` (with an optional `variant_id` for shade/color-specific photos — see `migration_variant_images.sql`), `users`, `admins`, `addresses`, `orders`, `order_items`, `cart_items`, `wishlist_items`, `reviews`, `blog_posts`, `contact_messages`.

⚠️ `includes/connection.php` currently has the DB password hardcoded in plain text. Fine for local dev — move it to an environment variable or a gitignored config file before this touches a shared repo or production.

## Getting started

The storefront pages are static and can be opened directly or served with anything. The admin panel needs PHP + MySQL:

1. Clone the repo
2. Import the database schema (and run `migration_variant_images.sql` if not already applied)
3. Update `includes/connection.php` with your local DB credentials
4. Serve the project through a PHP-capable server (e.g. XAMPP/MAMP, or `php -S localhost:8000`)
5. Visit `admin.php` to add products; open the static `.html` pages directly for the storefront

## Product taxonomy

Makeup / Cosmetics · Skincare · Hair Care · Nail Care · Fragrance · Bath & Body · Tools & Accessories · Men's Grooming · Sets & Bundles

---

## Roadmap

Rough order — each step builds on the last, so it's fine to go one at a time.

### 1. Finish the admin → database pipeline
- [x] Add new product form (variant types: none / size / shade / color)
- [x] Per-variant images (e.g. a distinct photo per lipstick shade)
- [x] Toast notifications for success/error states (shared, in `style.css`)
- [ ] Manage products: list real products from the DB, with edit and delete
- [ ] Add stock: connect to `product_variants.stock_qty` for real restocks
- [ ] Categories tab: manage categories/subcategories from the UI instead of the DB directly
- [ ] Dashboard stats (revenue, orders, low stock, best sellers, products-by-category pie) pulled from real tables instead of sample data

### 2. Connect the storefront to real data
- [ ] Convert storefront pages from `.html` to `.php` (or introduce a small API) so they can query the database
- [ ] Home page: real bestsellers/categories instead of placeholder content
- [ ] Category page: list real products per subcategory
- [ ] Product view page: pull a real product's variants, images (including per-variant shade photos), price, and stock; swap the displayed photo when a shade/color is selected
- [ ] Search page: query real products instead of static markup

### 3. Real customer accounts
- [ ] Connect `login.html` / `register.html` / `forgot-passwowrd.html` to real authentication against the `users` table (currently UI only, no backend)
- [ ] Session handling + route protection for logged-in-only pages (`my-profile.html`, checkout)
- [ ] Connect `my-profile.html` to real user/order/address data

### 4. Cart, wishlist & checkout
- [ ] Persist `bag.js` (cart) against `cart_items` for logged-in users instead of front-end-only state
- [ ] Persist `wishlist.js` against `wishlist_items`
- [ ] Checkout flow: address selection, order creation (`orders` / `order_items`), order confirmation
- [ ] Order status tracking (Packing → Delivered → Returned) visible to the customer and editable from the admin dashboard

### 5. Admin panel hardening
- [ ] Basic auth/role protection so `admin.php` isn't publicly reachable (currently no login gate)
- [ ] Move DB credentials out of `includes/connection.php` and into an environment-based config
- [ ] Input validation/sanitization audit on `saveProduct.php` and any future write endpoints

### 6. Real content
- [ ] Replace all `placehold.co` placeholder images with real product/model photography
- [ ] Replace placeholder Sri Lankan sample names/orders in the admin dashboard with real data once orders exist
- [ ] Reviews: connect the `reviews` table to the product view page

### 7. Polish
- [ ] Accessibility pass (alt text, focus states, ARIA labels on icon-only buttons)
- [ ] Basic SEO (meta descriptions, Open Graph tags, favicon)
- [ ] Performance pass (image compression/lazy-loading once real photos are in)
- [ ] Cross-browser check (Safari, Firefox, mobile browsers)
- [ ] Clean up scratch files (`test.html`, `test.css`) and fix the `forgot-passwowrd.html` filename typo

### 8. Ship it
- [ ] Pick hosting with PHP + MySQL support
- [ ] Custom domain
- [ ] Basic analytics

---

## Author

Built by **Shehani** ([@dracilla](#)) — design system, storefront, and admin dashboard.
