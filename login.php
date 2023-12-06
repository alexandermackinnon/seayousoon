<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';

try {
    $client = new MongoDB\Client("mongodb+srv://infoseayousoon:UNy8fZIiGFex0pWi@cart351.vigmtxs.mongodb.net/?retryWrites=true&w=majority");
    //echo("Valid connection");
    //echo("<br>");

    $collection = $client->CART351->Users;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $collection->findOne(['username' => $username]);

        if ($user && password_verify($password, $user['password'])) {
            echo "Login successful!";
            
            $_SESSION['user_id'] = $user['_id'];

            
            header("Location: process_message.php");
            exit();
        } else {
            echo "Invalid username or password.";
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
    <title>Login | SEA YOU SOON</title>
    <link rel="stylesheet" type="text/css" href="./SEA YOU SOON _ A REFLECTIVE SPACE OF FORESIGHT_files/main.css">
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <!-- Login Section -->
    <section class="login">
        <div class="login-ctn">
            <form action="login.php" method="post">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required="">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required="">
                </div>
                <button class="button rounded-btn" type="submit" name="login">Login</button>
            </form>
        </div>
    </section>
</body>

</html>