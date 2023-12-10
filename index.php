<?php
session_start();
ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sea You Soon</title>
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
            <a href="capsule.php"> <button class="button circle-btn bottle-up-btn">
                    <span><span>Bottle up</span></span>
                </button></a>
        </div>
    </section>

    <!-- Footer -->
    <?php
        include 'footer.php';
    ?>
</body>

</html>