<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php include '../include/link.php'; ?>
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../vendor/snapappointments/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    
</head>
<body class="container-fluid p-4" style="background-color: #add8e6;">
    <div>
        <div class="d-flex align-items-center px-3">
            <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid mr-3 border" style="width: 50px;">
            <span class="h4 font-weight-bold mb-0">SDRP LINE</span>
            
            <div class="ml-auto text-right mr-5">
                <span class="h1 font-weight-bold mb-2 text-dark">RUN</span> <br>
                <span class="h5 font-weight-bold mb-0 text-danger">00:00:00</span>
            </div>
        </div>

        <div id="details" class="d-flex align-items-start mt-3 px-5 mr-4">
            <img src="../assets/img/pexels-pixabay-434337.jpeg" alt="line" class="img-fluid mr-3 border" style="width: 350px;">
            <div class="d-flex flex-column pl-5 fs-1">
            <span class="h3 text-danger text-decoration-underline">Information</span> 
            <span class="h3 ">SDRB-200/260</span> 
            <span class="h3 text-danger text-decoration-underline">Leader</span> 
            <span class="h3 ">Juan Dela Cruz</span> 
            </div>
            <div class="ml-auto align-self-end">
            <img src="../assets/img/undraw_profile.svg" alt="" class="img-fluid border" style="width: 80px;">
            </div>  
        </div>

        <div class="card-body mt-3">
            <div class="table-responsive bg-white">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th class="align-text-top">DAILY TARGET</th>
                            <th class="align-text-top">TARGET (NOW)</th>
                            <th class="align-text-top">ACTUAL</th>
                            <th class="align-text-top">BALANCE</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-center">
                        <tr>
                            <td>100</td>
                            <td id="target_count">7</td>
                            <td>
                                <p id="actual_count">0</p>
                                <div class="d-flex justify-content-between mt-2">
                                    <button class="btn btn-primary btn-sm" onclick="minus()">-</button>
                                    <button class="btn btn-primary btn-sm" onclick="add()">+</button>
                                </div>
                            </td>
                            <td class="h5 font-weight-bold mb-2 text-danger" id="balance_count">0</td>        
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
