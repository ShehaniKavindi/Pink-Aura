<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PiNK AURA — Shop by category</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;1,400&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/category.css">

  <link rel="icon" href="assets/images/site-images/logo.png" />
</head>
<body>

  <!-- <nav class="top">
    <div class="logo">PiNK <span>AURA</span></div>
    <div class="nav-links">
      <a href="index.html">Home</a>
      <a href="search.html">Shop</a>
      <a href="category.html" class="active">Categories</a>
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

<div class="hero">
  <p class="eyebrow">Shop by category</p>
  <h1 class="hero-title">Find your <em>glow</em>, aisle by aisle</h1>
  <p class="hero-sub">Eight categories, everything you need. Tap one to see what's inside.</p>
</div>

<div class="wrap">
  <div class="grid" id="grid"></div>

  <div class="panel-wrap">
    <div class="panel" id="panel"></div>
  </div>
</div>

<?php include "footer.php" ?>

<script>
const categories = [
  { key:'makeup', name:'Makeup', size:'large', count:'3 subcategories · 42 products',
    subs:[
      {label:'Face', product:'Soft-Focus Blur Foundation'},
      {label:'Eyes', product:'Velvet Kohl Eyeliner'},
      {label:'Lips', product:'Glass Tint Lip Oil'}
    ]},
  { key:'skincare', name:'Skincare', size:'', count:'3 subcategories · 28 products',
    subs:[
      {label:'Cleansers', product:'Milk Cloud Cleanser'},
      {label:'Serums', product:'Peptide Glow Serum'},
      {label:'Moisturizers', product:'Barrier Butter Cream'}
    ]},
  { key:'hair', name:'Hair care', size:'', count:'3 subcategories · 19 products',
    subs:[
      {label:'Shampoo', product:'Silk Rice Shampoo'},
      {label:'Hair oil', product:'Shine Drop Elixir'},
      {label:'Styling', product:'Curl Whip Cream'}
    ]},
  { key:'nail', name:'Nail care', size:'', count:'3 subcategories · 15 products',
    subs:[
      {label:'Polish', product:'Jelly Coat Lacquer'},
      {label:'Cuticle care', product:'Rose Cuticle Oil'},
      {label:'Press-ons', product:'Glass Nail Set'}
    ]},
  { key:'fragrance', name:'Fragrance', size:'', count:'3 subcategories · 11 products',
    subs:[
      {label:'Eau de parfum', product:'Aura Bloom EDP'},
      {label:'Body mist', product:'Sugar Halo Mist'},
      {label:'Rollerball', product:'Petal Pocket Rollerball'}
    ]},
  { key:'bath', name:'Bath & body', size:'', count:'3 subcategories · 17 products',
    subs:[
      {label:'Body wash', product:'Whipped Cloud Wash'},
      {label:'Body butter', product:'Velvet Skin Butter'},
      {label:'Body scrub', product:'Sugar Glow Scrub'}
    ]},
  { key:'tools', name:'Tools & accessories', size:'wide', count:'12 products',
    subs:[
      {label:'Brushes', product:'Blur Buff Brush'},
      {label:'Sponges', product:'Cloud Bounce Sponge'},
      {label:'Skin tools', product:'Rose Quartz Sculptor'}
    ]},
  { key:'sets', name:'Sets & gifts', size:'wide', count:'9 products',
    subs:[
      {label:'Gift sets', product:'Glow Starter Kit'},
      {label:'Minis', product:'Best-of-Aura Minis'},
      {label:'Limited edition', product:'Solstice Glow Box'}
    ]}
];

const grid = document.getElementById('grid');
const panel = document.getElementById('panel');
let active = 'makeup';

function renderGrid(){
  grid.innerHTML = categories.map((c, i) => `
    <div class="tile ${c.size} ${active===c.key?'active':''}" data-key="${c.key}">
      <div class="tile-index">${String(i+1).padStart(2,'0')}</div>
      <div>
        <p class="tile-name">${c.name}</p>
        <p class="tile-count">${c.count}</p>
      </div>
      ${c.size==='wide' ? '<div class="tile-arrow">&rarr;</div>' : ''}
    </div>
  `).join('');

  grid.querySelectorAll('.tile').forEach(tile => {
    tile.addEventListener('click', () => {
      active = tile.dataset.key;
      renderGrid();
      renderPanel();
    });
  });
}

function renderPanel(){
  const cat = categories.find(c => c.key === active);
  panel.innerHTML = `
    <div class="panel-head">
      <h2>${cat.name}</h2>
      <span class="tag">${cat.subs.length} subcategories</span>
    </div>
    ${cat.subs.map(s => `
      <div class="sub-card">
        <p class="sub-name">${s.label}</p>
        <div class="sub-swatch"></div>
        <p class="prod-name">${s.product}</p>
        <p class="prod-example">Example product <b>from ${s.label}</b></p>
      </div>
    `).join('')}
  `;
}

renderGrid();
renderPanel();
</script>

</body>
</html>