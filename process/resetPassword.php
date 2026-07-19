<?php
include "../includes/connection.php";

function esc($value) {
    Database::setUpConnection();
    return Database::$connection->real_escape_string($value);
}

$email = trim($_POST['em'] ?? '');
$pw    = $_POST['pw'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo("error: Please enter a valid email address.");
    exit;
}
if (strlen($pw) < 8) {
    echo("error: Password must be at least 8 characters.");
    exit;
}

$emailEsc = esc($email);
$passwordHash = password_hash($pw, PASSWORD_DEFAULT);

Database::iud("UPDATE `users` SET `password_hash`='" . esc($passwordHash) . "', `otp`=NULL WHERE `email`='" . $emailEsc . "' ");

$check = Database::search("SELECT `user_id` FROM `users` WHERE `email`='" . $emailEsc . "' AND `password_hash`='" . esc($passwordHash) . "' LIMIT 1");

if ($check && $check->num_rows === 1) {
    echo("success");
} else {
    echo("error: Failed to update password.");
}