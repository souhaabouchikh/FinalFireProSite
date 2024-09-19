<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  $mail = new PHPMailer(true);

  try {
    // SMTP settings
    $mail->isSMTP(); 
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;
    $mail->Username = 'studentsouha@gmail.com'; 
    $mail->Password = 'nhkiimirhormrwve'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587; 

    // Email settings
    $mail->setFrom($email, $name);
    $mail->addAddress('studentsouha@gmail.com', 'Admin');
    $mail->isHTML(true);
    $mail->Subject = $subject;

    // Attach an image
    $mail->addEmbeddedImage('../img/email_banner.png', 'image_cid');
    
    // Email body
    $body = "
      <html>
        <head>
          <style>
            body {
              font-family: Arial, sans-serif;
              color: #333;
              margin: 0;
              padding: 0;
              background-color: #f4f4f4;
            }
            .container {
              width: 80%;
              margin: 0 auto;
              background: #fff;
              padding: 20px;
              border-radius: 8px;
              box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h2 {
              color: #0056b3;
            }
            table {
              width: 100%;
              border-collapse: collapse;
            }
            table th, table td {
              padding: 10px;
              text-align: left;
              border-bottom: 1px solid #ddd;
            }
            table th {
              background-color: #f8f8f8;
              color: #0056b3;
            }
            .footer {
              margin-top: 20px;
              font-size: 0.9em;
              color: #555;
            }
          </style>
        </head>
        <body>
          <div class='container'>
            <img src='cid:image_cid' alt='Banner' style='width:100%; height:auto; border-radius: 8px;'>
            <h2>Contact Form Submission</h2>
            <table>
              <tr><th>Name:</th><td>$name</td></tr>
              <tr><th>Email:</th><td>$email</td></tr>
              <tr><th>Phone:</th><td>$phone</td></tr>
              <tr><th>Subject:</th><td>$subject</td></tr>
              <tr><th>Message:</th><td>$message</td></tr>
            </table>
            <div class='footer'>
              <p>Thank you for contacting us. We will get back to you shortly.</p>
            </div>
          </div>
        </body>
      </html>
    ";
    $mail->Body = $body;
    $mail->AltBody = 'This is the plain text version';

    // Send email
    if ($mail->send()) {
      header('Location: ../contact.html?status=success');
      exit();
    }
  } catch (Exception $e) {
    // If mail fails to send, catch the error
    header('Location: ../contact.html?status=error&message=' . urlencode("Mailer Error: {$mail->ErrorInfo}"));
    exit();
  }
} else {
  header('Location: /contact-form.php?status=no_data');
  exit();
}
?>
