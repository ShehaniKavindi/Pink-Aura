<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../includes/connection.php";
header('Content-Type: application/json');

Database::setUpConnection();

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$user_id = (int) $_SESSION['user_id'];

$rs = Database::search("
    SELECT
        ci.cart_item_id,
        ci.variant_id,
        ci.quantity,
        pv.label AS variant_label,
        pv.price,
        p.product_id,
        p.title,
        (SELECT pi.image_url FROM product_images pi
            WHERE pi.product_id = p.product_id AND pi.is_primary = 1
            LIMIT 1) AS image
    FROM cart_items ci
    JOIN product_variants pv ON pv.variant_id = ci.variant_id
    JOIN products p ON p.product_id = pv.product_id
    WHERE ci.user_id = '" . $user_id . "'
    ORDER BY ci.added_at DESC
");

$items = [];
if ($rs) {
    while ($row = $rs->fetch_assoc()) {
        $items[] = [
            'id'        => (int) $row['cart_item_id'],
            'productId' => (int) $row['product_id'],
            'variantId' => (int) $row['variant_id'],
            'name'      => $row['title'],
            'variant'   => $row['variant_label'],
            'price'     => (float) $row['price'],
            'qty'       => (int) $row['quantity'],
            'img'       => $row['image'] ?: null,
        ];
    }
}

echo json_encode($items, JSON_UNESCAPED_UNICODE);