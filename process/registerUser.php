<?php
include "../includes/connection.php";

function esc($value) {
    Database::setUpConnection();
    return Database::$connection->real_escape_string($value);
}

$fname = trim($_POST['fn'] ?? '');
$lname = trim($_POST['ln'] ?? '');
$email = trim($_POST['em'] ?? '');
$pw    = $_POST['pw'] ?? '';

// ---------- server-side validation (never trust the client) ----------
if ($fname === '' || $lname === '') {
    echo "error: First and last name are required.";
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "error: Please enter a valid email address.";
    exit;
}
if (strlen($pw) < 8) {
    echo "error: Password must be at least 8 characters.";
    exit;
}

// ---------- check for duplicate email ----------
$emailEsc = esc($email);
$check = Database::search("SELECT `user_id` FROM `users` WHERE `email` = '".$emailEsc."' LIMIT 1");
if ($check->num_rows > 0) {
    echo "error: An account with this email already exists.";
    exit;
}

// ---------- hash password, then insert ----------
$passwordHash = password_hash($pw, PASSWORD_DEFAULT);

Database::iud("INSERT INTO `users` (`first_name`,`last_name`,`email`,`password_hash`)
                VALUES ('".esc($fname)."','".esc($lname)."','".$emailEsc."','".esc($passwordHash)."')");



$user_id = Database::$connection->insert_id;

echo "success:" . $user_id;
?>