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
    <div>
        <!-- Header Section -->
        <div class="d-flex align-items-center px-3">
            <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid mr-3 border" style="width: 100px;">
            <span class="h2 font-weight-bold mb-0 text-primary">SDRP LINE</span>
            
            <div class="ml-auto text-right mr-5">
                <button class="display-4 font-weight-bold mb-2 mr-3 text-dark" style="background-color: transparent; border: none;">RUN</button> <br>
                <span class="h3 font-weight-bold mb-0 text-danger">00:00:00:00</span>
            </div>

            <div id="settings" class="">
                <i class="fa fa-cog fa-2x" aria-hidden="true"></i>
            </div>
        </div>

        <!-- Details Section -->
        <div id="details" class="d-flex align-items-start my-3 px-5 py-3 mr-4">
            <img src="../assets/img/pexels-pixabay-434337.jpeg" alt="line" class="img-fluid mr-3 border" style="width: 400px;">
            
            <div class="d-flex flex-column pl-5 fs-1" >
                <span class="h2 text-danger"><u>Information</u></span> 
                <span class="h2 text-dark">SDRB-200/260</span> 
                <span class="h2 text-danger"><u>Leader</u></span> 
                <span class="h2 text-dark">Lee Serrano</span> 
            </div>

            <div class="ml-auto align-self-end">
                <img src="../assets/img/undraw_profile.svg" alt="" class="img-fluid border" style="width: 120px;">
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
                                <p id="actual_count" class="font-weight-bolder mt-5 mb-0 "style="font-size: 50px;">0</p>
                                <div class="d-flex justify-content-between mt-1">
                                    <button class="btn btn-primary btn-sm" onclick="minus()">-</button>
                                    <button class="btn btn-primary btn-sm" onclick="add()">+</button>
                                </div>
                            </td>
                            <td class="font-weight-bold mb-2 text-danger font-weight-bolder "style="font-size: 50px;" id="balance_count">0</td>        
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php

?>

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
</script>
