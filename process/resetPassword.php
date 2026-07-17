<?php
include "../connection.php";

$email = $_POST['em'];
$password = $_POST['pw'];

Database::iud("UPDATE `users` SET `password`='".$password."' WHERE `email`='".$email."' ");

echo("success");

?>