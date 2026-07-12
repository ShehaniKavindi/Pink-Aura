/* ==========================================================================
   PiNK AURA — admin.js
   All behavior for admin.html: dashboard stats/lists/pie chart, manage
   products table, add-stock stub, categories table, and the Add Product
   form (including variant type: none / size / shade / color).
   ========================================================================== */

/* ---------- DATA ---------- */
const productsData = [
  { name:'Vitamin C Serum', category:'Skincare', price:899, stock:3, sales:128 },
  { name:'Hydrating Moisturizer', category:'Skincare', price:699, stock:12, sales:96 },
  { name:'Glow Sunscreen SPF 50', category:'Skincare', price:599, stock:2, sales:74 },
  { name:'Rose Clay Mask', category:'Skincare', price:499, stock:4, sales:64 },
  { name:'Soft-Focus Blur Foundation', category:'Makeup', price:1290, stock:15, sales:210 },
  { name:'Velvet Kohl Eyeliner', category:'Makeup', price:450, stock:20, sales:58 },
  { name:'Glass Tint Lip Oil', category:'Makeup', price:620, stock:8, sales:142 },
  { name:'Silk Rice Shampoo', category:'Hair care', price:780, stock:18, sales:39 },
  { name:'Shine Drop Hair Elixir', category:'Hair care', price:990, stock:9, sales:47 },
  { name:'Jelly Coat Nail Lacquer', category:'Nail care', price:320, stock:25, sales:22 },
  { name:'Aura Bloom Eau de Parfum', category:'Fragrance', price:2450, stock:6, sales:88 },
  { name:'Whipped Cloud Body Wash', category:'Bath & body', price:650, stock:14, sales:31 }
];

/* ---------- SIDEBAR NAV SWITCHING ---------- */
const navLinks = document.querySelectorAll('.admin-nav-link');
const sections = document.querySelectorAll('.content-section');

navLinks.forEach(link => {
  link.addEventListener('click', () => {
    navLinks.forEach(l => l.classList.remove('active'));
    link.classList.add('active');
    const target = link.dataset.section;
    sections.forEach(sec => {
      sec.classList.toggle('active', sec.id === `section-${target}`);
    });
  });
});

/* ---------- LIVE DATE / TIME ---------- */
function updateClock(){
  const now = new Date();
  document.getElementById('adminDate').textContent = now.toLocaleDateString(undefined, { weekday:'short', day:'2-digit', month:'short', year:'numeric' });
  document.getElementById('adminTime').textContent = now.toLocaleTimeString(undefined, { hour:'2-digit', minute:'2-digit' });
}
updateClock();
setInterval(updateClock, 1000);

/* ---------- STAT CARDS ---------- */
document.getElementById('statProductCount').textContent = productsData.length;
document.getElementById('statLowStockCount').textContent = productsData.filter(p => p.stock <= 5).length;

/* ---------- LOW STOCK LIST ---------- */
const lowStockList = document.getElementById('lowStockList');
const lowStock = productsData.filter(p => p.stock <= 5).sort((a,b) => a.stock - b.stock);
lowStockList.innerHTML = lowStock.map(p => `
  <li>
    <span class="mini-list-name">${p.name}</span>
    <span class="mini-list-meta">${p.category}</span>
    <span class="admin-badge admin-badge-returned">${p.stock} left</span>
  </li>
`).join('') || '<li class="mini-list-empty">Nothing low on stock right now.</li>';

/* ---------- BEST SELLERS LIST ---------- */
const bestSellerList = document.getElementById('bestSellerList');
const bestSellers = [...productsData].sort((a,b) => b.sales - a.sales).slice(0, 4);
bestSellerList.innerHTML = bestSellers.map(p => `
  <li>
    <span class="mini-list-name">${p.name}</span>
    <span class="mini-list-meta">${p.sales} sold</span>
    <span class="mini-list-price">Rs ${p.price.toLocaleString()}</span>
  </li>
`).join('');

/* ---------- PIE CHART (products by category, plain CSS conic-gradient) ---------- */
const paletteHex = ['#F4B9CE', '#E58EAD', '#4A1E30', '#F3D6E2', '#8C7580', '#FBE7EE'];
const counts = {};
productsData.forEach(p => { counts[p.category] = (counts[p.category] || 0) + 1; });

