<?php
require '../mail.php'; // تأكد أن هذا الملف يحتوي على إعدادات PHPMailer

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name           = htmlspecialchars($_POST['name']);
    $companyName    = htmlspecialchars($_POST['companyName']);
    $phoneNumber    = htmlspecialchars($_POST['phoneNumber']);
    $email          = htmlspecialchars($_POST['email']);
    $message        = htmlspecialchars($_POST['message']);
    $sendetto       = "info@approvednaturals.ca";

    try {
        // تأكد أن $applicationemail معرفة في mail.php
        $mail->setFrom($applicationemail, 'Approved Naturals'); // Sender
        $mail->addAddress($sendetto);                           // Receiver

        // إعداد محتوى البريد
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'New Contact Request from Website';
        $mail->Body    = "
            <h2>New Contact Request</h2>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Company Name:</strong> {$companyName}</p>
            <p><strong>Phone Number:</strong> {$phoneNumber}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Message:</strong><br>{$message}</p>
        ";

        $mail->send();
        echo "Message sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Error: ".$mail->ErrorInfo;
    }
}
 