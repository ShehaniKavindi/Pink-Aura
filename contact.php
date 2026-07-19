<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact us — PiNK AURA</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/contact.css">

  <link rel="icon" href="assets/images/site-images/logo.png" />
</head>

<body>


  <?php include "header.php" ?>

  <!-- HERO -->
  <section class="contact-hero">
    <div class="wrap">
      <div class="contact-badge">&#128172; We're here to help</div>
      <h1>Reach out to our <em>care team</em> anytime</h1>
      <p>Have a question about an order, a product, or anything else? Fill out the form below and we'll get back to
        you shortly.</p>

      <div class="contact-quick-pills" id="quickPills">
        <button class="pill" type="button" data-reason="order">&#128230; Order issue</button>
        <button class="pill" type="button" data-reason="product">&#10024; Product question</button>
        <button class="pill" type="button" data-reason="shipping">&#128666; Shipping &amp; delivery</button>
        <button class="pill" type="button" data-reason="other">&#128172; General feedback</button>
      </div>
    </div>
  </section>

  <!-- CONTACT CARD -->
  <section>
    <div class="wrap">
      <div class="contact-card">

        <!-- LEFT INFO PANEL -->
        <div class="contact-info">
          <p class="eyebrow">Customer support</p>
          <h2>Got a question or concern? Let us know.</h2>
          <p>Send a message directly to our support team and we'll get back to you as soon as possible.</p>

          <div class="contact-info-list">
            <div class="contact-info-item"><span class="icon">&#9200;</span> Usually responds within 1&ndash;2
              business days</div>
            <div class="contact-info-item"><span class="icon">&#128274;</span> Your message is private and secure
            </div>
            <div class="contact-info-item"><span class="icon">&#128100;</span> Sent under your account email</div>
          </div>
        </div>

        <!-- RIGHT FORM PANEL -->
        <div class="contact-form-panel">
          <form id="contactForm">

            <div class="contact-field">
              <label for="contactName">Your name <span class="required">*</span></label>
              <input type="text" id="contactName" name="name" placeholder="Jane Doe" required>
            </div>

            <div class="contact-field">
              <label for="contactEmail">Your email <span class="required">*</span></label>
              <input type="email" id="contactEmail" name="email" placeholder="you@example.com" required>
            </div>

            <div class="contact-field">
              <label for="contactReason">Reason <span class="required">*</span></label>
              <select id="contactReason" name="reason" required>
                <option value="" disabled selected>Select a reason</option>
                <option value="order">Order issue</option>
                <option value="product">Product question</option>
                <option value="shipping">Shipping &amp; delivery</option>
                <option value="returns">Returns &amp; refunds</option>
                <option value="wholesale">Wholesale / collaboration</option>
                <option value="other">General feedback</option>
              </select>
            </div>

            <div class="contact-field">
              <label for="contactMessage">Message <span class="required">*</span></label>
              <textarea id="contactMessage" name="message" maxlength="1000"
                placeholder="Describe your question or issue in detail..." required></textarea>
              <div class="contact-field-foot">
                <span>Be as specific as you can</span>
                <span id="messageCount">0 / 1000</span>
              </div>
            </div>

            <div class="contact-form-actions">
              <button type="button" class="btn outline" id="clearBtn">Clear</button>
              <button type="submit" class="btn">&#10148; Send message</button>
            </div>

            <div class="contact-success" id="contactSuccess">
              &#10003; Thanks! Your message has been sent — we'll get back to you soon.
            </div>
          </form>
        </div>

      </div>
    </div>
  </section>

  <!-- CONTACT DETAILS -->
  <section class="contact-details">
    <div class="wrap">
      <h2 class="section-title">Other ways to reach us</h2>
      <div class="contact-details-grid">

        <div class="contact-detail-card">
          <div class="contact-detail-icon">&#128205;</div>
          <p class="contact-detail-label">Visit us</p>
          <p class="contact-detail-value">14 Rosewater Lane<br>Maharagama, Sri Lanka</p>
        </div>

        <div class="contact-detail-card">
          <div class="contact-detail-icon">&#128222;</div>
          <p class="contact-detail-label">Call us</p>
          <p class="contact-detail-value"><a href="tel:+94112345678">+94 11 234 5678</a><br><a
              href="tel:+94712345678">+94 71 234 5678</a></p>
        </div>

        <div class="contact-detail-card">
          <div class="contact-detail-icon">&#9993;</div>
          <p class="contact-detail-label">Email us</p>
          <p class="contact-detail-value"><a href="mailto:hello@pinkaura.lk">hello@pinkaura.lk</a><br><a
              href="mailto:support@pinkaura.lk">support@pinkaura.lk</a></p>
        </div>

        <div class="contact-detail-card">
          <div class="contact-detail-icon">&#128337;</div>
          <p class="contact-detail-label">Business hours</p>
          <p class="contact-detail-value">Mon&ndash;Fri, 9am&ndash;6pm<br>Sat, 10am&ndash;3pm</p>
        </div>

      </div>
    </div>
  </section>

  <!-- toast -->
  <div class="toast-msg" id="toast-msg">
    <i id="toast-icon" class="fa-solid fa-circle-xmark"></i>
    <span id="toast-text" class="toast-text"></span>
  </div>


  <?php include "footer.php" ?>


  <script src="assets/js/wishlist.js"></script>
  <script src="assets/js/bag.js"></script>
  <script src="assets/js/main.js"></script>
  <script>
    function showToast(message, type = 'error') {
      const toast = document.getElementById('toast-msg');
      const icon = document.getElementById('toast-icon');
      const text = document.getElementById('toast-text');
      if (!toast) return;

      text.textContent = message;
      toast.classList.remove('success', 'error');
      toast.classList.add(type);
      icon.className = type === 'success' ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-xmark';

      toast.classList.add('show');
      clearTimeout(showToast._timer);
      showToast._timer = setTimeout(() => toast.classList.remove('show'), 3500);
    }

    const reasonSelect = document.getElementById('contactReason');
    const nameField = document.getElementById('contactName');
    const emailField = document.getElementById('contactEmail');
    const messageField = document.getElementById('contactMessage');
    const messageCount = document.getElementById('messageCount');
    const contactForm = document.getElementById('contactForm');
    const contactSuccess = document.getElementById('contactSuccess');
    const clearBtn = document.getElementById('clearBtn');

    /* ── Quick pills prefill the reason dropdown ── */
    document.querySelectorAll('#quickPills .pill').forEach(pill => {
      pill.addEventListener('click', () => {
        document.querySelectorAll('#quickPills .pill').forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        reasonSelect.value = pill.dataset.reason;
      });
    });

    /* ── Character counter ── */
    messageField.addEventListener('input', () => {
      messageCount.textContent = messageField.value.length + ' / 1000';
    });

    /* ── Clear / discard ── */
    function resetContactForm() {
      contactForm.reset();
      messageCount.textContent = '0 / 1000';
      document.querySelectorAll('#quickPills .pill').forEach(p => p.classList.remove('active'));
    }
    clearBtn.addEventListener('click', () => {
      resetContactForm();
      contactSuccess.classList.remove('show');
    });

    /* ── Client-side validation ── */
    function validateContactForm() {
      const name = nameField.value.trim();
      const email = emailField.value.trim();
      const reason = reasonSelect.value;
      const message = messageField.value.trim();

      if (!name) {
        showToast('Please enter your name.');
        return false;
      }
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email)) {
        showToast('Please enter a valid email address.');
        return false;
      }
      if (!reason) {
        showToast('Please select a reason.');
        return false;
      }
      if (!message) {
        showToast('Please enter a message.');
        return false;
      }
      if (message.length > 1000) {
        showToast('Message must be 1000 characters or fewer.');
        return false;
      }
      return true;
    }

    /* ── Submit ── */
    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();
      if (!validateContactForm()) return;

      const form = new FormData();
      form.append('name', nameField.value.trim());
      form.append('email', emailField.value.trim());
      form.append('reason', reasonSelect.value);
      form.append('message', messageField.value.trim());

      const request = new XMLHttpRequest();
      request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
          const response = request.responseText.trim();
          if (response === 'success') {
            // showToast('Your message has been sent — we\'ll get back to you soon.', 'success');
            contactSuccess.classList.add('show');
            resetContactForm();
          } else {
            showToast(response.replace(/^error:\s*/, ''), 'error');
          }
        }
      };
      request.open('POST', 'process/contactMessage.php', true);
      request.send(form);
    });
  </script>

</body>

</html>