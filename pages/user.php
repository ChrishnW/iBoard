<?php 

    include '../include/link.php'; 
    include '../include/connect.php';
    include '../include/auth.php';


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
        // Register Line Details ---------------------------------------------------------------------------

        if(isset($_POST['edit_line_submit'])){

            $line_desc = FILTER_INPUT(INPUT_POST, "edit_line_desc", FILTER_SANITIZE_SPECIAL_CHARS);
            $line_leader = FILTER_INPUT(INPUT_POST, "edit_line_leader", FILTER_SANITIZE_SPECIAL_CHARS);

            $daily_target = FILTER_INPUT(INPUT_POST, "edit_daily_target", FILTER_SANITIZE_NUMBER_INT);
            $takt_time = FILTER_INPUT(INPUT_POST, "edit_takt_time", FILTER_SANITIZE_NUMBER_INT);

            $work_start = FILTER_INPUT(INPUT_POST, "edit_work_start", FILTER_SANITIZE_SPECIAL_CHARS);
            $work_end = FILTER_INPUT(INPUT_POST, "edit_work_end", FILTER_SANITIZE_SPECIAL_CHARS);

            $breaktime_code = FILTER_INPUT(INPUT_POST, "edit_breaktime_code", FILTER_SANITIZE_SPECIAL_CHARS);
            $status = FILTER_INPUT(INPUT_POST, "edit_status", FILTER_SANITIZE_SPECIAL_CHARS);

            $line_name = $_SESSION["username"];
            $model_id = $_SESSION["user_id"];

            //print_r($_FILES);

            if($_FILES["line_image_upload"]["error"] == 0 && $_FILES["leader_image_upload"]["error"] == 0){

                $sql_command = "INSERT INTO tbl_line (line_name, line_desc, incharge_name,
                                daily_target, takt_time, work_time_from, work_time_to, 
                                breaktime_code, model_id, status) VALUES 
                                ('$line_name', '$line_desc', '$line_leader', '$daily_target',
                                '$takt_time', '$work_start', '$work_end',
                                '$breaktime_code', '$model_id', '$status')";

                $result = mysqli_query($conn, $sql_command);

                if($result){

                    


                
                    echo "<script>alert('pasok');</script>";

                }
                else{

                    echo "<script>alert('Hindi pasok');</script>";

                }



            }

            header("Refresh: .3; url = user.php");
            exit;

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

    <title>iBoard | <?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?></title>
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/logo.png">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../vendor/snapappointments/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style2.css">
</head>
<body class="container-fluid p-4" style="background-color: #add8e6;">

    <!-- User Dashboard-->

    <div id="user_dashboard" class="user_dashboard" style="display: block;">
        <!-- Header Section -->
        <div class="d-flex align-items-center px-3">
            <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid mr-3 border" style="width: 100px;">
            <span class="h2 font-weight-bold mb-0 text-primary" id="line_name">asd</span>
            
            <div class="ml-auto text-right mr-5">
                <button id="runStopButton" onclick="handleRunStop()" class="display-4 font-weight-bold mb-2 mr-2 text-dark" style="background-color: transparent; border: none;">RUN</button> <br>
                <span class="h3 font-weight-bold mb-0 text-danger" id="timer">00:00:00:000</span>
            </div>

            <div id="settings" class="dropdown">
                <button class="fa fa-cog fa-2x" aria-hidden="true" style="background-color: transparent; border: none;" data-toggle="dropdown"></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" onclick="showEdituser()">Settings</a>
                    <a class="dropdown-item" href="../index.php">Logout</a>
                </div>
            </div>

        </div>

        <!-- Details Section -->
        <div id="details" class="d-flex align-items-start my-3 px-5 py-3 mr-4">

            <div id="line_image">
                <img src="../assets/img/pexels-pixabay-434337.jpeg" alt="line" class="img-fluid mr-3 border" style="width: 400px;">
            </div>

            <div class="d-flex flex-column pl-5 fs-1" >
                <span class="h2 text-danger"><u>Information</u></span> 
                <span class="h2 text-dark" id="line_desc">-----</span>
                <span class="h2 text-danger"><u>Leader</u></span> 
                <span class="h2 text-dark" id="incharge_name">-----</span> 
            </div>

            <div class="ml-auto align-self-end" id="incharge_image">
                <img src="../assets/img/undraw_profile.svg" alt="" class="img-fluid border p-4 mr-5" style="width: 150px; height: 150px;">
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
                            <td class="font-weight-bolder" style="font-size: 50px;" id="daily_terget">0</td>
                            <td id="target_count" class="font-weight-bolder" style="font-size: 50px;" id="target_now">0</td>
                            <td>
                                <p id="actual_count" class="font-weight-bolder mt-5 mb-0 pb-3" style="font-size: 50px;">0</p>
                                <div class="d-flex justify-content-between mt-1">
                                    <button class="btn btn-primary btn-sm" onclick="minus()" style="display: none;">-</button>
                                    <button class="btn btn-primary btn-sm" onclick="add()" style="display: none;">+</button>
                                </div>
                            </td>
                            <td class="font-weight-bold mb-2 text-danger font-weight-bolder" style="font-size: 50px;" id="balance_count">0</td>        
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
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data" style="width: 100%;">
                    <div class="row">
                        <!-- Column 1: Line Details and Person -->
                        <div class="col-md-6">
                            <!-- Line Details -->
                            <div class="mb-3">
                                <label for="edit_line_desc" class="form-label">Line Description <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="edit_line_desc" id="edit_line_desc" placeholder="101" required>
                            </div>
                            <div class="mb-3">
                                <label for="line_image_upload" class="form-label">Line Image <span class="text-danger">*</span></label>
                                <input type="file" accept=".png, .jpg, .jpeg" class="form-control" name="line_image_upload" id="line_image_upload" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_daily_target" class="form-label">Daily Target <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="edit_daily_target" id="edit_daily_target" placeholder="100" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_work_start" class="form-label">Work Start <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="edit_work_start" id="edit_work_start" placeholder="100" required>
                            </div>
                           
                            <div class="mb-3">
                                <label for="edit_breaktime_code">Breaktime Code <span style="color: red;">*</span></label>
                                <select name="edit_breaktime_code" id="edit_breaktime_code" class="form-control" required> 
                                    <option value="" hidden></option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select> 
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <!-- Line Person -->
                            <div class="mb-3">
                                <label for="edit_line_leader" class="form-label">Line Leader <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="edit_line_leader" id="edit_line_leader" placeholder="Juan Dela Cruz" required>
                            </div>
                            <div class="mb-3">
                                <label for="leader_image_upload" class="form-label">Line Leader Image <span class="text-danger">*</span></label>
                                <input type="file" accept=".png, .jpg, .jpeg" class="form-control" name="leader_image_upload" id="leader_image_upload" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_takt_time" class="form-label">Takt Time <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="edit_takt_time" id="edit_takt_time" placeholder="100" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_work_end" class="form-label">Work End <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="edit_work_end" id="edit_work_end" placeholder="100" required>
                            </div>

                            <label for="edit_status" class="form-label">Status <span style="color: red;">*</span></label>
                            <select name="edit_status" id="edit_status" class="form-control" required> 
                                <option value="" hidden></option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select> 

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
        
        echo " <script> document.getElementById('line_name').innerHTML = '$user_name';</script>";
    }

