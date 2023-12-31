<?php
session_start();

// Make this page login-only
require_once('authentication.php');

require_once __DIR__ . '/vendor/autoload.php';

// Initialize scroll count
$scrollCount = isset($_POST['scrollCount']) ? $_POST['scrollCount'] : 0;

try {
    // MongoDB connection
    require_once('db.php');
    $messageCollection = $client->CART351->Messages;
    $coordsCollection = $client->CART351->Coords;

    // Update the Messages collection schema to include the interactionCount field
    $messages = $messageCollection->find(['active' => true], ['projection' => ['_id' => 1, 'message' => 1, 'reactions' => 1]]);
    foreach ($messages as $message) {
        // Add the interactionCount field if it doesn't exist
        if (!isset($message['interactionCount'])) {
            $messageCollection->updateOne(
                ['_id' => $message['_id']],
                ['$set' => ['interactionCount' => 0]]
            );
        }
    }

    // Retrieve messages from the database
    $result = $messageCollection->find(['active' => true], ['projection' => ['_id' => 1, 'message' => 1, 'reactions' => 1, 'interactionCount' => 1]]);
    $messages = iterator_to_array($result);

    // Format messages for JavaScript
    $messageArr = [];
    foreach ($messages as $message) {
        $messageArr[] = [
            'message' => $message['message'],
            '_id' => (string) $message['_id'],
            'reactions' => isset($message['reactions']) ? $message['reactions'] : 0,
            'interactionCount' => isset($message['interactionCount']) ? $message['interactionCount'] : 0,
        ];
    }

    // Handle coordinates data on POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['x']) && isset($_POST['y']) && isset($_POST['selectedValue'])) {
        $x = $_POST['x'];
        $y = $_POST['y'];
        $selectedValue = $_POST['selectedValue'];

        // Use the current message ID based on scrollCount
        $currentMessageId = isset($messageArr[$scrollCount]['_id']) ? $messageArr[$scrollCount]['_id'] : null;

        // Increment reactions and interactionCount for the specific message
        if ($currentMessageId) {
            $messageCollection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectID($currentMessageId)],
                ['$inc' => ['reactions' => 1, 'interactionCount' => 1]]
            );

            // Store SVG path and reactions count in the Coords collection
            $coordsCollection->insertOne([
                'message_id' => $currentMessageId,
                'reaction' => $selectedValue,
                'x' => $x,
                'y' => $y,
            ]);
        }
    }
} catch (Exception $e) {
    // Handle exceptions
    echo 'Caught exception: ', $e->getMessage(), "\n";
    echo 'Exception trace: ', $e->getTraceAsString(), "\n";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dock | Sea You Soon</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <script type="text/javascript" src="js/wave.js"></script>
    <meta charset="UTF-8" />
</head>

<body>
    <!-- Header -->
    <?php
        include 'header.php';
    ?>

    <audio id="backgroundMusic" autoplay loop>
        <source src="/assets/audio/soundtrack_01.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <!-- Dock Section -->
    <section class="dock">
        <div class="dock-ctn">
            <div id="content">
                <div id="messageContainer">
                    <p id="messageText"></p>
                </div>
            </div>

            <div>
                <!-- Dropdown for stamps -->
                <label for="stamps">Select a Stamp:</label>
                <select id="stamps" onchange="logSelectedSvgPath(this.value)">
                    <option value="">Select a Stamp</option>
                    <?php
            // Path to stamps folder
            $stampsFolder = __DIR__ . '/assets/icons/stamps';

            // Get all files in the stamps folder
            $files = scandir($stampsFolder);

            // Filter out non-image files
            $imageFiles = array_filter($files, function ($file) {
                $imageExtensions = ['svg'];
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                return in_array(strtolower($extension), $imageExtensions);
            });

            // Output options for each image file
            foreach ($imageFiles as $file) {
                echo "<option value=\"$file\">$file</option>";
            }
            ?>
                </select>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php
        include 'footer.php';
    ?>
</body>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
let message = document.getElementById("messageText");
let messages = <?php echo json_encode($messageArr); ?>;
let scrollCount = 0;
let lastScrollTime = Date.now();

function displayMessage() {
    if (scrollCount < messages.length) {
        message.innerHTML = messages[scrollCount].message;
    } else {
        // All messages have been displayed, take any other action here.
    }
}

window.addEventListener("wheel", (e) => {
    const currentTime = Date.now();
    if (currentTime - lastScrollTime > 500) {
        scrollCount = scrollCount + 1;
        displayMessage();
        lastScrollTime = currentTime;
    }
});

displayMessage();

let messageContainer = document.getElementById("content");

function addImage(selectedValue, x, y) {
    // Create an <img> element
    const imageElement = document.createElement("img");

    // Set the source (path) of the image
    imageElement.src = "assets/icons/stamps/" + selectedValue;

    // Set the position of the image using the x and y coordinates
    imageElement.style.position = "absolute";
    imageElement.style.left = x + "px";
    imageElement.style.top = y + "px";

    // Set the size of the image (adjust the width and height accordingly)
    imageElement.style.width = "50px"; // Set the width to 50 pixels (adjust as needed)
    imageElement.style.height = "50px"; // Set the height to 50 pixels (adjust as needed)

    // Append the image to the message container
    messageContainer.appendChild(imageElement);
}

function logSelectedSvgPath(selectedValue) {
    // Get the click coordinates inside the message container
    messageContainer.addEventListener("click", function(event) {
        const x = event.clientX - messageContainer.getBoundingClientRect().left;
        const y = event.clientY - messageContainer.getBoundingClientRect().top;

        // Send the selected SVG path, coordinates, and scroll count to the server
        $.post("dock.php", {
            x: x,
            y: y,
            selectedValue: selectedValue,
            scrollCount: scrollCount
        }, function(data) {
            // Handle the response from the server if needed
            console.log("Reaction logged successfully");
        });

        // Log the selected SVG path and add the image at the clicked coordinates
        console.log('Selected SVG Path:', selectedValue);
        addImage(selectedValue, x, y);
    });
}
</script>

</html>