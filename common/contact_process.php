<?php
require '../mail.php'; // تأكد أن هذا الملف يحتوي على إعدادات PHPMailer

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $sendetto = "info@approvednaturals.ca";

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
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Message:</strong><br>{$message}</p>
        ";

        $mail->send();
        echo "Message sent successfully!";

        // إذا تريد تخزين البيانات في القاعدة
        // $stmt = $con->prepare("INSERT INTO tblMessages (name,email,message) VALUES (?,?,?)");
        // $stmt->execute([$name,$email,$message]);

    } catch (Exception $e) {
        echo "Message could not be sent. Error: ".$mail->ErrorInfo;
    }
}
