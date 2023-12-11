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
            <p>Sea You Soon is a web platform crafted to elevate ordinary messages into everlasting keepsakes. It
                empowers individuals to craft and dispatch virtual time capsules encapsulated in a "bottle" to their
                future selves, allowing them to meticulously tailor the temporal voyage of these virtual treasures. The
                essence of the project lies in entrusting messages to the digital realm, wherein instead of immediate
                receipt, they are securely stored for a predefined duration. As the waves crash endlessly and the sands
                of time slip away, users may inadvertently forget about their dispatched messages, fostering an element
                of suspense akin to the act of unearthing a time capsule. This deliberate delay in the immediacy of
                communication introduces an intriguing dimension of anticipation and excitement. Sea You Soon serves as
                a poignant reminder of the beauty inherent in patience, a virtue often overshadowed in a society
                relentlessly pursuing instant gratification. The platform, by design, encourages users to engage in a
                form of digital mindfulness, prompting them to reflect on their present state of mind, contemplate their
                goals, and nurture aspirations.</p>
        </div>
    </section>

    <!-- Footer -->
    <?php
        include 'footer.php';
    ?>
</body>

</html>