let cumulative = 0;
const stops = [];
const legendItems = [];
Object.entries(counts).forEach(([cat, count], i) => {
  const total = productsData.length;
  const pct = (count / total) * 100;
  const color = paletteHex[i % paletteHex.length];
  stops.push(`${color} ${cumulative}% ${cumulative + pct}%`);
  legendItems.push(`
    <div class="pie-legend-item">
      <span class="pie-dot" style="background:${color}"></span>
      <span class="pie-legend-label">${cat}</span>
      <span class="pie-legend-value">${count} &middot; ${Math.round(pct)}%</span>
    </div>
  `);
  cumulative += pct;
});

document.getElementById('pieChart').style.background = `conic-gradient(${stops.join(', ')})`;
document.getElementById('pieLegend').innerHTML = legendItems.join('');

/* ---------- MANAGE PRODUCTS TABLE ---------- */
document.getElementById('manageProductsBody').innerHTML = productsData.map(p => `
  <tr>
    <td>${p.name}</td>
    <td>${p.category}</td>
    <td>Rs ${p.price.toLocaleString()}</td>
    <td>${p.stock <= 5 ? `<span class="admin-badge admin-badge-returned">${p.stock}</span>` : p.stock}</td>
    <td>
      <button class="btn outline small" onclick="alert('Edit form not wired yet — UI stub.')">Edit</button>
      <button class="btn outline small" onclick="alert('Delete not wired yet — UI stub.')">Delete</button>
    </td>
  </tr>
`).join('');

/* ---------- STOCK DROPDOWN ---------- */
document.getElementById('stockProduct').innerHTML = productsData.map(p => `<option>${p.name}</option>`).join('');

/* ---------- CATEGORIES TABLE ---------- */
document.getElementById('categoriesBody').innerHTML = Object.entries(counts).map(([cat, count]) => `
  <tr>
    <td>${cat}</td>
    <td>${count}</td>
    <td>
      <button class="btn outline small" onclick="alert('Edit category not wired yet — UI stub.')">Edit</button>
    </td>
  </tr>
`).join('');

/* ---------- ADD NEW PRODUCT: category taxonomy + sub-category population ---------- */
const categoryTaxonomy = {
  'Makeup': ['Face', 'Eyes', 'Lips'],
  'Skincare': ['Cleansers', 'Serums', 'Moisturizers'],
  'Hair care': ['Shampoo', 'Hair oil', 'Styling'],
  'Nail care': ['Polish', 'Cuticle care', 'Press-ons'],
  'Fragrance': ['Eau de parfum', 'Body mist', 'Rollerball'],
  'Bath & body': ['Body wash', 'Body butter', 'Body scrub'],
  'Tools & accessories': ['General'],
  'Sets & gifts': ['General']
};

const pMainCategory = document.getElementById('pMainCategory');
const pSubCategory = document.getElementById('pSubCategory');

pMainCategory.innerHTML = Object.keys(categoryTaxonomy).map(cat => `<option>${cat}</option>`).join('');

function populateSubCategories() {
  const subs = categoryTaxonomy[pMainCategory.value] || [];
  pSubCategory.innerHTML = subs.map(s => `<option>${s}</option>`).join('');
}
populateSubCategories();
pMainCategory.addEventListener('change', () => {
  populateSubCategories();
  updateLivePreview();
});

/* ---------- ADD NEW PRODUCT: variant type (none / size / shade / color) ---------- */
const pVariantType = document.getElementById('pVariantType');
const singlePriceStockRow = document.getElementById('singlePriceStockRow');
const variantSection = document.getElementById('variantSection');
const variantSectionLabel = document.getElementById('variantSectionLabel');
const variantRowsEl = document.getElementById('variantRows');
const addVariantBtn = document.getElementById('addVariantBtn');

// in-memory state for the rows currently being edited: { label, hex, price, stock }[]
let variantRows = [];

