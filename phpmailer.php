#!/usr/local/bin/php.cli
<?php

require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Set the time zone to 'America/New_York'
date_default_timezone_set('America/New_York');

try {
    // Connect to MongoDB
    require_once('db.php');

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

    // Fetch messages from Messages collection that are past their arrival date and active
    $pastDueMessagesCursor = $messageCollection->find([
        'arrivalDate' => ['$lt' => $todayDate],
        'active' => true
    ]);

    // Iterate through past due messages and send emails
    foreach ($pastDueMessagesCursor as $pastDueMessage) {
        $userId = $pastDueMessage['userId'];
        $email = $userCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($userId)])['email'];

        // Message details
        $subject = 'Your Time Capsule Has Arrived';
        $messageContent = $pastDueMessage['message'];

        // Absolute URL for the image
        $imageUrl = 'assets/images/stamp.png'; // Replace with the actual URL of your image

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
        $mail->setFrom('azhars137@gmail.com', 'Sea You Soon');
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->isHTML(true); // Set email format to HTML
        $mail->Body = $emailContent;
        $mail->AddEmbeddedImage($imageUrl, 'logo_2u');

        // Debugging output
        echo "Attempting to send email<br>";

        // Uncomment the following line to actually send emails
        $mail->send();

        // Check for errors during email sending
        if ($mail->ErrorInfo) {
            echo 'Error sending email:' . $mail->ErrorInfo . '<br>';
        } else {
            echo 'Email sent';
            // Set the message as inactive
            $messageCollection->updateOne(['_id' => $pastDueMessage['_id']], ['$set' => ['active' => false]]);
        }
    }
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}

?>