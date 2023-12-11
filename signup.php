<?php
require_once __DIR__ . '/vendor/autoload.php';


try {
    // Connect to MongoDB
    require_once('db.php');

    // Select MongoDB collections
    $collection = $client->CART351->Users;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];

        // Check if the email already exists
        $existingEmailUser = $collection->findOne(['email' => $email]);
        if ($existingEmailUser) {
            // User with the same email already exists
            header("Location: signup.php?error=An account is already registered under that email.");
            exit;
        }

        // Check if the username already exists
        $existingUsernameUser = $collection->findOne(['username' => $username]);
        if ($existingUsernameUser) {
            // User with the same username already exists
            header("Location: signup.php?error=Username already exists.");
            exit;
        }

        // Insert the new user
        $insertOneResult = $collection->insertOne([
            'username' => $username,
            'password' => $password,
            'email' => $email,
        ]);

        printf("User registered successfully\n");
        var_dump($insertOneResult->getInsertedId());
        header("Location: login.php?notice=Your account has been successfully created! You may now log in.");
        exit;
    }
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup | Sea You Soon</title>
    <link rel="stylesheet" type="text/css" href="./SEA YOU SOON _ A REFLECTIVE SPACE OF FORESIGHT_files/main.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <!-- Signup Section -->
    <section class="login">
        <div class="login-ctn">
            <div class="login-ctn-inner">
                <h4>Sign Up</h4>
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
                    <form action="signup.php" method="post">
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required="">
                        </div>
                        <div class="input-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" required="">
                        </div>
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required="">
                        </div>
                        <button class="button blue-btn rounded-btn" type="submit" name="signup"><span>Sign
                                up</span></button>
                    </form>
                </div>
                <hr>
                <div class="other-option">
                    <h6>Already have an account?</h6>
                    <a href="login.php" class="button clear-btn rounded-btn"><span>Log in</span>
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
                    <source src="assets/video/water01.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
    </section>
</body>

</html>