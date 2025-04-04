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

    $user_id = $_SESSION['user_id'];
    $result = mysqli_query($conn, "SELECT * FROM tbl_accounts WHERE id = '$user_id' ");

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $user_name = $user['username'];
        $_SESSION["username"] = $user['username'];
        
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
        // Register Line Details ---------------------------------------------------------------------------

        if(isset($_POST['edit_line_submit'])){

            $line_desc = FILTER_INPUT(INPUT_POST, "edit_line_desc", FILTER_SANITIZE_SPECIAL_CHARS);
            $line_leader = FILTER_INPUT(INPUT_POST, "edit_line_leader", FILTER_SANITIZE_SPECIAL_CHARS);

            $daily_target = FILTER_INPUT(INPUT_POST, "edit_daily_target", FILTER_SANITIZE_NUMBER_INT);
            $target_now = FILTER_INPUT(INPUT_POST, "edit_target_now", FILTER_SANITIZE_NUMBER_INT);

            $takt_time = FILTER_INPUT(INPUT_POST, "edit_takt_time", FILTER_SANITIZE_NUMBER_INT);

            $work_start = $_POST["edit_work_start"];
            $work_end = $_POST["edit_work_end"];

            $breaktime_code = FILTER_INPUT(INPUT_POST, "edit_breaktime_code", FILTER_SANITIZE_SPECIAL_CHARS);
            $status = FILTER_INPUT(INPUT_POST, "edit_status", FILTER_SANITIZE_SPECIAL_CHARS);

            $line_name = $_SESSION["username"];
            $model_id = $_SESSION["user_id"];

            //print_r($_FILES);

            if(isset($_FILES['line_image_upload']) && $_FILES['line_image_upload']['error'] == 0 && isset($_FILES['leader_image_upload']) && $_FILES['leader_image_upload']['error'] == 0){

                $date = date("Y-m-d H:i:s");
                $result = mysqli_query($conn, "INSERT INTO tbl_line (line_name, line_desc, line_img, incharge_name, incharge_img, daily_target, takt_time, work_time_from, work_time_to, breaktime_code, model_id, status) VALUES ('$line_name', '$line_desc', '$date', '$line_leader', '$date', '$daily_target', '$takt_time', '$work_start', '$work_end', '$breaktime_code', '$model_id', '$status')");

                // This is for the records table

                $date_records = date("Y-m-d");
                $status_records = "RUN";
                $value_records = 0;

                $gapInSeconds = strtotime($work_end) - strtotime($work_start);
                $gapInMinutes = $gapInSeconds / 60;
                $quantity = 0;

                if($gapInMinutes >= 660){
                    // Run if there is OT

                    $worked_hours = $gapInMinutes - 105;
                    $quantity_round = $worked_hours / $takt_time;

                    $quantity = round($quantity_round);
                    
                }
                else{
                    // Run if there is no OT

                    $worked_hours = $gapInMinutes - 90;
                    $quantity_round = $worked_hours / $takt_time;

                    $quantity = round($quantity_round);

                }

                $result = mysqli_query($conn, "INSERT INTO tbl_records (date, model, unit, status, target_day, target_now, actual, balance) VALUES ('$date_records', '$line_name', '$line_desc', '$status_records','$daily_target', '$quantity', '$value_records', '$quantity')");

                if($result){

                    $result = mysqli_query($conn, "SELECT id FROM tbl_line WHERE line_img = '$date' ");

                    $line = mysqli_fetch_assoc($result);
                    $line_id = $line["id"];

                    $img_name_raw_line = $_FILES["line_image_upload"]["name"];
                    $img_name_line = str_replace(" ", "_", $img_name_raw_line);
                    $img_line_path = "IMG/LINE/" . $img_name_line;
                    $img_temp_path_line = $_FILES["line_image_upload"]["tmp_name"];

                    move_uploaded_file($img_temp_path_line, $img_line_path);

                    $img_name_raw_leader = $_FILES["leader_image_upload"]["name"];
                    $img_name_leader = str_replace(" ", "_", $img_name_raw_leader);
                    $img_leader_path = "IMG/INCHARGE/" . $img_name_leader;
                    $img_temp_path_leader = $_FILES["leader_image_upload"]["tmp_name"];

                    move_uploaded_file($img_temp_path_leader, $img_leader_path);

                    if(isset($_FILES['extra_view_upload']) && $_FILES['extra_view_upload']['error'] == 0){

                        $img_name_raw_extra = $_FILES["extra_view_upload"]["name"];
                        $img_name_extra = str_replace(" ", "_", $img_name_raw_extra);
                        $img_extra_path = "IMG/EXTRA_VIEW/" . $img_name_extra;
                        $img_temp_path_extra = $_FILES["extra_view_upload"]["tmp_name"];

                        move_uploaded_file($img_temp_path_extra, $img_extra_path);
                                        
                        mysqli_query($conn, "UPDATE tbl_line SET line_img = '$img_line_path', incharge_img = '$img_leader_path', extra_view = '$img_extra_path' WHERE id = '$line_id' ");


                    }else{
                        
                        mysqli_query($conn, "UPDATE tbl_line SET line_img = '$img_line_path', incharge_img = '$img_leader_path' WHERE id = '$line_id' ");
                    }
                } 
            }

            header("Refresh: .3; url = test.php");
            exit;
            ob_end_flush();
        }

        // Edit Registeed Line Details ---------------------------------------------------------------------------

        if(isset($_POST['reedit_line_submit'])){

            // echo "<script>alert('asd');</script>";
            $line_id = $_SESSION["line_id"];
            $records_id = $_SESSION["records_id"];

            $line_desc = FILTER_INPUT(INPUT_POST, "edit_line_desc", FILTER_SANITIZE_SPECIAL_CHARS);
            $line_leader = FILTER_INPUT(INPUT_POST, "edit_line_leader", FILTER_SANITIZE_SPECIAL_CHARS);

            $daily_target = FILTER_INPUT(INPUT_POST, "edit_daily_target", FILTER_SANITIZE_NUMBER_INT);
            $target_now = FILTER_INPUT(INPUT_POST, "edit_target_now", FILTER_SANITIZE_NUMBER_INT);

            $takt_time = FILTER_INPUT(INPUT_POST, "edit_takt_time", FILTER_SANITIZE_NUMBER_INT);

            $work_start = $_POST["edit_work_start"];
            $work_end = $_POST["edit_work_end"];

            $breaktime_code = FILTER_INPUT(INPUT_POST, "edit_breaktime_code", FILTER_SANITIZE_SPECIAL_CHARS);
            $status = FILTER_INPUT(INPUT_POST, "edit_status", FILTER_SANITIZE_SPECIAL_CHARS);

            $line_name = $_SESSION["username"];
            $model_id = $_SESSION["user_id"];

            //print_r($_FILES);

            if(isset($_FILES['line_image_upload']) && $_FILES['line_image_upload']['error'] == 0 && isset($_FILES['leader_image_upload']) && $_FILES['leader_image_upload']['error'] == 0){

                $date = date("Y-m-d H:i:s");
                $result = mysqli_query($conn, "UPDATE tbl_line SET line_name = '$line_name', line_desc = '$line_desc',incharge_name = '$line_leader', daily_target = '$daily_target', takt_time '$takt_time', work_time_from = '$work_start', work_time_to = '$work_end', breaktime_code '$breaktime_code', model_id = '$model_id', status = '$status' WHERE id = '$line_id' ");

                // This is for the records table

                $date_records = date("Y-m-d");
                $status_records = "RUN";

                $gapInSeconds = strtotime($work_end) - strtotime($work_start);
                $gapInMinutes = $gapInSeconds / 60;
                $quantity = 0;

                if($gapInMinutes >= 660){
                    // Run if there is OT

                    $worked_hours = $gapInMinutes - 105;
                    $quantity_round = $worked_hours / $takt_time;

                    $quantity = round($quantity_round);
                    
                }
                else{
                    // Run if there is no OT

                    $worked_hours = $gapInMinutes - 90;
                    $quantity_round = $worked_hours / $takt_time;

                    $quantity = round($quantity_round);

                }

                $result = mysqli_query($conn, "UPDATE tbl_records SET date = '$date_records', model = '$line_name', unit = '$line_desc', status = '$status_records', target_day = '$daily_target', target_now = '$quantity', balance = '$quantity' WHERE id = '$records_id' ");

                if($result){

                    $img_name_raw_line = $_FILES["line_image_upload"]["name"];
                    $img_name_line = str_replace(" ", "_", $img_name_raw_line);
                    $img_line_path = "IMG/LINE/" . $img_name_line;
                    $img_temp_path_line = $_FILES["line_image_upload"]["tmp_name"];

                    move_uploaded_file($img_temp_path_line, $img_line_path);

                    $img_name_raw_leader = $_FILES["leader_image_upload"]["name"];
                    $img_name_leader = str_replace(" ", "_", $img_name_raw_leader);
                    $img_leader_path = "IMG/INCHARGE/" . $img_name_leader;
                    $img_temp_path_leader = $_FILES["leader_image_upload"]["tmp_name"];

                    move_uploaded_file($img_temp_path_leader, $img_leader_path);

                    if(isset($_FILES['extra_view_upload']) && $_FILES['extra_view_upload']['error'] == 0){

                        $img_name_raw_extra = $_FILES["extra_view_upload"]["name"];
                        $img_name_extra = str_replace(" ", "_", $img_name_raw_extra);
                        $img_extra_path = "IMG/EXTRA_VIEW/" . $img_name_extra;
                        $img_temp_path_extra = $_FILES["extra_view_upload"]["tmp_name"];

                        move_uploaded_file($img_temp_path_extra, $img_extra_path);
                                        
                        mysqli_query($conn, "UPDATE tbl_line SET line_img = '$img_line_path', incharge_img = '$img_leader_path', extra_view = '$img_extra_path' WHERE id = '$line_id' ");

                    }else{
                        
                        mysqli_query($conn, "UPDATE tbl_line SET line_img = '$img_line_path', incharge_img = '$img_leader_path' WHERE id = '$line_id' ");
                        
                    }

                } 

            }

            header("Refresh: .3; url = test.php");            
            exit;
            ob_end_flush();

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
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../vendor/snapappointments/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style2.css?v=1">
</head>
<body class="container-fluid px-4 pt-3 pb-4 m-0" style="background-color: #add8e6;" id="body">
    
    <!-- User Dashboard-->

    <div id="user_dashboard" class="user_dashboard" style="display: block; background-color: none; border-radius: 10px; padding-top: 5px;">
        <!-- Header Section -->
        <div class="d-flex align-items-center px-3 py-2">  
            <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid mr-3 border" style="width: 80px; border-radius: 10%;">
            <span class="h1 font-weight-bold mb-0 text-primary" id="line_name"><?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : "-----" ?></span>
            
            <div class="ml-auto d-flex justify-content-center align-items-center mr-5 pr-4">
                <div class="text-center">
                    <button id="runStopButton" onclick="handleRunStop()" class="display-4 font-weight-bold mb-2 text-white btn" style="background-color: blue; border: none; font-size: 50px;">RUN</button> 
                    <br>
                    <span class="h3 font-weight-bold mb-0 text-danger" id="timer">00:00:00:000</span>
                </div>
            </div>

            <div id="settings" class="dropdown">
                <button class="fa fa-cog fa-2x" aria-hidden="true" style="background-color: transparent; border: none;" data-toggle="dropdown"></button>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#" onclick="showEdituser()">
                        <i class="fa fa-cogs fa-sm fa-fw mr-2 text-gray-400" aria-hidden="true"></i>    
                        Settings
                    </a>

                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#popoutLogout">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </div>

        </div>

        <?php 
            $date = date("Y-m-d");
            $username = $_SESSION["username"];
        
            $result = mysqli_query($conn, "SELECT * FROM tbl_line WHERE line_name = '$username'");
            $row_line = mysqli_fetch_assoc($result);

            if(!empty($row_line["line_name"])){

                $_SESSION["line_id"] = $row_line["id"];
                $line_name = $row_line["line_name"];
                $line_desc = $row_line["line_desc"];
                $line_breaktime_code = $row_line["breaktime_code"];
                $work_start = $row_line["work_time_from"];
                $work_end = $row_line["work_time_to"];

                // echo $date;
                // echo $line_name;
                // echo $line_desc;

                $result1 = mysqli_query($conn, "SELECT * FROM tbl_records WHERE date = '$date' AND model = '$line_name' AND unit = '$line_desc'");
                $row_records = mysqli_fetch_assoc($result1);

                if(!empty($row_records["id"])){
                    $_SESSION["records_id"] = $row_records["id"];
                }
                else{

                    $gapInSeconds = strtotime($work_end) - strtotime($work_start);
                    $gapInMinutes = $gapInSeconds / 60;
                    $quantity = 0;

                    if($gapInMinutes >= 660){
                        // Run if there is OT

                        $worked_hours = $gapInMinutes - 105;
                        $quantity_round = $worked_hours / $takt_time;

                        $quantity = round($quantity_round);
                        
                    }
                    else{
                        // Run if there is no OT

                        $worked_hours = $gapInMinutes - 90;
                        $quantity_round = $worked_hours / $takt_time;

                        $quantity = round($quantity_round);

                    }

                    $actual = 0;
                    $status = "RUN";

                    $sql_command = "INSERT INTO tbl_records (date, model, unit, status, 
                            target_day, target_now, actual, balance) VALUES 
                            ('$date', '$line_name', '$line_desc', '$status',
                            '$daily_target', '$quantity', '$actual', '$quantity')";

                    $result = mysqli_query($conn, $sql_command);
                }

                $result2 = mysqli_query($conn, "SELECT * FROM tbl_breaktime WHERE breaktime_code = '$line_breaktime_code' ");
                $row_break = mysqli_fetch_assoc($result2);
                    
            }

        ?>

        <div class="card">
            <div class="card-body">   
                <div class="row" id="dashboad_insert">
                    <div class="col-md-4">
                        <div class="card shadow h-100">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="d-flex" id="line_image_div">
                                        <img src="<?php echo isset($row_line["line_img"]) ? $row_line["line_img"] : '../assets/img/img_not_available.png' ?>" alt="Image not available" class="img-fluid w-100 h-100" style="border-radius: 10px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="card shadow h-100">
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
                        <div class="card shadow h-100">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="ml-auto align-self-end" id="incharge_image_div">
                                        <img src="<?php echo isset($row_line["incharge_img"]) ? $row_line["incharge_img"] : '../assets/img/img_not_available.png' ?>" alt="Image not available" class="img-fluid w-100 h-100" style="border-radius: 10px;">
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
            <div class="bg-white" style="border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="border-radius: 10px; overflow: hidden;">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th class="align-text-top">DAILY TARGET</th>
                            <th class="align-text-top">TARGET (NOW)</th>
                            <th class="align-text-top">ACTUAL</th>
                            <th class="align-text-top">BALANCE</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white text-center text-dark h4">
                
                    <tr style="height: 175px;"> 
                        <td class="font-weight-bolder" style="font-size: 50px;" id="daily_target_display"><?php echo isset($row_records["target_day"]) ? $row_records["target_day"] : 0 ?></td>
                        <td id="target_count" class="font-weight-bolder" style="font-size: 50px;"><?php echo isset($row_records["target_now"]) ? $row_records["target_now"] : 0 ?></td>
                        <td class="position-relative" style="height: 160px;">
                            <p id="actual_count" class="font-weight-bolder mt-1 mb-n3 pb-3" style="font-size: 50px; text-align: center;"><?php echo isset($row_records["actual"]) ? $row_records["actual"] : 0 ?></p>
                            <div class="position-absolute w-100 d-flex justify-content-between" style="top: 85%; transform: translateY(-70%);"> 
                                <button class="btn btn-primary btn-lg ml-1 mt-2" style="display: <?php echo isset($row_records["actual"]) ? "block" : "none" ?>;" onclick="minus()" id="minus">-</button>
                                <button class="btn btn-primary btn-lg mr-4 mt-2" style="display: <?php echo isset($row_records["actual"]) ? "block" : "none" ?>;" onclick="add()" id="plus">+</button>
                            </div>
                        </td>
                        <td class="font-weight-bold mb-2 text-danger font-weight-bolder" style="font-size: 50px;" id="balance_count"><?php echo isset($row_records["balance"]) ? $row_records["balance"] : 0 ?></td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- EDIT USER -->
    <div id="edit_user" class="edit_user" style="display: none;">
        <div class="card shadow mb-4">

            <div class="card-header py-3.5 pt-4">
                <h2 class="float-left">Edit Line Details</h2>        
            </div>
            
            <div class="card-body shadow-sm m-4 p-4">
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data" style="width: 100%;" id="edit_user_form">
                    <div class="row">

                    <div class="col-md-6">
                            <!-- Line Details -->
                            <div class="mb-3">
                                <label for="edit_line_desc" class="form-label">Line Description <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="edit_line_desc" id="edit_line_desc" value="<?php echo isset($row_line["line_desc"]) ? $row_line["line_desc"] : "" ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="line_image_upload" class="form-label">Line Image <span class="text-danger">*</span></label>
                                <input type="file" accept=".png, .jpg, .jpeg" class="form-control" name="line_image_upload" id="line_image_upload" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_daily_target" class="form-label">Daily Target <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="edit_daily_target" id="edit_daily_target" value="<?php echo isset($row_line["daily_target"]) ? $row_line["daily_target"] : "" ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_work_start" class="form-label">Work Start <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="edit_work_start" id="edit_work_start" value="<?php echo isset($row_line["work_time_from"]) ? $row_line["work_time_from"] : "" ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_breaktime_code">Breaktime Code <span style="color: red;">*</span></label>
                                <select name="edit_breaktime_code" id="edit_breaktime_code" class="form-control" required> 
                                    <option value="<?php echo isset($row_line["breaktime_code"]) ? $row_line["breaktime_code"] : "" ?>" hidden><?php echo isset($row_line["breaktime_code"]) ? $row_line["breaktime_code"] : "" ?></option>
                                </select> 
                            </div>
                           
                        </div>
                        
                        <div class="col-md-6">
                            <!-- Line Person -->
                            <div class="mb-3">
                                <label for="edit_line_leader" class="form-label">Line Leader <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="edit_line_leader" id="edit_line_leader" value="<?php echo isset($row_line["incharge_name"]) ? $row_line["incharge_name"] : "" ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="leader_image_upload" class="form-label">Line Leader Image <span class="text-danger">*</span></label>
                                <input type="file" accept=".png, .jpg, .jpeg" class="form-control" name="leader_image_upload" id="leader_image_upload" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_takt_time" class="form-label">Takt Time <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="edit_takt_time" id="edit_takt_time" value="<?php echo isset($row_line["takt_time"]) ? $row_line["takt_time"] : "" ?>" required>
                            </div> 

                            <div class="mb-3">
                                <label for="edit_work_end" class="form-label">Work End <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="edit_work_end" id="edit_work_end" value="<?php echo isset($row_line["work_time_to"]) ? $row_line["work_time_to"] : "" ?>" required>
                            </div>
 
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="edit_status" id="edit_status" class="form-control" required > 
                                    <option value="<?php echo isset($row_line["status"]) ? $row_line["status"] : 1 ?>" hidden><?php echo isset($row_line["status"]) ? ($row_line["status"] == 1 ? "Active" : "Inactive" ) : "Active" ?></option>

                                    
                                    <?php echo isset($row_line["status"]) ? "<option value=\"1\">Active</option>
                                    <option value=\"0\">Inactive</option>" : "" ?>

                                </select> 
                            </div>  
                        
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="extra_view_upload" class="form-label">Extra View</label>
                                <input type="file" accept=".png, .jpg, .jpeg" class="form-control" name="extra_view_upload" id="extra_view_upload">
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="d-flex justify-content-left">
                        <input type="submit" name="<?php echo isset($row_line["line_desc"]) ? "reedit_line_submit" : "edit_line_submit" ?>" class="btn btn-primary pr-3" value="Save">
                        <input type="reset" name="edit_line_cancel" class="btn btn-secondary ml-2" value="Cancel" id="edit_line_cancel">
                    </div>
                </form>
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
        
        <div class="modal-body">
            <p class="h6">Are you sure you want to log out? Once logged out, you will need to log in again to access your account.</p>
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
</html>

<?php

    // Fetching Breaktime ....................................................

    $sql_command = "SELECT * FROM tbl_breaktime WHERE status = '1' ";
    $result = mysqli_query($conn, $sql_command);

    if(mysqli_num_rows($result) > 0){
        while($break = mysqli_fetch_assoc($result)){

            $breaktime_id = $break['id'];
            $breaktime_code = $break['breaktime_code'];

            echo '<script> document.addEventListener("DOMContentLoaded", function () {
                const table = `
                <option value="' . $breaktime_code . '">' . $breaktime_code . '</option>`;
                
                document.querySelector("#edit_breaktime_code").insertAdjacentHTML("beforeend", table);
            });</script>';
        }

    }

?>
 
