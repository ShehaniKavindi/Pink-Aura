<?php
include "../includes/connection.php";

function esc($value) {
    Database::setUpConnection();
    return Database::$connection->real_escape_string($value);
}

$email = trim($_POST['em'] ?? '');
$otp   = trim($_POST['otp'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $otp === '') {
    echo("invalid");
    exit;
}

$emailEsc = esc($email);
$otpEsc   = esc($otp);

$otp_rs = Database::search("SELECT `user_id` FROM `users` WHERE `email`='" . $emailEsc . "' AND `otp`='" . $otpEsc . "' ");

if ($otp_rs && $otp_rs->num_rows == 1) {
    echo("valid");
} else {
    echo("invalid");
}