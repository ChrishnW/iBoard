<?php
include 'connect.php';
session_start();

function check_depeartment($username, $password){
  global $conn;

  $query = "SELECT * FROM tbl_department WHERE dept_name = '$username'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    $dept = mysqli_fetch_assoc($result);
    if (password_verify($password, $dept['password'])) {

      $_SESSION['department_code'] = $dept['dept_code'];
      $_SESSION['SESS_USERNAME']    = $username;
      $_SESSION['SESS_PASSWORD']    = $password;
      $_SESSION['SESS_ACCESS'] = "3";
      echo "Monitor";

    }
    else {
      echo "Incorrect password.";
    }
  } 
  else {
    echo "Username not found.";
  }


}

if (isset($_POST['login'])) :
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

  // Check in users table
  $query = "SELECT * FROM tbl_accounts WHERE username = '$username'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    if (password_verify($password, $user['password'])) {

      $_SESSION['user_id'] = $user['id'];
      $_SESSION['SESS_USERNAME']    = $username;
      $_SESSION['SESS_PASSWORD']    = $password;
      $_SESSION['SESS_ACCESS']    = $user['access'];
    
      if($user['access'] == "1"){
        echo "Admin";
      }
      elseif ($user['access'] == "2"){
        echo "User";
      }

    } 
    else {
      check_depeartment($username, $password);
    }
  } 
  else {
    check_depeartment($username, $password);
  }
  mysqli_close($conn);
endif;