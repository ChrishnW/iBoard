<?php 
    include '../include/link.php'; 
    include '../include/connect.php';
    include '../include/auth.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>i-Board | Admin Monitor</title>
        <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/logo.png">
        <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="../vendor/snapappointments/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../assets/css/style2.css">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    </head>

    <body>
        <div class="container-fluid">
            <div id="monitor_dashboard" class="monitor_dashboard" style="display: block;">
            <div class="card shadow my-4">
                <div class="card-header p-3 align-items-center ">
                    <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid mr-2 border" style="width: 55px;">
                    <h2 class="d-inline-block align-middle pt-2 text-primary font-weight-bold "><u id="prod_name">GPI Production Status</u></h2>
                    <a class="btn btn-danger float-right mt-2" href="#" onclick="showExitModal()">
                        <i class="fas fa-sign-out-alt mr-1"></i> 
                        Back
                    </a>

                    <div class="clearfix"></div>
                </div>
            
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th rowspan="2" class="text-center align-middle">Departments</th>
                                    <th rowspan="2" class="text-center align-middle">Building</th>
                                    <th rowspan="2" class="text-center align-middle">Model</th>
                                    <th rowspan="2" class="text-center align-middle">Unit</th>
                                    <th rowspan="2" class="text-center align-middle">Status</th>
                                    <th colspan="2" class="text-center align-middle">TARGET</th>
                                    <th rowspan="2" class="text-center align-middle">Actual</th>
                                    <th rowspan="2" class="text-center align-middle">Balance</th>
                                </tr>
                                <tr>
                                    <th class="text-center align-middle border-top-0">(Day)</th>
                                    <th class="text-center align-middle border-top-0">(Now)</th>
                                </tr>
                            </thead>

                            <tbody class="text-black text-center" id="insert_here">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>    

        <!-- Exit Pop out Modal -->
        <div class="modal" tabindex="-1" id="popoutExit" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">Exit Confirmation</h5>
                        <button type="button" class="close text-white" aria-label="Close" id="close_popup2">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body mt-2 mb-1">
                        <p class="h5">Are you sure you want to go back?</p>
                    </div>

                    <div class="modal-footer">
                        <!-- Logout button triggers JavaScript logout logic -->
                        <button onclick="handleExit()" class="btn btn-danger">Back</button>
                        <a href="#" onclick="closePopupExit()" class="btn btn-secondary" style="text-decoration: none;">Cancel</a>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>

<script>

    document.getElementById('close_popup2').addEventListener('click', function () {
      document.getElementById('popoutExit').style.display = 'none';
    });

    function showExitModal() {
        const modal = document.getElementById('popoutExit');
        modal.style.display = 'block'; 
    }

    function handleExit() {
        window.close(); 
    }

    function closePopupExit() {
        const modal = document.getElementById('popoutExit');
        modal.style.display = 'none'; 
    }

    function updateTable() {
        $.ajax({
            method: 'POST',
            url: 'admin_monitor_fetch.php',
            success: function (data) {
                $('#dataTable').DataTable().destroy(); 
                document.getElementById('insert_here').innerHTML = data;
                $('#dataTable').DataTable({
                    "pageLength": 25
                });
                console.log("Success");
            },
            error: function () {
                console.log("Error");
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        setInterval(updateTable, 1000);
    });
    
</script>