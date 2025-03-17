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

        <?php include '../include/link.php'; ?>
        <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="../vendor/snapappointments/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
        
</head>
<body class="container-fluid p-4" style="background-color: #add8e6;">

        <!-- EDIT MONITOR -->
        <div id="edit_monitor" class="edit_monitor" style="display: none;">
            <div class="card shadow mb-4">
                <div class="card-header py-3.5 pt-4">
                    <h2 class="float-left">Edit Details</h2>        
                </div>
                <div class="card-body shadow-sm m-4 p-4">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data" style="width: 100%;">
                        <div class="row">
                            <!-- Column 1: Line Details and Person -->
                            <div class="col-md-6">
                                <!-- Line Details -->
                                <div class="mb-3">
                                    <label for="dept_name" class="form-label">Line Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="dept_name" id="dept_name" placeholder="SDRB LINE" required>
                                </div>
                                <div class="mb-3">
                                    <label for="dept_code" class="form-label">Line Description<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="dept_code" id="dept_code" placeholder="101" required>
                                </div>
                                <div class="mb-3">
                                    <label for="line_image" class="form-label">Line Image<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="line_image" id="line_image" required>
                                </div>
                                
                                  <!-- Column 2: Table -->
                                 <div class="mb-3">
                                    <label for="daily_target" class="form-label">Daily Target<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="daily_target" id="daily_target" placeholder="100" required>
                                </div>
                                <div class="mb-3">
                                    <label for="target_now" class="form-label">Target Now<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="target_now" id="target_now" placeholder="7" required> 
                                </div>  

                            </div>
                          
                            <div class="col-md-6">
                                <!-- Line Person -->
                                <div class="mb-3">
                                    <label for="line_leader" class="form-label">Line Leader<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="line_leader" id="line_leader" placeholder="Juan Dela Cruz" required>
                                </div>
                                <div class="mb-3">
                                    <label for="line_leader_image" class="form-label">Line Leader Image<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="line_leader_image" id="line_leader_image" required>
                                </div>
                                
                            </div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-left">
                            <input type="submit" name="add_department_submit" class="btn btn-primary pr-3" value="Edit">
                            <input type="reset" name="reset" class="btn btn-secondary ml-2" value="Cancel" id="cancel_department">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <div id="monitor_dashboard" class="monitor_dashboard" style="display: block;">
        <!-- Header Section -->
        <div class="d-flex align-items-center px-3">
            <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid mr-3 border" style="width: 100px;">
            <span class="h2 font-weight-bold mb-0 text-primary">SDRB LINE</span>
            
            <div class="ml-auto text-right mr-5">
                <button class="display-4 font-weight-bold mb-2 mr-2 text-dark" style="background-color: transparent; border: none;">RUN</button> <br>
                <span class="h3 font-weight-bold mb-0 text-danger">00:00:00:00</span>
            </div>

            <div id="settings" class="dropdown">
                <button class="fa fa-cog fa-2x" aria-hidden="true" style="background-color: transparent; border: none;" data-toggle="dropdown"></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" onclick="showEditMonitor()">Settings</a>
                    <a class="dropdown-item" href="#">Logout</a>
                </div>
            </div>

        </div>

        <!-- Details Section -->
        <div id="details" class="d-flex align-items-start my-3 px-5 py-3 mr-4">
            <img src="../assets/img/pexels-pixabay-434337.jpeg" alt="line" class="img-fluid mr-3 border" style="width: 400px;">
            
            <div class="d-flex flex-column pl-5 fs-1" >
                <span class="h2 text-danger"><u>Information</u></span> 
                <span class="h2 text-dark">SDRB-200/260</span> 
                <span class="h2 text-danger"><u>Leader</u></span> 
                <span class="h2 text-dark">Juan Dela Cruz</span> 
            </div>

            <div class="ml-auto align-self-end">
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
                            <td class="font-weight-bolder" style="font-size: 50px;">100</td>
                            <td id="target_count" class="font-weight-bolder" style="font-size: 50px;">7</td>
                            <td>
                                <p id="actual_count" class="font-weight-bolder mt-5 mb-0 pb-3"style="font-size: 50px;">0</p>
                                <div class="d-flex justify-content-between mt-1">
                                    <button class="btn btn-primary btn-sm" onclick="minus()" style="display: block;">-</button>
                                    <button class="btn btn-primary btn-sm" onclick="add()" style="display: block;">+</button>
                                </div>
                            </td>
                            <td class="font-weight-bold mb-2 text-danger font-weight-bolder "style="font-size: 50px;" id="balance_count">0</td>        
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    
        <!-- Include jQuery and Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

        <script>
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

                function showEditMonitor() {
                    document.getElementById('edit_monitor').style.display = 'block';
                    document.getElementById('monitor_dashboard').style.display = 'none';
                }
        </script>
</body>
</html>
