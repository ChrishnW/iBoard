<?php
include 'connect.php';

if (isset($_POST['login'])) :
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

  // Check in users table
  $query = "SELECT * FROM tbl_accounts WHERE username = '$username'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    if (password_verify($password, $user['password'])) {
      session_start();
      $_SESSION['SESS_USERNAME']    = $username;
      $_SESSION['SESS_PASSWORD']    = $password;
      session_write_close();    
      echo "Success";
    } else {
      echo "Incorrect password.";
    }
  } else {
    echo "Username not found.";
  }
  mysqli_close($conn);
endif;