<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign in — PiNK AURA</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/auth.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <link rel="icon" href="assets/images/site-images/logo.png" />
</head>

<body>

  <div class="login-page">
    <img class="login-bg" src="assets/images/site-images/login-bg.jpg" alt="">
    <div class="login-bg-overlay"></div>

    <a class="login-logo" href="index.php">PiNK <span>AURA</span></a>

    <div class="login-card">
      <p class="eyebrow">Welcome back</p>
      <h1>Sign in to your account</h1>
      <p class="login-sub">Glow starts here — access your orders, wishlist, and saved details.</p>

      <form class="login-form" id="loginForm">

        <div class="field">
          <label for="email">Email address</label>
          <div class="input-wrap">
            <i class="fa-solid fa-envelope icon-left"></i>
            <input type="email" id="email" name="email" placeholder="you@example.com" required>
          </div>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <div class="input-wrap">
            <i class="fa-solid fa-lock icon-left"></i>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
            <button type="button" class="toggle-pass" data-target="password" aria-label="Show password">
              <i class="fa-solid fa-eye-slash"></i>
            </button>
          </div>
        </div>

        <div class="login-row">
          <label class="checkbox">
            <input type="checkbox" name="remember">
            Remember me
          </label>
          <a href="forgot-passwowrd.php" class="link">Forgot password?</a>
        </div>

        <button type="submit" class="btn login-submit">Sign in &rarr;</button>
      </form>

      <div class="login-divider"><span>or</span></div>

      <button type="button" class="btn login-alt">
        <span class="g-icon">G</span> Continue with Google
      </button>

      <p class="login-footer-text">New to PiNK AURA? <a href="register.php">Create an account</a></p>
    </div>
  </div>

  <!-- toast -->
  <div class="toast-msg" id="toast-msg">
    <i id="toast-icon" class="fa-solid fa-circle-xmark"></i>
    <span id="toast-text" class="toast-text"></span>
  </div>

  <!-- shared toast + login()/register() logic -->
  <script src="assets/js/auth.js"></script>

</body>

</html>