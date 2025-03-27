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


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
        // Register Line Details ---------------------------------------------------------------------------

        if(isset($_POST['edit_line_submit'])){

            unset($_SESSION["line_id"]);

            $date1 = date("Y-m-d");

            $line_desc = FILTER_INPUT(INPUT_POST, "edit_line_desc", FILTER_SANITIZE_SPECIAL_CHARS);
            $line_leader = FILTER_INPUT(INPUT_POST, "edit_line_leader", FILTER_SANITIZE_SPECIAL_CHARS);

            $daily_target = FILTER_INPUT(INPUT_POST, "edit_daily_target", FILTER_SANITIZE_NUMBER_INT);
            $target_now = FILTER_INPUT(INPUT_POST, "edit_target_now", FILTER_SANITIZE_NUMBER_INT);

            $takt_time = FILTER_INPUT(INPUT_POST, "edit_takt_time", FILTER_SANITIZE_NUMBER_INT);
            $_SESSION["takt_time"] = $takt_time;

            $work_start = $_POST["edit_work_start"];
            $work_end = $_POST["edit_work_end"];

            $breaktime_code = FILTER_INPUT(INPUT_POST, "edit_breaktime_code", FILTER_SANITIZE_SPECIAL_CHARS);
            $status = FILTER_INPUT(INPUT_POST, "edit_status", FILTER_SANITIZE_SPECIAL_CHARS);

            $line_name = $_SESSION["username"];
            $model_id = $_SESSION["user_id"];

            //print_r($_FILES);

            if(isset($_FILES['line_image_upload']) && $_FILES['line_image_upload']['error'] == 0 &&
                isset($_FILES['leader_image_upload']) && $_FILES['leader_image_upload']['error'] == 0){

                $date = date("Y-m-d H:i:s");

                $sql_command = "INSERT INTO tbl_line (date, line_name, line_desc, line_img, incharge_name, 
                                incharge_img, daily_target, takt_time, work_time_from, work_time_to, 
                                breaktime_code, model_id, status) VALUES 
                                ('$date1', '$line_name', '$line_desc', '$date', '$line_leader', '$date', 
                                '$daily_target', '$takt_time', '$work_start', '$work_end',
                                '$breaktime_code', '$model_id', '$status')";

                $result = mysqli_query($conn, $sql_command);

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

                $sql_command = "INSERT INTO tbl_records (date, model, unit, status, 
                                target_day, target_now, actual, balance) VALUES 
                                ('$date_records', '$line_name', '$line_desc', '$status_records',
                                '$daily_target', '$quantity', '$value_records', '$quantity')";

                $result = mysqli_query($conn, $sql_command);

                if($result){

                    $sql_command = "SELECT id FROM tbl_line WHERE line_img = '$date' ";
                    $result = mysqli_query($conn, $sql_command);

                    $line = mysqli_fetch_assoc($result);
                    $line_id = $line["id"];

                    $_SESSION["line_id"] = $line_id;

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
                                        
                        mysqli_query($conn, "UPDATE tbl_line SET line_img = '$img_line_path',
                                            incharge_img = '$img_leader_path', extra_view = '$img_extra_path' 
                                            WHERE id = '$line_id' ");

                        $_SESSION["img_extra_path"] = $img_extra_path;

                    }else{
                        
                        mysqli_query($conn, "UPDATE tbl_line SET line_img = '$img_line_path',
                                            incharge_img = '$img_leader_path' WHERE id = '$line_id' ");
                    }

                } 

            }

            header("Refresh: .3; url = user.php");
            exit;
            ob_end_flush();

        }

        // Edit Registeed Line Details ---------------------------------------------------------------------------

        if(isset($_POST['reedit_line_submit'])){

            $line_id = $_SESSION["line_id"];
            $records_id = $_SESSION["records_id"];

            $line_desc = FILTER_INPUT(INPUT_POST, "edit_line_desc", FILTER_SANITIZE_SPECIAL_CHARS);
            $line_leader = FILTER_INPUT(INPUT_POST, "edit_line_leader", FILTER_SANITIZE_SPECIAL_CHARS);

            $daily_target = FILTER_INPUT(INPUT_POST, "edit_daily_target", FILTER_SANITIZE_NUMBER_INT);
            $target_now = FILTER_INPUT(INPUT_POST, "edit_target_now", FILTER_SANITIZE_NUMBER_INT);

            $takt_time = FILTER_INPUT(INPUT_POST, "edit_takt_time", FILTER_SANITIZE_NUMBER_INT);
            $_SESSION["takt_time"] = $takt_time;

            $work_start = $_POST["edit_work_start"];
            $work_end = $_POST["edit_work_end"];

            $breaktime_code = FILTER_INPUT(INPUT_POST, "edit_breaktime_code", FILTER_SANITIZE_SPECIAL_CHARS);
            $status = FILTER_INPUT(INPUT_POST, "edit_status", FILTER_SANITIZE_SPECIAL_CHARS);

            $line_name = $_SESSION["username"];
            $model_id = $_SESSION["user_id"];

            //print_r($_FILES);

            if(isset($_FILES['line_image_upload']) && $_FILES['line_image_upload']['error'] == 0 &&
                isset($_FILES['leader_image_upload']) && $_FILES['leader_image_upload']['error'] == 0){

                $date = date("Y-m-d H:i:s");

                $sql_command = "UPDATE tbl_line SET line_name = '$line_name', line_desc = '$line_desc',
                                incharge_name = '$line_leader', daily_target = '$daily_target', takt_time = '$takt_time',
                                work_time_from = '$work_start', work_time_to = '$work_end', breaktime_code = '$breaktime_code', 
                                model_id = '$model_id', status = '$status' WHERE id = '$line_id' ";

                $result = mysqli_query($conn, $sql_command);

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

                $sql_command = "UPDATE tbl_records SET date = '$date_records', model = '$line_name', 
                                unit = '$line_desc', status = '$status_records', target_day = '$daily_target', 
                                target_now = '$quantity', actual = '$value_records', balance = '$quantity' 
                                WHERE id = '$records_id' ";

                $result = mysqli_query($conn, $sql_command);

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
                                        
                        mysqli_query($conn, "UPDATE tbl_line SET line_img = '$img_line_path',
                                            incharge_img = '$img_leader_path', extra_view = '$img_extra_path' 
                                            WHERE id = '$line_id' ");

                        $_SESSION["img_extra_path"] = $img_extra_path;

                    }else{
                        
                        mysqli_query($conn, "UPDATE tbl_line SET line_img = '$img_line_path',
                                            incharge_img = '$img_leader_path' WHERE id = '$line_id' ");
                        
                    }

                } 

            }

            header("Refresh: .3; url = user.php");            
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
    <link rel="stylesheet" href="../assets/css/style2.css">
</head>
<body class="container-fluid p-4 m-0" style="background-color: #add8e6;" id="body">
    
    <!-- User Dashboard-->

    <div id="user_dashboard" class="user_dashboard" style="display: block;">
        <!-- Header Section -->
        <div class="d-flex align-items-center px-3 py-2 shadow-lg">  
            <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid mr-3 border" style="width: 100px;">
            <span class="h1 font-weight-bold mb-0 text-primary" id="line_name">-----</span>
            
            <div class="ml-auto d-flex justify-content-center align-items-center mr-5 pr-4">
                <div class="text-center">
                    <button id="runStopButton" onclick="handleRunStop()" class="display-4 font-weight-bold mb-2 text-dark" style="background-color: transparent; border: none;">RUN</button> 
                    <br>
                    <span class="h3 font-weight-bold mb-0 text-danger" id="timer">00:00:00:000</span>
                </div>
            </div>

            <div id="settings" class="dropdown">
                <button class="fa fa-cog fa-2x" aria-hidden="true" style="background-color: transparent; border: none;" data-toggle="dropdown"></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" onclick="showEdituser()">Settings</a>
                    <a class="dropdown-item" href="../include/logout.php">Logout</a>
                </div>
            </div>

        </div>

        <!-- Details Section -->
        <div id="details" class="d-flex align-items-start my-3 px-5 py-3 mr-4">

            <div id="line_image_div">
                <img src="../assets/img/img_not_available_landscape.png" alt="line" class="img-fluid mr-3 border" style="width: 380px; height: 210px;">
            </div>

            <div class="d-flex flex-column pl-5 fs-1"><br>
                <span class="h2 text-danger "><u>Information</u></span> 
                <span class="h2 text-dark" id="line_desc">-----</span>
                <span class="h2 text-danger"><u>Leader</u></span> 
                <span class="h2 text-dark" id="incharge_name">-----</span> 
            </div>

            <div class="ml-auto align-self-end" id="incharge_image_div">
                <img src="../assets/img/img_not_available.png" alt="" class="mr-5" style="width: 200px; height: 200px;">
            </div>
        </div>

        <!-- Tables Section -->
        <div class="card-body">
            <div class="bg-white">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th class="align-text-top">DAILY TARGET</th>
                            <th class="align-text-top">TARGET (NOW)</th>
                            <th class="align-text-top">ACTUAL</th>
                            <th class="align-text-top">BALANCE</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white text-center text-dark h4">
                        <tr>
                            <td class="font-weight-bolder" style="font-size: 50px;" id="daily_target_display">0</td>
                            <td id="target_count" class="font-weight-bolder" style="font-size: 50px;">0</td>
                            <td>
                                <p id="actual_count" class="font-weight-bolder mt-5 mb-0 pb-3"style="font-size: 50px;">0</p>
                                <div class="d-flex justify-content-between mt-1">
                                    <button class="btn btn-primary btn-lg" onclick="minus()" style="display: none;" id="minus">-</button>
                                    <button class="btn btn-primary btn-lg" onclick="add()" style="display: none;" id="plus">+</button>
                                </div>
                            </td>
                            <td class="font-weight-bold mb-2 text-danger font-weight-bolder "style="font-size: 50px;" id="balance_count">0</td>        
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
                                <input type="text" class="form-control" name="edit_line_desc" id="edit_line_desc" required>
                            </div>
                            <div class="mb-3">
                                <label for="line_image_upload" class="form-label">Line Image <span class="text-danger">*</span></label>
                                <input type="file" accept=".png, .jpg, .jpeg" class="form-control" name="line_image_upload" id="line_image_upload" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_daily_target" class="form-label">Daily Target <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="edit_daily_target" id="edit_daily_target" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_work_start" class="form-label">Work Start <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="edit_work_start" id="edit_work_start" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_breaktime_code">Breaktime Code <span style="color: red;">*</span></label>
                                <select name="edit_breaktime_code" id="edit_breaktime_code" class="form-control" required> 
                                    <option value="" hidden></option>
                                </select> 
                            </div>
                           
                        </div>
                        
                        <div class="col-md-6">
                            <!-- Line Person -->
                            <div class="mb-3">
                                <label for="edit_line_leader" class="form-label">Line Leader <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="edit_line_leader" id="edit_line_leader" required>
                            </div>

                            <div class="mb-3">
                                <label for="leader_image_upload" class="form-label">Line Leader Image <span class="text-danger">*</span></label>
                                <input type="file" accept=".png, .jpg, .jpeg" class="form-control" name="leader_image_upload" id="leader_image_upload" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_takt_time" class="form-label">Takt Time <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="edit_takt_time" id="edit_takt_time" required>
                            </div> 

                            <div class="mb-3">
                                <label for="edit_work_end" class="form-label">Work End <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="edit_work_end" id="edit_work_end" required>
                            </div>
 
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status</label>
                                <select name="edit_status" id="edit_status" class="form-control" required > 
                                    <option value="1" hidden>Active</option>
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
                        <input type="submit" name="edit_line_submit" class="btn btn-primary pr-3" value="Save">
                        <input type="reset" name="edit_line_cancel" class="btn btn-secondary ml-2" value="Cancel" id="edit_line_cancel">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

        
</body>
</html>

<?php

    // Fetching username ....................................................

    $user_id = $_SESSION['user_id'];

    $sql_command = "SELECT * FROM tbl_accounts WHERE id = '$user_id' ";
    $result = mysqli_query($conn, $sql_command);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);

        $user_name = $user['username'];
        $_SESSION["username"] = $user['username'];
        
        echo " <script> document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('line_name').innerHTML = '$user_name';
        });</script>";
    }

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

    // Display Registered Data ---------------------------------------------------------------------------

    if(isset($_SESSION["line_id"])){

        $line_id = $_SESSION["line_id"];

        $sql_command = "SELECT * FROM tbl_line WHERE id = '$line_id' ";
        $result = mysqli_query($conn, $sql_command);

        if(mysqli_num_rows($result) > 0){
            $line = mysqli_fetch_assoc($result);

            $date = date("Y-m-d");
            $line_name = $line["line_name"];
            $line_desc = $line["line_desc"];

            $line_img = $line["line_img"];
            $incharge_name = $line["incharge_name"];
            $incharge_img = $line["incharge_img"];

            $work_start = $line["work_time_from"];
            $work_end = $line["work_time_to"];

            $daily_target = $line["daily_target"];

            $breaktime_code_get = $line["breaktime_code"];
            $takt_time = $line["takt_time"];

            $status = $line["status"];

            $status_string = "";
            if($status == 1){
                $status_string = "Active";
            }
            else{
                $status_string = "Inactive";
            }


            $sql_command = "SELECT * FROM tbl_records WHERE date = '$date' AND model = '$line_name' AND unit = '$line_desc' ";
            $result = mysqli_query($conn, $sql_command);

            if(mysqli_num_rows($result) > 0){
                $record = mysqli_fetch_assoc($result);

                $records_id = $record["id"];
                $_SESSION["records_id"] = $records_id;

                $target = $record["target_now"];
                $actual = $record["actual"];
                $balance = $record["balance"];
                
                echo "<script>
                document.addEventListener('DOMContentLoaded', function () {

                    document.getElementById('line_name').innerHTML = '$line_name'; 
                    document.getElementById('line_desc').innerHTML = '$line_desc';

                    document.getElementById('incharge_name').innerHTML = '$incharge_name'; 
                    document.getElementById('daily_target_display').innerHTML = '$daily_target';
                    
                    const line_img = '<img src=\"$line_img\" alt=\"LineImage\" class=\"img-fluid mr-3 border\" style=\"width: 380px; height: 210px; \" >';
                    document.getElementById('line_image_div').innerHTML = line_img; 
                    
                    const incharge_img = '<img src=\"$incharge_img\" alt=\"inchargeImage\" class=\"mr-5\" style=\"width: 200px; height: 200px;\">';
                    document.getElementById('incharge_image_div').innerHTML = incharge_img; 

                    document.getElementById('target_count').innerHTML = '$target'; 
                    document.getElementById('actual_count').innerHTML = '$actual';
                    document.getElementById('balance_count').innerHTML = '$balance';

                    document.getElementById('minus').style.display = 'block';
                    document.getElementById('plus').style.display = 'block';

                });
                </script>";


                $sql_command = "SELECT * FROM tbl_breaktime WHERE breaktime_code = '$breaktime_code_get' ";
                $result = mysqli_query($conn, $sql_command);

                if(mysqli_num_rows($result) > 0){
                    while($break = mysqli_fetch_assoc($result)){

                        $_SESSION['tool_start'] = $break["tool_box_meeting_start"];
                        $_SESSION['tool_end'] = $break["tool_box_meeting_end"];

                        $_SESSION['am_start'] = $break["am_break_start"];
                        $_SESSION['am_end'] = $break["am_break_end"];

                        $_SESSION['lunch_start'] = $break["lunch_break_start"];
                        $_SESSION['lunch_end'] = $break["lunch_break_end"];

                        $_SESSION['pm_start'] = $break["pm_break_start"];
                        $_SESSION['pm_end'] = $break["pm_break_end"];

                        $_SESSION['ot_start'] = $break["ot_break_start"];
                        $_SESSION['ot_end'] = $break["ot_break_end"];

                    }
                }

                echo "<script> 
                document.addEventListener('DOMContentLoaded', function () {

                    const table = `

                        <div class=\"row\">
                    
                            <div class=\"col-md-6\">
                                
                                <div class=\"mb-3\">
                                    <label for=\"edit_line_desc\" class=\"form-label\">Line Description <span class=\"text-danger\">*</span></label>
                                    <input type=\"text\" class=\"form-control\" name=\"edit_line_desc\" id=\"edit_line_desc\" required value=\"$line_desc\">
                                </div>
                                <div class=\"mb-3\">
                                    <label for=\"line_image_upload\" class=\"form-label\">Line Image <span class=\"text-danger\">*</span></label>
                                    <input type=\"file\" accept=\".png, .jpg, .jpeg\" class=\"form-control\" name=\"line_image_upload\" id=\"line_image_upload\" required value=\"$line_img\">
                                </div>
                                
                                <div class=\"mb-3\">
                                    <label for=\"edit_daily_target\" class=\"form-label\">Daily Target <span class=\"text-danger\">*</span></label>
                                    <input type=\"number\" class=\"form-control\" name=\"edit_daily_target\" id=\"edit_daily_target\" placeholder=\"100\" required value=\"$daily_target\">
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"edit_work_start\" class=\"form-label\">Work Start <span class=\"text-danger\">*</span></label>
                                    <input type=\"time\" class=\"form-control\" name=\"edit_work_start\" id=\"edit_work_start\" required value=\"$work_start\">
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"edit_breaktime_code\">Breaktime Code <span style=\"color: red;\">*</span></label>
                                    <select name=\"edit_breaktime_code\" id=\"edit_breaktime_code\" class=\"form-control\" required > 
                                        <option value=\"$breaktime_code_get\" hidden>$breaktime_code_get</option>
                                    </select> 
                                </div>
                            
                            </div>
                            
                            <div class=\"col-md-6\">
                                <!-- Line Person -->
                                <div class=\"mb-3\">
                                    <label for=\"edit_line_leader\" class=\"form-label\">Line Leader <span class=\"text-danger\">*</span></label>
                                    <input type=\"text\" class=\"form-control\" name=\"edit_line_leader\" id=\"edit_line_leader\" placeholder=\"Juan Dela Cruz\" required value=\"$incharge_name\">
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"leader_image_upload\" class=\"form-label\">Line Leader Image <span class=\"text-danger\">*</span></label>
                                    <input type=\"file\" accept=\".png, .jpg, .jpeg\" class=\"form-control\" name=\"leader_image_upload\" id=\"leader_image_upload\" required value=\"$incharge_img\">
                                </div>
                                
                                <div class=\"mb-3\">
                                    <label for=\"edit_takt_time\" class=\"form-label\">Takt Time <span class=\"text-danger\">*</span></label>
                                    <input type=\"number\" class=\"form-control\" name=\"edit_takt_time\" id=\"edit_takt_time\" placeholder=\"100\" required value=\"$takt_time\">
                                </div> 

                                <div class=\"mb-3\">
                                    <label for=\"edit_work_end\" class=\"form-label\">Work End <span class=\"text-danger\">*</span></label>
                                    <input type=\"time\" class=\"form-control\" name=\"edit_work_end\" id=\"edit_work_end\" placeholder=\"100\" required value=\"$work_end\">
                                </div>
    
                                <div class=\"mb-3\">
                                    <label for=\"edit_status\" class=\"form-label\">Status <span style=\"color: red;\">*</span></label>
                                    <select name=\"edit_status\" id=\"edit_status\" class=\"form-control\" required> 
                                        <option value=\"$status\" hidden>$status_string</option>
                                        <option value=\"1\">Active</option>
                                        <option value=\"0\">Inactive</option>
                                    </select> 
                                </div>  
                                
                            </div>

                            <div class=\"col-md-12\">
                            <div class=\"mb-3\">
                                <label for=\"extra_view_upload\" class=\"form-label\">Extra View</label>
                                <input type=\"file\" accept=\".png, .jpg, .jpeg\" class=\"form-control\" name=\"extra_view_upload\" id=\"extra_view_upload\">
                            </div>
                        </div>
                        </div>

                        <br>
                        <div class=\"d-flex justify-content-left\">
                            <input type=\"submit\" name=\"reedit_line_submit\" class=\"btn btn-primary pr-3\" value=\"Save\">
                            <input type=\"reset\" name=\"edit_line_cancel\" class=\"btn btn-secondary ml-2\" value=\"Cancel\" id=\"edit_line_cancel\">
                        </div>
                    
                    `;

                    const targetElement = document.getElementById('edit_user_form');

                    if (targetElement) {
                        document.getElementById('edit_user_form').innerHTML = table;

                    } else {
                        console.error(\"Element with ID 'edit_user_form' not found in the DOM.\");
                    }


                }); 
                </script>";

            }

        }

    }
    else{

        $date = date("Y-m-d");
        $username = $_SESSION["username"];

        $sql_command = "SELECT * FROM tbl_line WHERE line_name = '$username' AND date = '$date' ";
        $result = mysqli_query($conn, $sql_command);

        if(mysqli_num_rows($result) > 0){
            $line = mysqli_fetch_assoc($result);

            $date = date("Y-m-d");

            $_SESSION["line_id"] = $line["id"];

            $line_name = $line["line_name"];
            $line_desc = $line["line_desc"];

            $line_img = $line["line_img"];
            $incharge_name = $line["incharge_name"];
            $incharge_img = $line["incharge_img"];

            $work_start = $line["work_time_from"];
            $work_end = $line["work_time_to"];

            $daily_target = $line["daily_target"];

            $breaktime_code_get = $line["breaktime_code"];
            $takt_time = $line["takt_time"];

            $status = $line["status"];

            $status_string = "";
            if($status == 1){
                $status_string = "Active";
            }
            else{
                $status_string = "Inactive";
            }


            $sql_command = "SELECT * FROM tbl_records WHERE date = '$date' AND model = '$line_name' AND unit = '$line_desc' ";
            $result = mysqli_query($conn, $sql_command);

            if(mysqli_num_rows($result) > 0){
                $record = mysqli_fetch_assoc($result);

                $records_id = $record["id"];
                $_SESSION["records_id"] = $records_id;

                $target = $record["target_now"];
                $actual = $record["actual"];
                $balance = $record["balance"];
                
                echo "<script>
                document.addEventListener('DOMContentLoaded', function () {

                    document.getElementById('line_name').innerHTML = '$line_name'; 
                    document.getElementById('line_desc').innerHTML = '$line_desc';

                    document.getElementById('incharge_name').innerHTML = '$incharge_name'; 
                    document.getElementById('daily_target_display').innerHTML = '$daily_target';
                    
                    const line_img = '<img src=\"$line_img\" alt=\"LineImage\" class=\"img-fluid mr-3 border\" style=\"width: 380px; height: 210px; \" >';
                    document.getElementById('line_image_div').innerHTML = line_img; 
                    
                    const incharge_img = '<img src=\"$incharge_img\" alt=\"inchargeImage\" class=\"mr-5\" style=\"width: 200px; height: 200px;\">';
                    document.getElementById('incharge_image_div').innerHTML = incharge_img; 

                    document.getElementById('target_count').innerHTML = '$target'; 
                    document.getElementById('actual_count').innerHTML = '$actual';
                    document.getElementById('balance_count').innerHTML = '$balance';

                    document.getElementById('minus').style.display = 'block';
                    document.getElementById('plus').style.display = 'block';

                });
                </script>";


                $sql_command = "SELECT * FROM tbl_breaktime WHERE breaktime_code = '$breaktime_code_get' ";
                $result = mysqli_query($conn, $sql_command);

                if(mysqli_num_rows($result) > 0){
                    while($break = mysqli_fetch_assoc($result)){

                        $_SESSION['tool_start'] = $break["tool_box_meeting_start"];
                        $_SESSION['tool_end'] = $break["tool_box_meeting_end"];

                        $_SESSION['am_start'] = $break["am_break_start"];
                        $_SESSION['am_end'] = $break["am_break_end"];

                        $_SESSION['lunch_start'] = $break["lunch_break_start"];
                        $_SESSION['lunch_end'] = $break["lunch_break_end"];

                        $_SESSION['pm_start'] = $break["pm_break_start"];
                        $_SESSION['pm_end'] = $break["pm_break_end"];

                        $_SESSION['ot_start'] = $break["ot_break_start"];
                        $_SESSION['ot_end'] = $break["ot_break_end"];

                    }
                }

                echo "<script> 
                document.addEventListener('DOMContentLoaded', function () {

                    const table = `

                        <div class=\"row\">
                    
                            <div class=\"col-md-6\">
                                
                                <div class=\"mb-3\">
                                    <label for=\"edit_line_desc\" class=\"form-label\">Line Description <span class=\"text-danger\">*</span></label>
                                    <input type=\"text\" class=\"form-control\" name=\"edit_line_desc\" id=\"edit_line_desc\" required value=\"$line_desc\">
                                </div>
                                <div class=\"mb-3\">
                                    <label for=\"line_image_upload\" class=\"form-label\">Line Image <span class=\"text-danger\">*</span></label>
                                    <input type=\"file\" accept=\".png, .jpg, .jpeg\" class=\"form-control\" name=\"line_image_upload\" id=\"line_image_upload\" required value=\"$line_img\">
                                </div>
                                
                                <div class=\"mb-3\">
                                    <label for=\"edit_daily_target\" class=\"form-label\">Daily Target <span class=\"text-danger\">*</span></label>
                                    <input type=\"number\" class=\"form-control\" name=\"edit_daily_target\" id=\"edit_daily_target\" placeholder=\"100\" required value=\"$daily_target\">
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"edit_work_start\" class=\"form-label\">Work Start <span class=\"text-danger\">*</span></label>
                                    <input type=\"time\" class=\"form-control\" name=\"edit_work_start\" id=\"edit_work_start\" required value=\"$work_start\">
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"edit_breaktime_code\">Breaktime Code <span style=\"color: red;\">*</span></label>
                                    <select name=\"edit_breaktime_code\" id=\"edit_breaktime_code\" class=\"form-control\" required > 
                                        <option value=\"$breaktime_code_get\" hidden>$breaktime_code_get</option>
                                    </select> 
                                </div>
                            
                            </div>
                            
                            <div class=\"col-md-6\">
                                <!-- Line Person -->
                                <div class=\"mb-3\">
                                    <label for=\"edit_line_leader\" class=\"form-label\">Line Leader <span class=\"text-danger\">*</span></label>
                                    <input type=\"text\" class=\"form-control\" name=\"edit_line_leader\" id=\"edit_line_leader\" placeholder=\"Juan Dela Cruz\" required value=\"$incharge_name\">
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"leader_image_upload\" class=\"form-label\">Line Leader Image <span class=\"text-danger\">*</span></label>
                                    <input type=\"file\" accept=\".png, .jpg, .jpeg\" class=\"form-control\" name=\"leader_image_upload\" id=\"leader_image_upload\" required value=\"$incharge_img\">
                                </div>
                                
                                <div class=\"mb-3\">
                                    <label for=\"edit_takt_time\" class=\"form-label\">Takt Time <span class=\"text-danger\">*</span></label>
                                    <input type=\"number\" class=\"form-control\" name=\"edit_takt_time\" id=\"edit_takt_time\" placeholder=\"100\" required value=\"$takt_time\">
                                </div> 

                                <div class=\"mb-3\">
                                    <label for=\"edit_work_end\" class=\"form-label\">Work End <span class=\"text-danger\">*</span></label>
                                    <input type=\"time\" class=\"form-control\" name=\"edit_work_end\" id=\"edit_work_end\" placeholder=\"100\" required value=\"$work_end\">
                                </div>
    
                                <div class=\"mb-3\">
                                    <label for=\"edit_status\" class=\"form-label\">Status <span style=\"color: red;\">*</span></label>
                                    <select name=\"edit_status\" id=\"edit_status\" class=\"form-control\" required> 
                                        <option value=\"$status\" hidden>$status_string</option>
                                        <option value=\"1\">Active</option>
                                        <option value=\"0\">Inactive</option>
                                    </select> 
                                </div>  
                                
                            </div>

                            <div class=\"col-md-12\">
                            <div class=\"mb-3\">
                                <label for=\"extra_view_upload\" class=\"form-label\">Extra View</label>
                                <input type=\"file\" accept=\".png, .jpg, .jpeg\" class=\"form-control\" name=\"extra_view_upload\" id=\"extra_view_upload\">
                            </div>
                        </div>
                        </div>

                        <br>
                        <div class=\"d-flex justify-content-left\">
                            <input type=\"submit\" name=\"reedit_line_submit\" class=\"btn btn-primary pr-3\" value=\"Save\">
                            <input type=\"reset\" name=\"edit_line_cancel\" class=\"btn btn-secondary ml-2\" value=\"Cancel\" id=\"edit_line_cancel\">
                        </div>
                    
                    `;

                    const targetElement = document.getElementById('edit_user_form');

                    if (targetElement) {
                        document.getElementById('edit_user_form').innerHTML = table;

                    } else {
                        console.error(\"Element with ID 'edit_user_form' not found in the DOM.\");
                    }


                }); 
                </script>";

            }

        }
    }

?>
 
<script>

    var work_status = "WORK";
    var i = 0;
    var j = 0;

    var img_extra_path = "<?php echo isset($_SESSION['img_extra_path']) ? $_SESSION['img_extra_path'] : '0'; ?>"

    var takt_time_string = "<?php echo isset($_SESSION['takt_time']) ? $_SESSION['takt_time'] : ''; ?>";
    var takt_time = parseInt(takt_time_string) * 60;

    var tool_start = "<?php echo isset($_SESSION['tool_start']) ? $_SESSION['tool_start'] : ''; ?>";
    var tool_end = "<?php echo isset($_SESSION['tool_end']) ? $_SESSION['tool_end'] : ''; ?>";

    var am_start = "<?php echo isset($_SESSION['am_start']) ? $_SESSION['am_start'] : ''; ?>";
    var am_end = "<?php echo isset($_SESSION['am_end']) ? $_SESSION['am_end'] : ''; ?>";

    var lunch_start = "<?php echo isset($_SESSION['lunch_start']) ? $_SESSION['lunch_start'] : ''; ?>";
    var lunch_end = "<?php echo isset($_SESSION['lunch_end']) ? $_SESSION['lunch_end'] : ''; ?>";

    var pm_start = "<?php echo isset($_SESSION['pm_start']) ? $_SESSION['pm_start'] : ''; ?>";
    var pm_end = "<?php echo isset($_SESSION['pm_end']) ? $_SESSION['pm_end'] : ''; ?>";

    var ot_start = "<?php echo isset($_SESSION['ot_start']) ? $_SESSION['ot_start'] : ''; ?>";
    var ot_end = "<?php echo isset($_SESSION['ot_end']) ? $_SESSION['ot_end'] : ''; ?>";

    function add_target() { 

        var actual = document.getElementById('actual_count').innerHTML;
        var target = document.getElementById('target_count').innerHTML;
        
        var new_target = parseInt(target) + 1;
        var new_balance = new_target - actual;

        document.getElementById('balance_count').innerHTML = new_balance;
        document.getElementById('target_count').innerHTML = new_target;

        update();
    }

    function start_breaktime(){
        document.getElementById('runStopButton').innerHTML = 'BREAK';
        document.body.style.backgroundColor = 'lightgray'; // lighter shade of gray

        update();
    }

    function end_breaktime(){
        document.getElementById('runStopButton').innerHTML = 'RUN';
        document.body.style.backgroundColor = '#add8e6'; // light blue

        update();
    }

    function check_breaktime_start(){

        var full_time_now = new Date();
        var time_hour = full_time_now.getHours();
        var time_minute = full_time_now.getMinutes();

        var time_now = (time_hour < 10 ? "0" : "") + time_hour + ":" 
                        + (time_minute < 10 ? "0" : "") + time_minute;

        console.log(time_now);

        switch(time_now){
            case tool_start: 
                start_breaktime();
                work_status = "BREAK";
                break;
            case am_start: 
                start_breaktime();
                work_status = "BREAK";
                break;
            case lunch_start:
                start_breaktime(); 
                work_status = "BREAK";
                break;
            case pm_start: 
                start_breaktime();
                work_status = "BREAK";
                break;
            case ot_start: 
                start_breaktime();
                work_status = "BREAK";
                break;
        }
    }
     
    function countingInterval(){

        if(work_status == "WORK"){

            i++;
            console.log(i);

            if(takt_time == i){
                i = 0;
                add_target();
            }

            check_breaktime_start();

            console.log(work_status);

        }
        else if(work_status == "BREAK"){

            var full_time_now = new Date();
            var time_hour = full_time_now.getHours();
            var time_minute = full_time_now.getMinutes();

            var time_now = (time_hour < 10 ? "0" : "") + time_hour + ":" 
                        + (time_minute < 10 ? "0" : "") + time_minute;

            console.log(time_now);

            switch(time_now){
                case tool_end: 
                    end_breaktime();
                    work_status = "WORK";
                    break;
                case am_end: 
                    end_breaktime();
                    work_status = "WORK";
                    break;
                case lunch_end: 
                    end_breaktime();
                    work_status = "WORK";
                    break;
                case pm_end: 
                    end_breaktime();
                    work_status = "WORK";
                    break;
                case ot_end: 
                    end_breaktime();
                    work_status = "WORK";
                    break;
            }

            console.log(i);
            console.log(work_status);
        }

        // extra view display

        if(img_extra_path != "0"){

            if(document.getElementById('edit_user').style.display == "none"){

                j++;

                if(j == 10){
                    document.getElementById('user_dashboard').style.display = "block";
                    document.getElementById('body').style.backgroundImage = "none";

                }
                else if(j == 20){
                    document.getElementById('user_dashboard').style.display = "none";

                    document.getElementById('body').style.backgroundImage = `url(${img_extra_path})`;
                    document.getElementById('body').style.backgroundSize = "cover";
                    document.getElementById('body').style.backgroundPosition = "center";

                    j = 0;
                    
                }

            }

        }

    }


    let milliseconds = 0;
    let interval = null;

    function updateTimer(){
        milliseconds += 10;
        let secs = Math.floor(milliseconds / 1000);
        let hrs = Math.floor(secs / 3600);
        let mins = Math.floor((secs % 3600) / 60);
        secs = secs % 60;
        let millis = milliseconds % 1000;

        document.getElementById("timer").innerText =
            (hrs < 10 ? "0" : "") + hrs + ":" +
            (mins < 10 ? "0" : "") + mins + ":" +
            (secs < 10 ? "0" : "") + secs + ":" +
            (millis < 100 ? "0" : "") + (millis < 10 ? "0" : "") + millis;
    }

    function handleRunStop() {
        const button = document.getElementById('runStopButton');
        const body = document.body;

        if (button.innerText === 'RUN') {
            button.innerText = 'STOP';
            body.style.backgroundColor = '#ffcccb'; // light red
            interval = setInterval(updateTimer, 10);
        } else if (button.innerText === 'STOP') {
            clearInterval(interval);
            button.innerText = 'RUN';
            body.style.backgroundColor = '#add8e6'; // light blue
        } 

        update();
    }

    function update(){
        var model = document.getElementById('line_name').innerHTML;
        var unit = document.getElementById('line_desc').innerHTML;
        var status = document.getElementById('runStopButton').innerHTML;

        var targetPerDay = document.getElementById('daily_target_display').innerHTML;
        var target = document.getElementById('target_count').innerHTML;
        var actual = document.getElementById('actual_count').innerHTML;
        var balance = document.getElementById('balance_count').innerHTML;

        var updateDetails = {
            model: model,
            unit: unit,
            status: status,
            targetPerDay: targetPerDay,
            target: target,
            actual: actual,
            balance: balance
        };

        $.ajax({
            method: 'POST',
            url: 'update.php',
            data: updateDetails,
            success: function(response){
                console.log("Success");
            },
            error: function(){
                console.log("Error");
            }
        });
    }

    function add() {
        var actual = document.getElementById('actual_count').innerHTML;
        var target = document.getElementById('target_count').innerHTML;
        var daily_target = document.getElementById('daily_target_display').innerHTML;
        
        var new_actual = parseInt(actual) + 1;
        var new_balance = parseInt(target) - new_actual;
        var new_daily_target = parseInt(daily_target);

        document.getElementById('actual_count').innerHTML = new_actual;
        document.getElementById('balance_count').innerHTML = new_balance;

        if(new_actual >= new_daily_target){
            document.getElementById('runStopButton').innerHTML = 'FINISH';
            document.body.style.backgroundColor = '#90EE90'; // light green

            work_status = "FINISH";
        }

        update();
    }

    function minus() {  
        var actual = document.getElementById('actual_count').innerHTML;
        var target = document.getElementById('target_count').innerHTML;
        var daily_target = document.getElementById('daily_target_display').innerHTML;   
        
        var new_actual = parseInt(actual) - 1;
        var new_balance = parseInt(target) - new_actual;
        var new_daily_target = parseInt(daily_target);

        document.getElementById('actual_count').innerHTML = new_actual;
        document.getElementById('balance_count').innerHTML = new_balance;

        if(new_actual < new_daily_target){
            document.getElementById('runStopButton').innerHTML = 'RUN';
            document.body.style.backgroundColor = '#add8e6'; // light blue

            work_status = "WORK";
        }

        update();
    }

    function showEdituser() {
        document.getElementById('edit_user').style.display = 'block';
        document.getElementById('user_dashboard').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function () {

        const user_dashboard = document.getElementById('user_dashboard');
        const edit_user = document.getElementById('edit_user');
        const edit_line_cancel = document.getElementById('edit_line_cancel');

        edit_line_cancel.addEventListener("click", function (){

            user_dashboard.style.display = "block";
            edit_user.style.display = "none";

        });

        var trigger = document.getElementById('line_desc').innerHTML;
        if (trigger != '-----') {

            setInterval(countingInterval, 1000);
        }

    });

</script>