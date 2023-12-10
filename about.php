<?php
session_start();
ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>About | Sea You Soon</title>
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

    <!-- About Section -->
    <section class="about">
        <div class="about-ctn">
            <p>Sea You Soon is a platform designed to transform simple messages into timeless treasures. The project
                revolves around a user-friendly website that allows individuals to create and send virtual “bottled”
                messages to themselves, allowing them to set the duration of the said bottle and receiving its content
                the once the time expires. The idea behind the project is to entrust messages to the digital world and
                instead of immediately receiving them, it is stored for a defined amount of time. As time passes by, the
                user may forget about the message. This pause in the immediacy of communication will add a layer of
                anticipation and excitement to each almost as if you were digging a time capsule. It encourages the
                beauty of patience in a society where instant gratification is what people strive for. Simultaneously,
                it promotes mindfulness, where users are invited to meditate on their current state of mind, goals, or
                aspirations.</p><br>
            <p>More information coming soon.</p>
        </div>
    </section>

    <!-- Footer -->
    <?php
        include 'footer.php';
    ?>
</body>

</html>