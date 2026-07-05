/* ==========================================================================
   PiNK AURA — bag.js
   Shared "bag" (cart) logic, used on every page that includes the bag modal.
   Requires Bootstrap's bundle JS to be loaded before this file.
   ========================================================================== */

/* ---------- DEMO STATE ----------
   In-memory only for now — resets on page reload.
   Swap this for localStorage or a real backend when ready. */
let bagItems = [
  { id: 'vitamin-c-serum-30ml', name: 'Vitamin C Serum', variant: '30ml', price: 899, qty: 1, img: 'https://placehold.co/120x120/F3D6E2/4A1E30?text=VCS' },
  { id: 'rose-clay-mask-100g', name: 'Rose Clay Mask', variant: '100g', price: 499, qty: 2, img: 'https://placehold.co/120x120/E58EAD/FFFFFF?text=RCM' }
];

/* ---------- RENDER ---------- */
function renderBag() {
  const body = document.getElementById('bagBody');
  const countEls = document.querySelectorAll('.bag-count');
  const totalEl = document.getElementById('bagTotalAmount');

  if (!body) return; // bag modal not on this page

  const totalQty = bagItems.reduce((sum, item) => sum + item.qty, 0);
  const totalPrice = bagItems.reduce((sum, item) => sum + item.qty * item.price, 0);

  countEls.forEach(el => { el.textContent = totalQty; });
  if (totalEl) totalEl.textContent = `Rs ${totalPrice.toLocaleString()}`;

  if (!bagItems.length) {
    body.innerHTML = `<p class="bag-empty">Your bag is empty.</p>`;
    return;
  }

  body.innerHTML = bagItems.map(item => `
    <div class="bag-item">
      <img class="bag-item-img" src="${item.img}" alt="${item.name}">
      <div class="bag-item-info">
        <p class="bag-item-name">${item.name}</p>
        <p class="bag-item-price">Rs ${item.price.toLocaleString()}</p>
        <p class="bag-item-meta">Qty ${item.qty} &middot; ${item.variant}</p>
      </div>
      <button class="bag-item-remove" aria-label="Remove ${item.name}" onclick="removeFromBag('${item.id}')">&#10005;</button>
    </div>
  `).join('');
}

/* ---------- ACTIONS ---------- */
function removeFromBag(id) {
  bagItems = bagItems.filter(item => item.id !== id);
  renderBag();
}

/* Call this from any "Add to bag" button across the site, e.g.:
   addToBag({ id:'vitamin-c-serum-30ml', name:'Vitamin C Serum', variant:'30ml', price:899, img:'...' })
   If the same id+variant is already in the bag, it just bumps the qty. */
function addToBag(product, qty = 1) {
  const existing = bagItems.find(item => item.id === product.id);
  if (existing) {
    existing.qty += qty;
  } else {
    bagItems.push({ ...product, qty });
  }
  renderBag();
}

/* ---------- INIT ---------- */
document.addEventListener('DOMContentLoaded', () => {
  renderBag();

  const overlay = document.getElementById('bagOverlay');
  const drawer = document.getElementById('bagModal');
  if (!overlay || !drawer) return; // bag drawer not on this page

  function openBag() {
    overlay.classList.add('is-open');
    drawer.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  }
  function closeBag() {
    overlay.classList.remove('is-open');
    drawer.classList.remove('is-open');
    document.body.style.overflow = '';
  }

  document.querySelectorAll('[data-bag-toggle]').forEach(btn => {
    btn.addEventListener('click', openBag);
  });
  document.querySelectorAll('[data-bag-close]').forEach(el => {
    el.addEventListener('click', closeBag);
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeBag();
  });
});