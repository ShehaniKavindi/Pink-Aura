/* ==========================================================================
   PiNK AURA — bag.js
   Shared "bag" (cart) logic, used on every page that includes the bag modal
   or just the header bag-count badge.
   Cart is now persisted server-side in `cart_items`, keyed to the logged-in
   user's session. Requires Bootstrap's bundle JS to be loaded before this
   file if the page uses the bag drawer.
   ========================================================================== */

let bagItems = [];

/* ---------- LIGHTWEIGHT TOAST (self-contained, works on any page) ---------- */
function bagToast(message, type = 'success') {
  let el = document.getElementById('bag-toast-msg');
  if (!el) {
    el = document.createElement('div');
    el.id = 'bag-toast-msg';
    el.style.position = 'fixed';
    el.style.top = '28px';
    el.style.left = '50%';
    el.style.transform = 'translateX(-50%) translateY(20px)';
    el.style.padding = '12px 22px';
    el.style.borderRadius = '999px';
    el.style.fontFamily = 'var(--font-body, sans-serif)';
    el.style.fontSize = '13.5px';
    el.style.fontWeight = '500';
    el.style.color = '#fff';
    el.style.boxShadow = '0 10px 30px rgba(0,0,0,0.18)';
    el.style.opacity = '0';
    el.style.transition = 'opacity .2s ease, transform .2s ease';
    el.style.zIndex = '9999';
    el.style.pointerEvents = 'none';
    document.body.appendChild(el);
  }

  el.textContent = message;
  el.style.background = type === 'error' ? '#C4536B' : (type === 'warning' ? '#B8863B' : '#2B1E24');
  el.style.opacity = '1';
  el.style.transform = 'translateX(-50%) translateY(0)';

  clearTimeout(bagToast._timer);
  bagToast._timer = setTimeout(() => {
    el.style.opacity = '0';
    el.style.transform = 'translateX(-50%) translateY(20px)';
  }, 2200);
}

/* ---------- FETCH CART FROM SERVER ---------- */
async function fetchCart() {
  try {
    const res = await fetch('process/getCart.php');
    const data = await res.json();
    bagItems = Array.isArray(data) ? data : [];
  } catch (err) {
    bagItems = [];
  }
  renderBag();
}

/* ---------- RENDER ---------- */
function renderBag() {
  const body = document.getElementById('bagBody');
  const countEls = document.querySelectorAll('.bag-count');
  const totalEl = document.getElementById('bagTotalAmount');

  const totalQty = bagItems.reduce((sum, item) => sum + item.qty, 0);
  const totalPrice = bagItems.reduce((sum, item) => sum + item.qty * item.price, 0);

  // update the header badge even on pages without the full bag drawer
  countEls.forEach(el => { el.textContent = totalQty; });
  if (totalEl) totalEl.textContent = `Rs ${totalPrice.toLocaleString()}`;

  if (!body) return; // bag drawer not on this page, nothing else to render

  if (!bagItems.length) {
    body.innerHTML = `<p class="bag-empty">Your bag is empty.</p>`;
    return;
  }

  body.innerHTML = bagItems.map(item => `
    <div class="bag-item">
      <img class="bag-item-img" src="${item.img ? item.img : 'https://placehold.co/120x120/F3D6E2/4A1E30?text=' + encodeURIComponent(item.name)}" alt="${item.name}">
      <div class="bag-item-info">
        <p class="bag-item-name">${item.name}</p>
        <p class="bag-item-price">Rs ${item.price.toLocaleString()}</p>
        <p class="bag-item-meta">Qty ${item.qty} &middot; ${item.variant}</p>
      </div>
      <button class="bag-item-remove" aria-label="Remove ${item.name}" onclick="removeFromBag(${item.id})">&#10005;</button>
    </div>
  `).join('');
}

/* ---------- ACTIONS ---------- */

/* Call this from any "Add to bag" button across the site with the
   product_variants.variant_id you want to add, e.g.:
     addToBag(14);        // qty defaults to 1
     addToBag(14, 2);
   Handles products that have exactly one variant row (variantType 'none')
   the same way as products with real size/shade/color choices — the caller
   is responsible for making sure a variant has actually been chosen before
   calling this. */
async function addToBag(variantId, qty = 1) {
  const form = new FormData();
  form.append('variant_id', variantId);
  form.append('qty', qty);

  try {
    const res = await fetch('process/addToCart.php', { method: 'POST', body: form });
    const response = (await res.text()).trim();

    if (response === 'success') {
      await fetchCart();
      bagToast('Added to your bag.', 'success');
    } else if (response === 'not_logged_in') {
      bagToast('Please sign in to add items to your bag.', 'warning');
      setTimeout(() => { window.location.href = 'login.php'; }, 1200);
    } else {
      bagToast(response.replace(/^error:\s*/, '') || 'Could not add to bag.', 'error');
    }
  } catch (err) {
    bagToast('Network error. Please try again.', 'error');
  }
}

async function removeFromBag(cartItemId) {
  const form = new FormData();
  form.append('cart_item_id', cartItemId);

  try {
    const res = await fetch('process/removeFromCart.php', { method: 'POST', body: form });
    const response = (await res.text()).trim();

    if (response === 'success') {
      bagItems = bagItems.filter(item => item.id !== cartItemId);
      renderBag();
    } else {
      bagToast('Could not remove item. Please try again.', 'error');
    }
  } catch (err) {
    bagToast('Network error. Please try again.', 'error');
  }
}

/* ---------- INIT ---------- */
document.addEventListener('DOMContentLoaded', () => {
  fetchCart();

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