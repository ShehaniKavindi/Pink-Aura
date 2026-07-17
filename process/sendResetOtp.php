<?php
include "../includes/connection.php";
include "../includes/SMTP.php";
include "../includes/PHPMailer.php";
include "../includes/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

function esc($value) {
    Database::setUpConnection();
    return Database::$connection->real_escape_string($value);
}

$email = trim($_POST['em'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo("not_found");
    exit;
}

$emailEsc = esc($email);

$user_rs = Database::search("SELECT * FROM `users` WHERE `email`='" . $emailEsc . "' ");

if (!$user_rs) {
    echo("db_error");
    exit;
}

$user_num = $user_rs->num_rows;

if ($user_num == 1) {

    do {
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $otp_check_rs = Database::search("SELECT * FROM `users` WHERE `otp`='" . $otp . "'");
    } while ($otp_check_rs && $otp_check_rs->num_rows > 0);

    Database::iud("UPDATE `users` SET `otp`='" . $otp . "' WHERE `email`='" . $emailEsc . "' ");

    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'pinkauracosmetics@gmail.com'; //sender's email
    $mail->Password = 'ldrhfprzynnzuqkd'; //app password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('pinkauracosmetics@gmail.com', 'Reset Password');
    $mail->addReplyTo('pinkauracosmetics@gmail.com', 'Reset Password');
    $mail->addAddress($email); // receiver's email (raw, unescaped value is fine here - not used in SQL)
    $mail->isHTML(true);
    $mail->Subject = 'Verification code | Reset Password of Your Pink Aura Account';
    $bodyContent = '<p style="font-size:25px;">Your verification code is <b>' . $otp . '</b></p>';
    $mail->Body = $bodyContent;

    if (!$mail->send()) {
        echo("mail_error: " . $mail->ErrorInfo);
    } else {
        echo("sent");
    }

} else {
    echo("not_found");
}