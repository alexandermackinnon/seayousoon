<?php
session_start();
ob_start();

// Make this page login-only
require_once('authentication.php');

require_once __DIR__ . '/vendor/autoload.php';

try {
    $client = new MongoDB\Client("mongodb+srv://infoseayousoon:UNy8fZIiGFex0pWi@cart351.vigmtxs.mongodb.net/?retryWrites=true&w=majority");
    // echo("Valid connection");

    $collection = $client->CART351->Messages;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_message'])) {
        $userId = $_SESSION['user_id'];
        $messageContent = $_POST['message'];

        if (isset($_POST['arrivalDate'])) {
            $arrivalDate = $_POST['arrivalDate'];
        } else {
            $arrivalDate = null;
        }

        if ($_POST['send_message'] == "Next") {
            // First form processing
            $messageData = [
                'userId' => $userId,
                'message' => $messageContent,
                'timestamp' => new MongoDB\BSON\UTCDateTime(),
            ];
        } elseif ($_POST['send_message'] == "Send") {
            // Second form processing
            $messageData = [
                'userId' => $userId,
                'message' => $messageContent,
                'arrivalDate' => $arrivalDate,
                'timestamp' => new MongoDB\BSON\UTCDateTime(),
            ];

            $insertResult = $collection->insertOne($messageData);

            if ($insertResult->getInsertedCount() > 0) {
                echo "Message sent successfully!";
            } else {
                echo "Error sending message.";
            }
            exit(); // Add this to stop further execution after handling the form submission
        }
    }
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>SEA YOU SOON | A REFLECTIVE SPACE OF FORESIGHT</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <meta charset="UTF-8" />
</head>

<body>
    <!-- Header -->
    <?php
    include 'header.php';
    ?>

    <audio id="backgroundMusic" autoplay loop>
        <source src="/assets/audio/soundtrack_02.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <!-- Landing Section -->
    <section class="capsule">
        <div class="capsule-ctn">
            <div class="capsule-form-ctn">
                <div class="form-step" id="step1">
                    <h2>WHAT'S ON YOUR MIND?</h2>
                    <form onsubmit="return showStep2();">
                        <div class="input-group">
                            <label for="message">Message</label>
                            <textarea rows="10" id="message" name="message" required></textarea>
                        </div>
                        <button class="button rounded-btn" type="submit">Next</button>
                    </form>
                </div>

                <div class="form-step" id="step2" style="display: none;">
                    <h2>INTO THE SEA!</h2>
                    <form onsubmit="return sendMessage();">
                        <div>
                            <button class="button rounded-btn link" onclick="showDateSelector()" id="pickDateBtn">Pick a
                                date of arrival</button>
                            <button class="button rounded-btn link" onclick="hideDateSelector()" id="surpriseMeBtn">Let
                                the waves decide</button>
                        </div>
                        <div id="dateSelector" style="display: none;">
                            <label for="arrivalDate">Select Date of Arrival:</label>
                            <input type="date" id="arrivalDate" name="arrivalDate">
                        </div>
                        <button class="button rounded-btn" type="submit">Send</button>
                    </form>
                </div>

                <script>
                function showStep2() {
                    document.getElementById('step1').style.display = 'none';
                    document.getElementById('step2').style.display = 'flex';
                    return false;
                }

                function showDateSelector() {
                    document.getElementById('dateSelector').style.display = 'flex';
                    document.getElementById('pickDateBtn').classList.add('active');
                    document.getElementById('surpriseMeBtn').classList.remove('active');
                }

                function hideDateSelector() {
                    document.getElementById('dateSelector').style.display = 'none';
                    document.getElementById('surpriseMeBtn').classList.add('active');
                    document.getElementById('pickDateBtn').classList.remove('active');
                }

                function sendMessage() {
                    var messageContent = document.getElementById('message').value;
                    var arrivalDate = document.getElementById('arrivalDate').value;

                    // You may want to add validation logic here before submission

                    // Use AJAX to submit the form data to the server
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', window.location.href, true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    // Construct the data to send
                    var formData = 'send_message=Send&message=' + encodeURIComponent(messageContent) + '&arrivalDate=' +
                        encodeURIComponent(arrivalDate);

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Handle the response from the server if needed
                            console.log(xhr.responseText);
                        }
                    };

                    // Send the form data
                    xhr.send(formData);

                    // Prevent the default form submission
                    return false;
                }
                </script>
            </div>
    </section>

    <!-- Footer -->
    <?php
    include 'footer.php';
    ?>

    <script>
    var backgroundMusic = document.getElementById("backgroundMusic");

    function toggleBackgroundMusic() {
        if (backgroundMusic.paused) {
            backgroundMusic.play();
        } else {
            backgroundMusic.pause();
        }
    }
    </script>
</body>

</html>