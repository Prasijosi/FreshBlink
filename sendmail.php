<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Send an email using PHPMailer and Gmail SMTP.
 *
 * @param string $recipientEmail Recipient's email address
 * @param string $recipientName Recipient's name
 * @param string $subject Email subject
 * @param string $body HTML body content
 * @param string $altBody Plain text alternative body
 * @return bool|string           True on success, error message on failure
 */
function sendEmail($recipientEmail, $recipientName, $subject, $body, $altBody)
{
    $mail = new PHPMailer(true);

    try {
        // Server configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = "";       // Your Gmail address
        $mail->Password = "";          // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('noreply@freshblink.com', 'FreshBlink');
        $mail->addAddress($recipientEmail, $recipientName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = $altBody;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("PHPMailer Error: " . $mail->ErrorInfo);
        return "❌ Message could not be sent. Error: " . $mail->ErrorInfo;
    }
}
