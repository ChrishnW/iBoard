<?php 
    include '../include/link.php'; 
    include '../include/auth.php';
    ob_start();

    if(!$access_security){
        header('location: ../index.php');
        exit();
    }
    else{

        if($access_security != 4){
            header('location: ../index.php');
            exit();
        }
    }

    // Fetching username ....................................................

    $user_id = $_SESSION['user_id'];
    $result = mysqli_query($conn, "SELECT * FROM tbl_accounts WHERE id = '$user_id' ");

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $_SESSION["username"] = $user['username'];
    }

    // PHP Vanilla ----------------------------------------------------------------------
    $date = date("Y-m-d");
    $username = $_SESSION["username"];
    $model_id = $_SESSION["user_id"];

    $result = mysqli_query($conn, "SELECT * FROM tbl_line WHERE model_id = '$model_id' ");
    $row_line = mysqli_fetch_assoc($result);

    if(!empty($row_line["id"])){
        $line_name = $row_line["line_name"];

        $result1 = mysqli_query($conn, "SELECT * FROM tbl_records WHERE date = '$date' AND model = '$username' AND unit = '$line_name'");
        $row_records = mysqli_fetch_assoc($result1);
    }

  
?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>i-Board | <?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?></title>

  <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/logo.png">
  <link href="../assets/css/style2.css" rel="stylesheet">
</head>

<!-- Begin Page Content -->
<body class="container-fluid px-4 pt-3 pb-4 m-0" style="background-color: #add8e6;">
  <div id="user_dashboard" class="user_dashboard container-fluid rounded py-1">
    <!-- Header Section -->
    <div class="row align-items-center px-3 py-3">  
      <div class="col-12 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-md-left text-lg-left text-center">
        <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid rounded logo" style="width: 100%; max-width: 88px; height: auto;">
      </div>

      <div class="col-12 col-sm text-md-left text-lg-left text-center">
        <span class="h1 font-weight-bold text-primary" id="line_name"><?php echo isset($row_line["line_name"]) ? $row_line["line_name"] : "-----" ?></span>
      </div>
      
      <div class="col-12 col-sm-auto text-center mt-3 mt-sm-0">
        <div id="settings" class="dropdown">
          <button class="fa fa-cog fa-2x" aria-hidden="true" style="background-color: transparent; border: none;" data-toggle="dropdown"></button>
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#popoutLogout">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Details Section -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="">
                        <div class="card-body">
                            <div class="text-center">
                                <div id="line_image_div">
                                    <img src="<?php echo isset($row_line["line_img"]) ? $row_line["line_img"] : "../assets/img/img_not_available.png" ?>" alt="Photo not available" class="img-fluid border rounded" style="max-width: auto; height: 210px; object-fit: contain;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="d-flex flex-column fs-1"><br>
                                <span class="h2 text-danger"><u>Information</u></span> 
                                    <span class="h2 text-dark" id="line_desc"><?php echo isset($row_line["line_desc"]) ? $row_line["line_desc"] : "-----" ?></span>
                                    <span class="h2 text-danger"><u>Leader</u></span> 
                                    <span class="h2 text-dark" id="incharge_name"><?php echo isset($row_line["incharge_name"]) ? $row_line["incharge_name"] : "-----" ?></span> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="">
                        <div class="card-body">
                            <div class="text-center">
                                <div id="incharge_image_div">
                                    <img src="<?php echo isset($row_line["incharge_img"]) ? $row_line["incharge_img"] : "../assets/img/img_not_available.png" ?>" alt="Photo not available" class="img-fluid border rounded" style="max-width: auto; height: 210px; object-fit: contain;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Tables Section -->
    <div class="card-body">
      <div class="table-responsive bg-white rounded shadow">
        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
          <thead class="bg-primary text-white">
            <tr>
            <th class="align-text-top">DAILY TARGET</th>
            <th class="align-text-top">TARGET (NOW)</th>
            <th class="align-text-top">ACTUAL</th>
            <th class="align-text-top">BALANCE</th>
            </tr>
          </thead>

          <tbody class="bg-white text-dark h4">
            <tr style="height: 175px;"> <!-- Adjust height here -->
              <td class="font-weight-bolder" style="font-size: 60px;"><?php echo isset($row_line["daily_target"]) ? $row_line["daily_target"] : 0 ?></td>
              <td class="font-weight-bolder" style="font-size: 60px;"><?php echo isset($row_records["target_now"]) ? $row_records["target_now"] : 0  ?></td>  
              <td class="font-weight-bolder" style="font-size: 60px;"><?php echo isset($row_records["actual"]) ? $row_records["actual"] : 0  ?></td>
              <td class="font-weight-bolder text-danger" style="font-size: 60px;"><?php echo isset($row_records["balance"]) ? $row_records["balance"] : 0 ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>


  <!-- Log out Pop up Modal -->
  <div class="modal" tabindex="-1" id="popoutLogout" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-gradient-danger">
          <h5 class="modal-title text-white">Logout Account Confirmation</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" id="close_popup2">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body mt-2 mb-1">
            <p class="h5">Are you sure you want to log out?</p>
        </div>

        <div class="modal-footer">
          <!-- Confirm button triggers JavaScript logout logic -->
          <button onclick="handleLogout()" class="btn btn-danger">Logout</button>
          <a href="#" onclick="closePopupLogout()" class="btn btn-secondary" style="text-decoration: none;">Cancel</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Include jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

<script>
  function handleLogout() {
    window.location.href = '../include/logout.php';
  }

  function closePopupLogout() {
    const modal = document.getElementById("popoutLogout");
    modal.style.display = "none";

    const modalBackdrops = document.getElementsByClassName("modal-backdrop");
    while (modalBackdrops.length > 0) {
    modalBackdrops[0].parentNode.removeChild(modalBackdrops[0]);
    }
  }

  function refreshPage() {
    window.location.reload();
  }

  document.addEventListener("DOMContentLoaded", function() {
    setInterval(refreshPage, 10000); 
  });
</script>