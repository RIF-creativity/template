<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "phpmailer/src/PHPMailer.php";
require_once "phpmailer/src/Exception.php";
require_once "phpmailer/src/POP3.php";
require_once "phpmailer/src/SMTP.php";
function Email($email, $pengirim, $penerima, $judul, $pesan)
{
    $mail = new PHPMailer(true);

    //Enable SMTP debugging. 
    $mail->SMTPDebug = 2;
    //Set PHPMailer to use SMTP.
    $mail->isSMTP();
    //Set SMTP host name                          
    $mail->Host = "smtp.gmail.com"; //host mail server
    //Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth = true;
    //Provide username and password     
    $mail->Username = "rif.creativity@gmail.com";   //nama-email smtp          
    $mail->Password = "obcgkntjkfbsvgzv";           //password email smtp
    //If SMTP requires TLS encryption then set it
    $mail->SMTPSecure = "tls";
    //Set TCP port to connect to 
    $mail->Port = 587;

    $mail->From = $pengirim; //email pengirim
    $mail->FromName = "Admin"; //nama pengirim

    $mail->addAddress($email, $penerima); //email penerima

    $mail->isHTML(true);

    $mail->Subject = $judul; //subject
    $mail->Body    = $pesan; //isi email
    $mail->AltBody = "PHP mailer"; //body email (optional)


    $mail->send();
    return ($mail);
}
