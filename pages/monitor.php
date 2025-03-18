<?php 
    include '../include/link.php'; 
    include '../include/connect.php'
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
</head>
<body>
    <div class="container-fluid">
    <div id="monitor_dashboard" class="monitor_dashboard" style="display: block;">

        <div class="card shadow my-4">
            <div class="card-header py-3.5 pt-4 align-items-center ">
                <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid mr-2 border" style="width: 55px;">
                <h2 class="d-inline-block align-middle pt-2 text-primary font-weight-bold "><u>GPI Production Status</u></h2>
                <button class="btn btn-danger float-right mt-2" onclick="window.location.href='../include/logout.php'">
                    <i class="fas fa-sign-out-alt"></i> Exit
                </button>
                <div class="clearfix"></div>
            </div>
        
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white text-center">
                        <tr>
                            <th rowspan="2" class="text-center align-middle">Model</th>
                            <th rowspan="2" class="text-center align-middle">Unit</th>
                            <th rowspan="2" class="text-center align-middle">Status</th>
                            <th colspan="2" class="text-center align-middle">TARGET</th>
                            <th rowspan="2" class="text-center align-middle">Actual</th>
                            <th rowspan="2" class="text-center align-middle">Balance</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">(Day)</th>
                            <th class="text-center align-middle">(Now)</th>
                        </tr>
                        </thead>

                        <tbody class="text-black text-center">
                            <td class="font-weight-bold">SDRB</td>
                            <td class="font-weight-bold">SDRB-200/260</td>
                            <td>Run</td>
                            <td>100</td>
                            <td>3</td>
                            <td>1</td>
                            <td class="text-danger">-2</td>
                        </tbody>
        
                        <tbody class="text-black text-center">
                            <td class="font-weight-bold">Test</td>
                            <td class="font-weight-bold">Test 1</td>
                            <td>Stopped</td>
                            <td>10</td>
                            <td>5</td>
                            <td>5</td>
                            <td class="text-danger">-5</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>