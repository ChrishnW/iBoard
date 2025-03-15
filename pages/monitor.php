<?php include '../include/header.php'; ?>
<!-- Begin Page Content -->
<div class="container-fluid">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container py-3">
        <div class="d-flex align-items-center">
            <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid mr-3 border" style="width: 50px;">
            <span class="h4 font-weight-bold mb-0">SDRP LINE</span>
            
            <div class="ml-auto text-right">
                <span class="h1 font-weight-bold mb-2 text-dark">RUN</span> <br>
                <span class="h5 font-weight-bold mb-0 text-danger">00:00:00</span>
            </div>
        </div>

        <div id="details" class="d-flex align-items-start mt-3">
            <img src="../assets/img/pexels-pixabay-434337.jpeg" alt="line" class="img-fluid mr-3 border" style="width: 350px;">
            <div>
                <span class="h5 font-weight-bold mb-2 text-danger text-decoration-underline">Information</span> <br>
                <span class="h5 font-weight-bold mb-2">SDRB-200/260</span> <br>
                <span class="h5 font-weight-bold mb-2 text-danger text-decoration-underline">Leader</span> <br>
                <span class="h5 font-weight-bold mb-2">Juan Dela Cruz</span> <br>
            </div>
            <div class="ml-auto">
                <img src="../assets/img/undraw_profile.svg" alt="" class="img-fluid border" style="width: 80px;">
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th class="align-text-top">DAILY TARGET</th>
                            <th class="align-text-top">TARGET (NOW)</th>
                            <th class="align-text-top">ACTUAL</th>
                            <th class="align-text-top">BALANCE</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

</div>
<!-- /.container-fluid -->
<?php include '../include/footer.php'; ?>