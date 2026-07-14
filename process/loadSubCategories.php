<?php
include "../includes/connection.php";

$mainCatID = $_GET['id'];

$sub_rs = Database::search("SELECT * FROM `subcategories` WHERE `category_id`='".$mainCatID."' ");
$sub_num = $sub_rs->num_rows;

for ($i = 0; $i < $sub_num; $i++) {
    $sub_data = $sub_rs->fetch_assoc();
    echo '<option value="'.$sub_data['subcategory_id'].'">'.htmlspecialchars($sub_data['name']).'</option>';
}
?>