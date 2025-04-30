<?php
require 'connect.php';
ini_set('session.cookie_lifetime', 592000); // 1 month expiration when inactive 592000
ini_set('session.gc_maxlifetime', 592000);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
session_start();
date_default_timezone_set('Asia/Manila');

// if (!isset($_SESSION['SESS_USERNAME'])) {
//   header('location: ../index.php');
//   exit();
// } else {
//   // Retrieve session ariables
//   $username = $_SESSION['SESS_USERNAME'];
//   $password = $_SESSION['SESS_PASSWORD'];
//   $fullname = $_SESSION['SESS_FULLNAME'];
//   $syslevel = $_SESSION['SESS_LEVEL'];
// }
$access_security = 0;

if(isset($_SESSION['SESS_USERNAME'])){
    $access_security = $_SESSION['SESS_ACCESS'];

    // Retrieve session ariables
    $username = $_SESSION['SESS_USERNAME'];
    $password = $_SESSION['SESS_PASSWORD'];
}


