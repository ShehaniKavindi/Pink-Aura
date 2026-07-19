<?php
include "../includes/connection.php";

function esc($value) {
    Database::setUpConnection();
    return Database::$connection->real_escape_string($value);
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$reason  = trim($_POST['reason'] ?? '');
$message = trim($_POST['message'] ?? '');

$validReasons = ['order', 'product', 'shipping', 'returns', 'wholesale', 'other'];

if ($name === '') {
    echo("error: Please enter your name.");
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo("error: Please enter a valid email address.");
    exit;
}
if ($reason === '' || !in_array($reason, $validReasons, true)) {
    echo("error: Please select a reason.");
    exit;
}
if ($message === '') {
    echo("error: Please enter a message.");
    exit;
}
if (mb_strlen($message) > 1000) {
    echo("error: Message must be 1000 characters or fewer.");
    exit;
}

Database::iud("INSERT INTO `contact_messages` (`name`,`email`,`reason`,`message`)
                VALUES ('" . esc($name) . "','" . esc($email) . "','" . esc($reason) . "','" . esc($message) . "')");

$check_rs = Database::search("SELECT `message_id` FROM `contact_messages`
                               WHERE `email`='" . esc($email) . "' AND `message`='" . esc($message) . "'
                               ORDER BY `message_id` DESC LIMIT 1");

if ($check_rs && $check_rs->num_rows === 1) {
    echo("success");
} else {
    echo("error: Failed to send your message. Please try again.");
}