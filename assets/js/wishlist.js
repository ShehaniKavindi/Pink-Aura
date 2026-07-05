/* ==========================================================================
   PiNK AURA — wishlist.js
   Shared wishlist logic, used on every page that includes the wishlist drawer.
   No framework dependency.
   ========================================================================== */

/* ---------- DEMO STATE ----------
   In-memory only for now — resets on page reload.
   Swap this for localStorage or a real backend when ready. */
let wishlistItems = [
  { id: 'glow-sunscreen-spf50', name: 'Glow Sunscreen SPF 50', price: 599, img: 'https://placehold.co/120x120/FBE7EE/8C7580?text=Sun' },
  { id: 'silk-rice-shampoo', name: 'Silk Rice Shampoo', price: 780, img: 'https://placehold.co/120x120/E58EAD/FFFFFF?text=Shampoo' }
];

/* ---------- RENDER ---------- */
function renderWishlist() {
  const body = document.getElementById('wishlistBody');
  const countEls = document.querySelectorAll('.wishlist-count');

  if (!body) return; // wishlist drawer not on this page

  countEls.forEach(el => { el.textContent = wishlistItems.length; });

  if (!wishlistItems.length) {
    body.innerHTML = `<p class="wishlist-empty">Your wishlist is empty.</p>`;
    return;
  }

  body.innerHTML = wishlistItems.map(item => `
    <div class="wishlist-item">
      <img class="wishlist-item-img" src="${item.img}" alt="${item.name}">
      <div class="wishlist-item-info">
        <p class="wishlist-item-name">${item.name}</p>
        <p class="wishlist-item-price">Rs ${item.price.toLocaleString()}</p>
      </div>
      <button class="wishlist-item-remove" aria-label="Remove ${item.name}" onclick="removeFromWishlist('${item.id}')">&#10005;</button>
    </div>
  `).join('');
}

/* ---------- ACTIONS ---------- */
function removeFromWishlist(id) {
  wishlistItems = wishlistItems.filter(item => item.id !== id);
  renderWishlist();
}

/* Call this from any wishlist heart icon across the site, e.g.:
   addToWishlist({ id:'rose-clay-mask-100g', name:'Rose Clay Mask', price:499, img:'...' })
   Won't add a duplicate if the id is already saved. */
function addToWishlist(product) {
  const exists = wishlistItems.some(item => item.id === product.id);
  if (!exists) {
    wishlistItems.push(product);
  }
  renderWishlist();
}

/* ---------- INIT ---------- */
document.addEventListener('DOMContentLoaded', () => {
  renderWishlist();

  const overlay = document.getElementById('wishlistOverlay');
  const drawer = document.getElementById('wishlistModal');
  if (!overlay || !drawer) return; // wishlist drawer not on this page

  function openWishlist() {
    overlay.classList.add('is-open');
    drawer.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  }
  function closeWishlist() {
    overlay.classList.remove('is-open');
    drawer.classList.remove('is-open');
    document.body.style.overflow = '';
  }

  document.querySelectorAll('[data-wishlist-toggle]').forEach(btn => {
    btn.addEventListener('click', openWishlist);
  });
  document.querySelectorAll('[data-wishlist-close]').forEach(el => {
    el.addEventListener('click', closeWishlist);
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeWishlist();
  });
});