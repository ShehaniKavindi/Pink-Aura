<?php
include "../connection.php";
include "../includes/SMTP.php";
include "../includes/PHPMailer.php";
include "../includes/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

$email = $_POST['em'];

$user_rs = Database::search("SELECT * FROM `users` WHERE `email`='" . $email . "' ");
$user_num = $user_rs->num_rows;

if ($user_num == 1) {

    do {
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $otp_check_rs = Database::search("SELECT * FROM `users` WHERE `otp`='" . $otp . "'");
    } while ($otp_check_rs->num_rows > 0);

    Database::iud("UPDATE `users` SET `otp`='" . $otp . "' WHERE `email`='" . $email . "' ");

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
    $mail->addAddress($email); //reciever's email
    $mail->isHTML(true);
    $mail->Subject = 'Verification code | Reset Password of Your Pink aura Account';
    $bodyContent = '<p style="font-size:25px;">Your verification code is <b>' . $otp . '</b> </p>';
    $mail->Body    = $bodyContent;

    if (!$mail->send()) {
        echo ("Verification sending failed");
    } else {
        echo ("sent");
    }

} else {

    echo ("not_found");
}
