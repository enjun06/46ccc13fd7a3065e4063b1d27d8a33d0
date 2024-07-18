<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHelper
{
    public static function sendMail($recipient, $subject, $body)
    {
        $mail = new PHPMailer();

        /*
            NOTES : Ini masih menggunakan SMTP Testing dari Mailtrap
        */
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['MAILTRAP_HOST']; 
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAILTRAP_USERNAME'];
            $mail->Password = $_ENV['MAILTRAP_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['MAILTRAP_PORT'];

            $mail->setFrom('jun_tes@yopmail.com', 'Mailer');
            $mail->addAddress($recipient);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
