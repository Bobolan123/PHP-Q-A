<?php
session_start(); // Start the session

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

        // Check if the email title and content are not empty
        if (!empty($emailTitle) && !empty($emailContent)) {
            // Email configuration
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'bobolan12312@gmail.com'; // Your Gmail address
                $mail->Password = 'aojmdapsoasfopcd'; // the Gmail security app password
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
                $_SESSION["sendEmail_success"] = true;
                header("Location: /");
            } catch (Exception $e) {
                $_SESSION["sendEmail_success"] = false;
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                header("Location: /");

            }
        } else {
            // Set error message if title or content is empty
            $_SESSION["sendEmail_success"] = false;
            $_SESSION["sendEmail_error"] = "Email title and content are required.";
            header("Location: /");

        }
    } else {
        $_SESSION["sendEmail_success"] = false;
        // Send a bad request response if required parameters are missing
        http_response_code(400);
        echo "Bad request. Missing parameters.";
    }
} else {
    // Send a method not allowed response if the request method is not POST
    http_response_code(405);
    echo "Method Not Allowed.";
}
