<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../includes/connection.php";

if (!isset($_SESSION['user_id'])) {
    echo("not_logged_in");
    exit;
}

$user_id      = (int) $_SESSION['user_id'];
$cart_item_id = (int) ($_POST['cart_item_id'] ?? 0);

if ($cart_item_id <= 0) {
    echo("error: Invalid item.");
    exit;
}

Database::iud("DELETE FROM `cart_items` WHERE `cart_item_id`='" . $cart_item_id . "' AND `user_id`='" . $user_id . "' ");

$check_rs = Database::search("SELECT `cart_item_id` FROM `cart_items` WHERE `cart_item_id`='" . $cart_item_id . "' AND `user_id`='" . $user_id . "' LIMIT 1");

if ($check_rs && $check_rs->num_rows === 0) {
    echo("success");
} else {
    echo("error: Failed to remove item.");
}