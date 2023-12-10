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


        $insertOneResult = $collection->insertOne([
            'username' => $username,
            'password' => $password,
            'email' => $email,
        ]);

        printf("User registered successfully\n");
        var_dump($insertOneResult->getInsertedId());
    }
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup | SEA YOU SOON</title>
    <link rel="stylesheet" type="text/css" href="./SEA YOU SOON _ A REFLECTIVE SPACE OF FORESIGHT_files/main.css">
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <!-- Signup Section -->
    <section class="signup">
        <div class="signup-ctn">
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
                <button class="button clear-btn rounded-btn" type="submit" name="signup"><span>Sign up</span></button>
            </form>
        </div>
    </section>
</body>

</html>