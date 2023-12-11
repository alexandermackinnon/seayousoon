<?php
session_start();
ob_start();

require_once __DIR__ . '/vendor/autoload.php';

try {
    // Connect to MongoDB
    require_once('db.php');

    // Select MongoDB collections
    $collection = $client->CART351->Users;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $collection->findOne(['username' => $username]);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['_id'];
            $_SESSION['user_name'] = $username;
            
            header("Location: index.php");
            exit();
        } else {
            header("Location: login.php?error=Invalid username or password.");
        }
    }
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Log In | Sea You Soon</title>
    <link rel="stylesheet" type="text/css" href="./SEA YOU SOON _ A REFLECTIVE SPACE OF FORESIGHT_files/main.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <!-- Login Section -->
    <section class="login">
        <div class="login-ctn">
            <div class="login-ctn-inner">
                <h4>Log In</h4>
                <!-- Errors -->
                <?php 
                if (isset($_GET['error'])) { 
            ?> <div class="login-message error">
                    <?php 
                    echo $_GET['error']; 
                ?></div>
                <?php } ?>
                <!-- Notices -->
                <?php 
                if (isset($_GET['notice'])) { 
            ?> <div class="login-message notice">
                    <?php 
                    echo $_GET['notice']; 
                ?></div>
                <?php } ?>
                <div>
                    <form action="login.php" method="post">
                        <div class="input-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" required="">
                        </div>
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required="">
                        </div>
                        <button class="button blue-btn rounded-btn" type="submit" name="login"><span>Log
                                In</span></button>
                    </form>
                </div>
                <hr>
                <div class="other-option">
                    <h6>Don't have an account?</h6>
                    <a href="signup.php" class="button clear-btn rounded-btn"><span>Sign up</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="extra-ctn">
            <div class="video-overlay">
            </div>
            <div class="video-bg">
                <a href="index.php"><img class="logo" src="assets/images/stamp.png"></a>
                <video autoplay muted loop>
                    <source src="assets/video/water02.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
    </section>
</body>

</html>