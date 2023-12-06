<?php
// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: login.php?notice=You must first login to start using the Sea You Soon platform.");
    exit();
}
?>