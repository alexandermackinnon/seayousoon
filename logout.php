<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page or any other page you want after logout
header("Location: login.php?notice=You have succesfully logged out. Sea you soon!");
exit();
?>