<?php
session_start();
ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>SEA YOU SOON | A REFLECTIVE SPACE OF FORESIGHT</title>
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

    <!-- Landing Section -->
    <section class="landing">

        <!-- <script type="module" src="main.js"></script> -->
        <div class="landing-inner">
            <h1>SEA YOU SOON</h1>
            <img class="bottle" src="assets/images/bottle.png" alt="Glass bottle">
            <a href="process_message.php"> <button class="button circle-btn bottle-up-btn">
                    <svg aria-hidden="true" class="progress" width="70" height="70" viewbox="0 0 70 70">
                        <path class="progress__circle"
                            d="m35,2.5c17.955803,0 32.5,14.544199 32.5,32.5c0,17.955803 -14.544197,32.5 -32.5,32.5c-17.955803,0 -32.5,-14.544197 -32.5,-32.5c0,-17.955801 14.544197,-32.5 32.5,-32.5z" />
                        <path class="progress__path"
                            d="m35,2.5c17.955803,0 32.5,14.544199 32.5,32.5c0,17.955803 -14.544197,32.5 -32.5,32.5c-17.955803,0 -32.5,-14.544197 -32.5,-32.5c0,-17.955801 14.544197,-32.5 32.5,-32.5z"
                            pathLength="1" />
                    </svg>
                    <span>Bottle up</span>
                </button></a>
        </div>
    </section>

    <!-- Footer -->
    <?php
        include 'footer.php';
    ?>

    <script>
    var backgroundMusic = document.getElementById("backgroundMusic");
    window.addEventListener('load', function() {
        backgroundMusic.play();
    });

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