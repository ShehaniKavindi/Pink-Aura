<?php
include "../includes/connection.php";

// Assumes connection.php sets a global mysqli connection called $conn —
// used for mysqli_insert_id() and escaping. Rename below if yours differs.

function esc($value) {
    Database::setUpConnection();
    return Database::$connection->real_escape_string($value);
}

$subCat = esc($_POST['scat']);
$title = esc($_POST['title']);
$variantType = esc($_POST['vtype']);
$description = esc($_POST['des']);
$keyIngredients = esc($_POST['ki']);
$howToUse = esc($_POST['htu']);
$variants = json_decode($_POST['variants'], true);

if (!$variants || count($variants) === 0) {
    echo "error: no variants received";
    exit;
}

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimeZone($tz);
$date = $d->format("Y-m-d H:i:s");

// ---------- insert product ----------
Database::iud("INSERT INTO `products` (`subcategory_id`,`title`,
                `description`,`key_ingredients`,`how_to_use`,`variant_type`,`created_at`) 
                VALUES ('".$subCat."','".$title."','".$description."','".$keyIngredients."',
                '".$howToUse."','".$variantType."','".$date."') ");

$product_id = Database::$connection->insert_id;

// ---------- insert variants (size / shade / color / "Standard") ----------
// keyed by the same index used in variantRows on the client, so uploaded
// variant_images[i] files line up with the variant they were saved under.
$variant_ids_by_index = [];

foreach ($variants as $i => $v) {
    $label  = esc($v['label']);
    $hex    = !empty($v['hex']) ? "'".esc($v['hex'])."'" : "NULL";
    $vPrice = esc($v['price']);
    $vStock = esc($v['stock']);
    $isDefault = ($i === 0) ? 1 : 0;

    Database::iud("INSERT INTO `product_variants`
        (`product_id`,`label`,`swatch_hex`,`price`,`stock_qty`,`is_default`)
        VALUES ('".$product_id."','".$label."',".$hex.",'".$vPrice."','".$vStock."','".$isDefault."')");

    $variant_ids_by_index[$i] = Database::$connection->insert_id;
}

// ---------- subcategory slug (used in filenames for both image blocks) ----------
$subCat_slug_rs = Database::search("SELECT `slug` FROM `subcategories` WHERE `subcategory_id` = '".$subCat."' ");
$subCat_slug_data = $subCat_slug_rs->fetch_assoc();
$subCat_slug = $subCat_slug_data ? $subCat_slug_data['slug'] : 'general';

$productNO = str_pad($product_id, 5, "0", STR_PAD_LEFT);
$safeTitle = preg_replace('/[\\\\\/:*?"<>|]/', '', $title);
$allowed = ['jpg', 'jpeg', 'png', 'webp'];

$upload_dir = "../assets/images/products/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// ---------- handle general product image uploads (up to 4, shared gallery) ----------
if (!empty($_FILES['images']['name'][0])) {
    $count = count($_FILES['images']['name']);

    for ($i = 0; $i < $count && $i < 4; $i++) {
        if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) continue;

        $ext = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) continue;

        $imageNo = $i + 1;
        $filename = "P{$productNO}_{$subCat_slug}_{$safeTitle}_{$imageNo}.{$ext}";
        $dest = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $dest)) {
            $relative_path = "assets/images/products/" . $filename;
            $isPrimary = ($i === 0) ? 1 : 0;
            Database::iud("INSERT INTO `product_images`
                (`product_id`,`variant_id`,`image_url`,`sort_order`,`is_primary`)
                VALUES ('".$product_id."', NULL, '".esc($relative_path)."','".$i."','".$isPrimary."')");
        }
    }
}

// ---------- handle per-variant image uploads (optional, one per variant row) ----------
if (!empty($_FILES['variant_images']['name'])) {
    foreach ($_FILES['variant_images']['name'] as $index => $name) {
        if (empty($name)) continue;
        if ($_FILES['variant_images']['error'][$index] !== UPLOAD_ERR_OK) continue;
        if (!isset($variant_ids_by_index[$index])) continue;

        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) continue;

        $variant_id = $variant_ids_by_index[$index];
        $variantLabel = isset($variants[$index]['label']) ? $variants[$index]['label'] : 'variant';
        $safeVariantLabel = preg_replace('/[\\\\\/:*?"<>|]/', '', $variantLabel);
        $safeVariantSlug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $safeVariantLabel));
        $safeVariantSlug = trim($safeVariantSlug, '-');

        $filename = "P{$productNO}_{$subCat_slug}_{$safeTitle}_variant-{$safeVariantSlug}.{$ext}";
        $dest = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['variant_images']['tmp_name'][$index], $dest)) {
            $relative_path = "assets/images/products/" . $filename;
            Database::iud("INSERT INTO `product_images`
                (`product_id`,`variant_id`,`image_url`,`sort_order`,`is_primary`)
                VALUES ('".$product_id."','".$variant_id."','".esc($relative_path)."','0','0')");
        }
    }
}

echo "success:" . $product_id;
?>