?>

<script>

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
            clearInterval(interval);
            milliseconds = 0; // Reset timer
            button.innerText = 'STOP';
            body.style.backgroundColor = '#ffcccb'; // light red
            interval = setInterval(updateTimer, 10);
        } else if (button.innerText === 'STOP') {
            clearInterval(interval);
            button.innerText = 'RUN';
            body.style.backgroundColor = '#add8e6'; // light blue
            milliseconds = 0; // Reset timer
            interval = setInterval(updateTimer, 10); // Start timer again
        }
    }

    function add() {
        var actual = document.getElementById('actual_count').innerHTML;
        var target = document.getElementById('target_count').innerHTML;
        
        var new_actual = parseInt(actual) + 1;
        var new_balance = parseInt(target) - new_actual;

        document.getElementById('actual_count').innerHTML = new_actual;
        document.getElementById('balance_count').innerHTML = new_balance;
    }

    function minus() {  
        var actual = document.getElementById('actual_count').innerHTML;
        var target = document.getElementById('target_count').innerHTML;
        
        var new_actual = parseInt(actual) - 1;
        var new_balance = parseInt(target) - new_actual;

        document.getElementById('actual_count').innerHTML = new_actual;
        document.getElementById('balance_count').innerHTML = new_balance;
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

    });


</script>