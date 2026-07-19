<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../includes/connection.php";

function esc($value) {
    Database::setUpConnection();
    return Database::$connection->real_escape_string($value);
}

if (!isset($_SESSION['user_id'])) {
    echo("not_logged_in");
    exit;
}

$user_id    = (int) $_SESSION['user_id'];
$variant_id = (int) ($_POST['variant_id'] ?? 0);
$qty        = (int) ($_POST['qty'] ?? 1);

if ($variant_id <= 0) {
    echo("error: Invalid product variant.");
    exit;
}
if ($qty <= 0) {
    $qty = 1;
}

// make sure the variant actually exists
$variant_rs = Database::search("SELECT `variant_id` FROM `product_variants` WHERE `variant_id`='" . $variant_id . "' LIMIT 1");
if (!$variant_rs || $variant_rs->num_rows !== 1) {
    echo("error: This product is no longer available.");
    exit;
}

// already in cart? bump quantity. otherwise insert a new row.
$existing_rs = Database::search("SELECT `cart_item_id`, `quantity` FROM `cart_items` WHERE `user_id`='" . $user_id . "' AND `variant_id`='" . $variant_id . "' LIMIT 1");

if ($existing_rs && $existing_rs->num_rows === 1) {
    $existing = $existing_rs->fetch_assoc();
    $newQty = (int) $existing['quantity'] + $qty;
    Database::iud("UPDATE `cart_items` SET `quantity`='" . $newQty . "' WHERE `cart_item_id`='" . (int) $existing['cart_item_id'] . "' ");
} else {
    Database::iud("INSERT INTO `cart_items` (`user_id`,`variant_id`,`quantity`) VALUES ('" . $user_id . "','" . $variant_id . "','" . $qty . "')");
}

// confirm it actually took (iud() doesn't return anything useful)
$check_rs = Database::search("SELECT `cart_item_id` FROM `cart_items` WHERE `user_id`='" . $user_id . "' AND `variant_id`='" . $variant_id . "' LIMIT 1");

if ($check_rs && $check_rs->num_rows === 1) {
    echo("success");
} else {
    echo("error: Failed to add to cart.");
}