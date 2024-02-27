<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required parameters are set
    if (isset($_POST['emailTitle']) && isset($_POST['emailContent'])) {
        // Sanitize the input data
        $emailTitle = filter_input(INPUT_POST, 'emailTitle', FILTER_SANITIZE_STRING);
        $emailContent = filter_input(INPUT_POST, 'emailContent', FILTER_SANITIZE_STRING);

        // Email configuration
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bobolan12312@gmail.com'; // Your Gmail address
            $mail->Password = 'aojmdapsoasfopcd'; // Your Gmail password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Sender and recipient settings
            $mail->setFrom('bobolan12312@gmail.com'); // Your name and Gmail address
            $mail->addAddress('bobolan12312@gmail.com'); // Recipient email address

            // Content
            $mail->isHTML(true);
            $mail->Subject = $emailTitle;
            $mail->Body = $emailContent;

            // Send email
            $mail->send();
            echo 'Email sent successfully.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Send a bad request response if required parameters are missing
        http_response_code(400);
        echo "Bad request. Missing parameters.";
    }
} else {
    // Send a method not allowed response if the request method is not POST
    http_response_code(405);
    echo "Method Not Allowed.";
}
