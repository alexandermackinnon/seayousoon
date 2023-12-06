<?php

require 'vendor/autoload.php';

use MongoDB\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Set the time zone to 'America/New_York'
date_default_timezone_set('America/New_York');

try {
    // Connect to MongoDB
    $client = new Client("mongodb+srv://infoseayousoon:UNy8fZIiGFex0pWi@cart351.vigmtxs.mongodb.net/?retryWrites=true&w=majoritys");

    // Select MongoDB collections
    $userCollection = $client->CART351->Users;
    $messageCollection = $client->CART351->Messages;

    // Use PHPMailer to send emails
    $mail = new PHPMailer(true);

    // Configure PHPMailer with SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'azhars137@gmail.com';
    $mail->Password = 'buvm nlpz odve dlek';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Get today's date in the format 'Y-m-d'
    $todayDate = date('Y-m-d');

    // Create an array to track sent emails
    $sentEmails = [];

    // Fetch data from Users collection
    $usersCursor = $userCollection->find([]);

    // Iterate through users and send emails
    foreach ($usersCursor as $user) {
        $userId = $user['userId'];
        $email = $user['email'];

        // Check if email has already been sent for this user
        if (in_array($email, $sentEmails)) {
            echo "Email already sent to $email today<br>";
            continue; // Skip to the next user
        }

        // Fetch data from Messages collection for the user using the userId and today's date
        $messageCursor = $messageCollection->findOne(['user_id' => $userId, 'arrivalDate' => $todayDate]);

        // Debugging output with detailed information
        echo "Checking user $email (User ID: $userId) for today's date $todayDate<br>";

        if ($messageCursor !== null) {
            // Message details
            $subject = 'Your Time Capsule Has Arrived';
            $messageDate = $messageCursor['date'];
            $messageContent = $messageCursor['message'];

            // Absolute URL for the image
            $imageUrl = 'image/stamp.png'; // Replace with the actual URL of your image

            // Email content
            $emailContent = "
                <html>
                <head>
                    <style>
                        body {
                            background-color: #3E4450;
                        }
                        h1, p {
                            color: white;
                            padding: 20px;
                        }
                        div {
                            text-align: center;
                        }
                        img{
                            margin-top:20px;
                        }
                    </style>
                </head>
                <body style='background-color: #3E4450;'>

                <img src='cid:logo_2u'  alt='Sea You Soon Image'>
                    <div>
                        <h1>Your message has found its way to you. Read it below</h1>
                        <p>Dear Traveler,</p>
                        <p>{$messageContent}</p>
                        <p>Sea You Soon<br></p>
                        
                    </div>
                </body>
                </html>
            ";

            // Set email parameters
            $mail->setFrom('azhars137@gmail.com', 'SeaYouSoon');
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->isHTML(true); // Set email format to HTML
            $mail->Body = $emailContent;
            $mail->AddEmbeddedImage($imageUrl, 'logo_2u');

            // Debugging output
            echo "Attempting to send email to $email<br>";

            // Uncomment the following line to actually send emails
            $mail->send();

            // Check for errors during email sending
            if ($mail->ErrorInfo) {
                echo 'Error sending email to ' . $email . ': ' . $mail->ErrorInfo . '<br>';
            } else {
                echo 'Email sent to ' . $email . '<br>';
                // Add the email to the sentEmails array to track it
                $sentEmails[] = $email;
            }
        } else {
            echo "No message found for user $email today<br>";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>
