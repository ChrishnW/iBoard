<?php include 'auth.php'; 

  if(!$access_security){
    header('location: ../index.php');
    exit();
  }
  else{

    if($access_security != 1){
      header('location: ../index.php');
      exit();
    }
  }
  
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>i-Board | <?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?></title>

  <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/logo.png">
  <link href="../assets/css/style2.css" rel="stylesheet">

  <?php include 'link.php'; ?>

</head>

<body id="page-top">

  <div id="wrapper">

    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <!-- LOGO HERE -->
        </div>
        <div class="sidebar-brand-text mx-3">i-Board</div>
      </a>

      <hr class="sidebar-divider my-0">

      <li class="nav-item">
        <a class="nav-link" href="../pages/dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="../pages/department.php">
          <i class="far fa-building"></i>
          <span>Manage Department</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../pages/account.php">
        <i class="fa fa-user" aria-hidden="true"></i>
          <span>Manage Account</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../pages/breaktime.php">
        <i class="fa fa-coffee" aria-hidden="true"></i>
          <span>Manage Breaktime</span></a>
      </li>

      <!-- <hr class="sidebar-divider">

      <div class="sidebar-heading">
        Components
      </div>

      <li class="nav-item">
        <a class="nav-link" href="assets.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Asset</span></a>
      </li> -->

      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>

    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                <img class="img-profile rounded-circle" src="../assets/img/user.png">
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#popoutLogout">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>