const variantCopy = {
  size:  { sectionLabel: 'Sizes',  labelPlaceholder: 'e.g. 30ml',              hasSwatch: false, addBtnText: '+ Add another size' },
  shade: { sectionLabel: 'Shades', labelPlaceholder: 'e.g. 220 - Natural Beige', hasSwatch: true,  addBtnText: '+ Add another shade' },
  color: { sectionLabel: 'Colors', labelPlaceholder: 'e.g. Ruby Red',          hasSwatch: true,  addBtnText: '+ Add another color' }
};

function blankVariantRow() {
  return { label: '', hex: '#F4B9CE', price: '', stock: '' };
}

function renderVariantRows() {
  const type = pVariantType.value;
  const copy = variantCopy[type];

  variantRowsEl.innerHTML = variantRows.map((row, i) => `
    <div class="variant-row" data-index="${i}">
      ${copy.hasSwatch ? `<input type="color" class="variant-swatch" data-field="hex" value="${row.hex}" aria-label="Swatch color">` : ''}
      <input type="text" class="variant-label-input" data-field="label" placeholder="${copy.labelPlaceholder}" value="${row.label}">
      <input type="text" class="variant-price-input" data-field="price" placeholder="Price" value="${row.price}">
      <input type="text" class="variant-stock-input" data-field="stock" placeholder="Stock" value="${row.stock}">
      <button type="button" class="variant-remove-btn" data-index="${i}" aria-label="Remove variant">&#10005;</button>
    </div>
  `).join('');

  addVariantBtn.textContent = copy.addBtnText;
}

function switchVariantType() {
  const type = pVariantType.value;

  if (type === 'none') {
    singlePriceStockRow.hidden = false;
    variantSection.hidden = true;
  } else {
    singlePriceStockRow.hidden = true;
    variantSection.hidden = false;
    variantSectionLabel.textContent = variantCopy[type].sectionLabel;

    // seed with two starter rows the first time a variant type is picked
    if (variantRows.length === 0) {
      variantRows.push(blankVariantRow(), blankVariantRow());
    }
    renderVariantRows();
  }

  updateLivePreview();
}

pVariantType.addEventListener('change', switchVariantType);

addVariantBtn.addEventListener('click', () => {
  variantRows.push(blankVariantRow());
  renderVariantRows();
});

// event delegation: handles typing in any row's inputs + remove buttons
variantRowsEl.addEventListener('input', (e) => {
  const row = e.target.closest('.variant-row');
  if (!row) return;
  const index = Number(row.dataset.index);
  const field = e.target.dataset.field;
  variantRows[index][field] = e.target.value;
  updateLivePreview();
});

variantRowsEl.addEventListener('click', (e) => {
  if (e.target.classList.contains('variant-remove-btn')) {
    const index = Number(e.target.dataset.index);
    variantRows.splice(index, 1);
    renderVariantRows();
    updateLivePreview();
  }
});

/* ---------- ADD NEW PRODUCT: live preview ---------- */
const previewImg = document.getElementById('previewImg');
const previewCat = document.getElementById('previewCat');
const previewName = document.getElementById('previewName');
const previewPrice = document.getElementById('previewPrice');
const previewVariants = document.getElementById('previewVariants');

function updateLivePreview() {
  const title = document.getElementById('pTitle').value.trim();
  const mainCat = pMainCategory.value;
  const subCat = pSubCategory.value;
  const type = pVariantType.value;

  previewName.textContent = title || 'Product title';
  previewCat.textContent = `${mainCat || 'Main category'} \u00b7 ${subCat || 'Sub category'}`;
  previewImg.src = uploadedImages[0]
    ? uploadedImages[0].url
    : 'https://placehold.co/320x300/F3D6E2/4A1E30?text=Product+image';

  if (type === 'none') {
    const price = document.getElementById('pPrice').value.trim();
    previewPrice.textContent = price ? `Rs ${Number(price).toLocaleString()}` : 'Rs 0';
    previewVariants.hidden = true;
    previewVariants.innerHTML = '';
    return;
  }

  // variant mode: price shows the lowest entered variant price ("From Rs X")
  const validPrices = variantRows
    .map(r => Number(r.price))
    .filter(n => !isNaN(n) && n > 0);
  previewPrice.textContent = validPrices.length
    ? `From Rs ${Math.min(...validPrices).toLocaleString()}`
    : 'Rs 0';

  if (type === 'size') {
    previewVariants.hidden = variantRows.every(r => !r.label.trim());
    previewVariants.innerHTML = variantRows
      .filter(r => r.label.trim())
      .map(r => `<span class="preview-size-pill">${r.label}</span>`)
      .join('');
  } else {
    // shade / color: small circular swatches
    previewVariants.hidden = variantRows.every(r => !r.label.trim());
    previewVariants.innerHTML = variantRows
      .filter(r => r.label.trim())
      .map(r => `<span class="preview-swatch" style="background:${r.hex}" title="${r.label}"></span>`)
      .join('');
  }
}

