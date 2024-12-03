<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

setcookie('re_member_me_cookie', '', time() - 1, '/');

// Redirect to the login page or homepage
header("Location: ../../index.php");
exit();
?>