<?php 
    include '../include/link.php'; 
    include '../include/connect.php';
    include '../include/auth.php';

    if(!$access_security){
        header('location: ../index.php');
        exit();
    }
    else {
        if($access_security != 3){
            header('location: ../index.php');
            exit();
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <div class="container-fluid">
    <div id="monitor_dashboard" class="monitor_dashboard" style="display: block;">

        <div class="card shadow my-4">
            <div class="card-header py-3.5 pt-4 align-items-center ">
                <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid mr-2 border" style="width: 55px;">
                <h2 class="d-inline-block align-middle pt-2 text-primary font-weight-bold "><u>GPI Production Status</u></h2>
                <a class="btn btn-danger float-right mt-2" href="../include/logout.php">
                    <i class="fas fa-sign-out-alt"></i> Exit
                </a>
                <div class="clearfix"></div>
            </div>
        
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-striped" id="dataTable" width="100%" cellspacing="0">
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

                        <tbody class="text-black text-center" id="insert_here">
                            
                        </tbody>
                        
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    <nav aria-label="...">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>

                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            
                            <li class="page-item">
                                <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                            </li>

                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    
    
</body>
</html>

<script>

    function updateTable() {
        $.ajax({
            method: 'POST',
            url: 'fetch.php',
            success: function (data) {
                document.getElementById('insert_here').innerHTML = data;
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
    
    //---------------------------------------------------------------------------------


    let currentPage = 1;

    function updateTable() {
        $.ajax({
            method: 'POST',
            url: 'fetch.php',
            data: { page: currentPage },
            success: function (data) {
                document.getElementById('insert_here').innerHTML = data;

                // Update Pagination UI
                const totalPages = parseInt(document.getElementById('totalPages').value || 1, 10);
                updatePagination(totalPages);
                console.log("Success");
            },
            error: function () {
                console.log("Error");
            }
        });
    }

    function updatePagination(totalPages) {
        const pagination = document.querySelector('.pagination');
        pagination.innerHTML = '';

        pagination.innerHTML += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                                    <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Previous</a>
                                </li>`;

        for (let i = 1; i <= totalPages; i++) {
            pagination.innerHTML += `<li class="page-item ${currentPage === i ? 'active' : ''}">
                                        <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                                    </li>`;
        }

        pagination.innerHTML += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                                    <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a>
                                </li>`;
    }

    function changePage(page) {
        if (page > 0) {
            currentPage = page;
            updateTable();
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        updateTable();
    });
    
     
</script>