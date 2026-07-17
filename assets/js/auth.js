/* ---------- SHARED TOAST (used by login, register, forgot password) ---------- */
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

/* ---------- SHOW / HIDE PASSWORD (shared toggle, safe if no .toggle-pass on the page) ---------- */
document.querySelectorAll('.toggle-pass').forEach(btn => {
    btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.target);
        if (!input) return;
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.innerHTML = isHidden ? '<i class="fa-solid fa-eye"></i>' : '<i class="fa-solid fa-eye-slash"></i>';
        btn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
    });
});

/* ---------- REGISTER ---------- */
function validateRegisterForm() {
    const fname = document.getElementById('firstName').value.trim();
    const lname = document.getElementById('lastName').value.trim();
    const email = document.getElementById('email').value.trim();
    const pw = document.getElementById('password').value;
    const confirmPw = document.getElementById('confirmPassword').value;
    const terms = document.getElementById('terms').checked;

    if (!fname || !lname) {
        showToast('Please enter your first and last name.');
        return false;
    }
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        showToast('Please enter a valid email address.');
        return false;
    }
    if (pw.length < 8) {
        showToast('Password must be at least 8 characters.');
        return false;
    }
    if (pw !== confirmPw) {
        showToast('Passwords do not match.');
        return false;
    }
    if (!terms) {
        showToast('Please agree to the Terms of Service and Privacy Policy.');
        return false;
    }
    return true;
}

function register() {
    if (!validateRegisterForm()) return;

    let fname = document.getElementById('firstName');
    let lname = document.getElementById('lastName');
    let email = document.getElementById('email');
    let password = document.getElementById('password'); // the REAL password field, not confirmPassword

    let form = new FormData();
    form.append("fn", fname.value.trim());
    form.append("ln", lname.value.trim());
    form.append("em", email.value.trim());
    form.append("pw", password.value);

    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            let response = request.responseText;
            if (response.startsWith('success:')) {
                showToast('Account created! Redirecting to sign in...', 'success');
                setTimeout(() => { window.location.href = 'login.php'; }, 1500);
            } else {
                showToast(response.replace(/^error:\s*/, ''), 'error');
            }
        }
    }
    request.open("POST", "process/registerUser.php", true);
    request.send(form);
}

/* ---------- Wire the register form up, only if it's present on this page ---------- */
const registerForm = document.getElementById('registerForm');
if (registerForm) {
    registerForm.addEventListener('submit', function (e) {
        e.preventDefault();
        register();
    });
}

/* ---------- LOGIN ---------- */
function validateLoginForm() {
    const email = document.getElementById('email').value.trim();
    const pw = document.getElementById('password').value;

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        showToast('Please enter a valid email address.');
        return false;
    }
    if (!pw) {
        showToast('Please enter your password.');
        return false;
    }
    return true;
}

function login() {
    if (!validateLoginForm()) return;

    let email = document.getElementById('email');
    let password = document.getElementById('password');
    let remember = document.querySelector('input[name="remember"]');

    let form = new FormData();
    form.append("em", email.value.trim());
    form.append("pw", password.value);
    form.append("remember", remember && remember.checked ? "1" : "0");

    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 && request.readyState == 4) {
            let response = request.responseText;
            if (response.startsWith('success:')) {
                showToast('Signed in! Redirecting...', 'success');
                setTimeout(() => { window.location.href = 'index.php'; }, 1200);
            } else {
                showToast(response.replace(/^error:\s*/, ''), 'error');
            }
        }
    }
    request.open("POST", "process/loginUser.php", true);
    request.send(form);
}

/* ---------- Wire the login form up, only if it's present on this page ---------- */
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();
        login();
    });
}


// ============= forgot password steps =================

// function startResendTimer(seconds) {
//     const el = document.getElementById('resendTimer');
//     let t = seconds;
//     el.textContent = '(' + t + 's)';
//     resendCountdown = setInterval(() => {
//         t--;
//         el.textContent = t > 0 ? '(' + t + 's)' : '';
//         if (t <= 0) {
//             clearInterval(resendCountdown);
//             resendCountdown = null;
//         }
//     }, 1000);
// }

function sendOtp() {   /* ── STEP 1 — send OTP ── */
    var email = document.getElementById('emailInput').value.trim();

    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showToast('Please enter a valid email address.');
        return;
    }

    userEmail = email;
    document.getElementById('emailDisplay').textContent = email;

    var form = new FormData();
    form.append('em', email);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            const response = request.responseText.trim();
            if (response === 'sent') {
                showToast('Code sent! Check your inbox.', 'success');
                goToStep(2);
                startResendTimer(60);
            } else if (response === 'not_found') {
                showToast('No account found with that email.');
            } else {
                showToast('Something went wrong. Try again.', 'warning');
            }
        }
    };
    request.open('POST', 'process/sendResetOtp.php', true);
    request.send(form);
}


function verifyOtp() {  /* ── STEP 2 — verify OTP ── */
    var inputs = document.querySelectorAll('.otp-input');
    var otp = [...inputs].map(i => i.value).join('');
    if (otp.length < 6) {
        showToast('Please enter the full 6-digit code.', 'warning');
        return;
    }

    var form = new FormData();
    form.append('em', userEmail);
    form.append('otp', otp);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();
            if (response === 'valid') {
                goToStep(3);
            } else {
                showToast('Incorrect code. Please try again.');
            }
        }
    };
    request.open('POST', 'process/verifyResetOtp.php', true);
    request.send(form);
}


function resetPassword() {    /* ── STEP 3 — reset password ── */
    var password = document.getElementById('newPassword').value;
    var confirmPw = document.getElementById('confirmPassword').value;
    var hint = document.getElementById('pwMatchHint');

    if (password.length < 8 || !/[A-Z]/.test(password) || !/[0-9]/.test(password) || !/[^A-Za-z0-9]/.test(password)) {
        showToast('Password must be at least 8 chars with uppercase, number & symbol.', 'warning');
        return;
    }
    if (password !== confirmPw) {
        hint.textContent = 'Passwords do not match.';
        hint.style.color = '#DC2626';
        return;
    }

    var form = new FormData();
    form.append('em', userEmail);
    form.append('pw', password);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();
            if (response === 'success') {
                goToStep(4);
            } else {
                showToast('Failed to update password. Try again.');
            }
        }
    };
    request.open('POST', 'process/resetPassword.php', true);
    request.send(form);
}

function resendOtp() {
    if (resendCountdown) return;
    sendOtp();
    startResendTimer(60);
}   