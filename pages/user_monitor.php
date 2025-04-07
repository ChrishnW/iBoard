<?php 
    include '../include/link.php'; 
    include '../include/auth.php';
    ob_start();

    if(!$access_security){
        header('location: ../index.php');
        exit();
    }
    else{

        if($access_security != 2){
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
    <div class="row align-items-center px-3 py-2">  
        <div class="col-12 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-md-left text-lg-left text-center">
          <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid rounded logo pb-2" style="width: 100%; max-width: 88px; height: auto;">
        </div>

        <div class="col-12 col-sm text-md-left text-lg-left text-center">
          <span class="h1 font-weight-bold text-primary" id="line_name"><?php echo isset($row_line["line_name"]) ? $row_line["line_name"] : "-----" ?></span>
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
</body>

<script>

    function refreshPage() {
        window.location.reload();
    }

    document.addEventListener("DOMContentLoaded", function() {
        setInterval(refreshPage, 10000); 
    });

</script>