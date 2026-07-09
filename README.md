# PiNK AURA 🌸

A minimal, modern e-commerce front end for **PiNK AURA**, a fictional cosmetics & skincare brand in the style of Kylie Cosmetics, Rare Beauty, Rhode, and Fenty Beauty. Built with plain HTML/CSS/JS on a locked, reusable design system — no frameworks, no build step.

> Status: 🚧 In active development — front-end pages and design system are underway; e-commerce logic (cart, checkout, real auth) is not yet implemented.

---

## Features

- Home page with a full-bleed hero, shop-by-category grid, promo banner, and bestsellers
- Dedicated category browsing page with clickable category tiles and subcategory panels
- Product view page
- Auth pages: login, register, forgot password
- Customer profile page
- Admin dashboard: revenue/orders/customers stats, recent orders table, activity feed, top products
- Fully responsive layouts (desktop → tablet → mobile)
- One shared design system reused across every page

## Tech stack

- HTML5, CSS3 (no preprocessor, no framework)
- Vanilla JavaScript (no dependencies)
- Google Fonts: [Fraunces](https://fonts.google.com/specimen/Fraunces) + [Work Sans](https://fonts.google.com/specimen/Work+Sans)

## Design system

All design tokens live in `assets/css/style.css` under `:root` and are locked — every page pulls from the same values, nothing is hardcoded per page.

`style.css` holds every **shared component** used across pages: buttons, inputs, the search bar, pills/tags, header/nav, and the footer. Page-specific styles (hero, product grid, dashboard layout, etc.) live in their own file next to it, e.g. `home.css`, `category.css`, `admin.css`.

## Project structure

```
pinkaura/
├── index.html
├── category.html
├── product-view.html
├── login.html
├── register.html
├── forgot-password.html
├── my-profile.html
├── admin.html
└── assets/
    ├── css/
    │   ├── style.css        # shared tokens + common components
    │   ├── home.css
    │   ├── category.css
    │   ├── product-view.css
    │   ├── auth.css
    │   ├── my-profile.css
    │   └── admin.css
    └── images/
        └── site-images/
```

## Getting started

No build tools needed — it's static HTML/CSS/JS.

1. Clone the repo
2. Open `index.html` directly in a browser, **or** serve it locally (recommended, so relative paths and any future fetch calls behave correctly):
   ```bash
   npx serve .
   # or, with the VS Code "Live Server" extension
   ```

## Product taxonomy

Makeup · Skincare · Hair Care · Nail Care · Fragrance · Bath & Body · Tools & Accessories · Sets & Bundles

---

## Roadmap

Rough order — each step builds on the last, so it's fine to go one at a time.

### 1. Finish the core storefront
- [ ] Shop / full product listing page with filters (category, price, rating)
- [ ] Wire up `product-view.html` to real product data instead of static placeholder content

### 2. Make it dynamic
- [ ] Move product/category data out of hardcoded HTML into a JSON file or small backend, and render pages from it
- [ ] Connect `login.html` / `register.html` / `forgot-password.html` to real authentication (no backend exists yet — these are UI only)
- [ ] Connect `my-profile.html` to real user/order data

### 3. Admin panel
- [ ] Add/edit/delete product forms
- [ ] Order status updates (Packing → Delivered → Returned) from the dashboard
- [ ] Basic auth/role protection so `admin.html` isn't publicly reachable

### 4. Real content
- [ ] Replace all `placehold.co` placeholder images with real product/model photography
- [ ] Replace placeholder Sri Lankan sample names/orders in the admin dashboard with real data once orders exist

### 5. Polish
- [ ] Accessibility pass (alt text, focus states, ARIA labels on icon-only buttons)
- [ ] Basic SEO (meta descriptions, Open Graph tags, favicon)
- [ ] Performance pass (image compression/lazy-loading once real photos are in)
- [ ] Cross-browser check (Safari, Firefox, mobile browsers)

### 6. Ship it
- [ ] Pick hosting (Netlify/Vercel/GitHub Pages for static, or a real host once a backend exists)
- [ ] Custom domain
- [ ] Basic analytics

---

## Author

Built by **Shehani** ([@dracilla](#)) — design system, storefront, and admin dashboard.
