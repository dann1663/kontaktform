<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $successMessage = "Tak for din besked";

    require 'vendor/autoload.php';

    $mailMain = new PHPMailer(true);

    try {
        // SMTP configuration for main email
        $mailMain->isSMTP();
        $mailConfirm->CharSet = 'UTF-8';
        $mailMain->Host = 'smtp.gmail.com';
        $mailMain->SMTPAuth = true;
        $mailMain->Username = 'Din mail';
        $mailMain->Password = 'Din password';
        $mailMain->SMTPSecure = 'tls';
        $mailMain->Port = 587;

        
        $mailMain->setFrom('notphishing6@gmail.com', 'Din ven'); 
        $mailMain->addAddress('notphishing6@gmail.com');

        // Content
        $mailMain->isHTML(false);
        $mailMain->Subject = 'New Message from Contact Form';
        $mailMain->Body = "Name: $name\nEmail: $email\n\n$message";

     
        $mailMain->send();

        // Create a PHPMailer instance for confirmation email
        $mailConfirm = new PHPMailer(true);

        // SMTP configuration for confirmation email
        $mailConfirm->isSMTP();
        $mailConfirm->Host = 'smtp.gmail.com';
        $mailConfirm->SMTPAuth = true;
        $mailConfirm->Username = 'Din mail';
        $mailConfirm->Password = 'Din password';
        $mailConfirm->SMTPSecure = 'tls';
        $mailConfirm->Port = 587;

        
        $mailConfirm->setFrom('notphishing6@gmail.com', $mail); 
        $mailConfirm->addAddress($email, $name);

        // content
        $mailConfirm->isHTML(false);
        $mailConfirm->CharSet = 'UTF-8';
        $mailConfirm->Subject = 'Bekræftelse: Vi har modtaget din besked';
        $mailConfirm->Body = "Hej $name,\n\n$successMessage\n\nMed venlig hilsen,\nDit team";

     
        $mailConfirm->send();

        echo $successMessage;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mailMain->ErrorInfo}";
    }
} else {
    // If not a POST request, redirect to the form page
    header("Location: contact_form.html");
}
?>
