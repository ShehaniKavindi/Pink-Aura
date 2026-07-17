<?php
include "../includes/connection.php";

$email    = trim($_POST['em'] ?? '');
$pw       = $_POST['pw'] ?? '';
$remember = isset($_POST['remember']) && $_POST['remember'] === '1';

// ---------- server-side validation ----------
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "error: Please enter a valid email address.";
    exit;
}
if ($pw === '') {
    echo "error: Please enter your password.";
    exit;
}

// ---------- look up the user ----------
Database::setUpConnection();
$emailEsc = Database::$connection->real_escape_string($email);

$rs = Database::search("SELECT `user_id`,`first_name`,`last_name`,`email`,`password_hash`
                         FROM `users` WHERE `email` = '" . $emailEsc . "' LIMIT 1");

if ($rs->num_rows === 0) {
    echo "error: No account found with that email.";
    exit;
}

$user = $rs->fetch_assoc();

// ---------- verify password ----------
if (!password_verify($pw, $user['password_hash'])) {
    echo "error: Incorrect email or password.";
    exit;
}

// ---------- start session ----------
// "Remember me" extends the session cookie lifetime to 30 days instead of expiring on browser close
if ($remember) {
    session_set_cookie_params(60 * 60 * 24 * 30);
}
session_start();
session_regenerate_id(true);

$_SESSION['user_id']    = $user['user_id'];
$_SESSION['first_name'] = $user['first_name'];
$_SESSION['last_name']  = $user['last_name'];
$_SESSION['email']      = $user['email'];

echo "success:" . $user['user_id'];
?>