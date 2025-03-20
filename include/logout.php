<?php
include 'auth.php'; // Include the auth.php file

session_destroy(); // Destroy the session

header("Location: ../index.php"); // Redirect to the root index.php
exit(); // Ensure no further code is executed