['pTitle', 'pPrice'].forEach(id => {
  document.getElementById(id).addEventListener('input', updateLivePreview);
});
pSubCategory.addEventListener('change', updateLivePreview);

/* ---------- ADD NEW PRODUCT: image upload (max 4, thumbnails, remove, add) ---------- */
const MAX_IMAGES = 4;
let uploadedImages = []; // { file, url }

const imageUploadGrid = document.getElementById('imageUploadGrid');
const imageFileInput = document.getElementById('imageFileInput');

function renderImageUploadGrid() {
  const thumbsHtml = uploadedImages.map((img, i) => `
    <div class="image-thumb">
      <img src="${img.url}" alt="Product image ${i + 1}">
      <button type="button" class="image-remove-btn" data-index="${i}" aria-label="Remove image">&#10005;</button>
    </div>
  `).join('');

  const addBtnHtml = uploadedImages.length < MAX_IMAGES
    ? `<button type="button" class="image-add-btn" id="imageAddBtn">+</button>`
    : '';

  imageUploadGrid.innerHTML = thumbsHtml + addBtnHtml;
  updateLivePreview();
}

// Event delegation: handles both the (re-rendered) add button and remove buttons
imageUploadGrid.addEventListener('click', (e) => {
  if (e.target.id === 'imageAddBtn') {
    imageFileInput.click();
  }
  if (e.target.classList.contains('image-remove-btn')) {
    const index = Number(e.target.dataset.index);
    URL.revokeObjectURL(uploadedImages[index].url);
    uploadedImages.splice(index, 1);
    renderImageUploadGrid();
  }
});

imageFileInput.addEventListener('change', (e) => {
  const remainingSlots = MAX_IMAGES - uploadedImages.length;
  const filesToAdd = Array.from(e.target.files).slice(0, remainingSlots);

  filesToAdd.forEach(file => {
    uploadedImages.push({ file, url: URL.createObjectURL(file) });
  });

  renderImageUploadGrid();
  imageFileInput.value = ''; // allow re-selecting the same file later
});

renderImageUploadGrid();

/* ---------- ADD NEW PRODUCT: submit (still a UI stub — logs the payload
   shaped to match the products / product_variants schema) ---------- */
document.getElementById('productForm').addEventListener('submit', (e) => {
  e.preventDefault();

  const type = pVariantType.value;

  // TODO: POST to process/addProduct.php. Backend should always insert at
  // least one row into product_variants — for variant_type = 'none', that
  // means a single row labeled "Standard" using pPrice/pStock below.
  const payload = {
    main_category: pMainCategory.value,
    sub_category: pSubCategory.value,
    title: document.getElementById('pTitle').value.trim(),
    description: document.getElementById('pDesc').value.trim(),
    key_ingredients: document.getElementById('pIngredients').value.trim(),
    how_to_use: document.getElementById('pHowToUse').value.trim(),
    variant_type: type,
    variants: type === 'none'
      ? [{ label: 'Standard', price: document.getElementById('pPrice').value.trim(), stock: document.getElementById('pStock').value.trim() }]
      : variantRows.map(r => ({
          label: r.label.trim(),
          swatch_hex: (type === 'shade' || type === 'color') ? r.hex : null,
          price: r.price,
          stock: r.stock
        })),
    image_count: uploadedImages.length
  };

  console.log('Product form submitted:', payload);
});

updateLivePreview();