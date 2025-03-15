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
    <div class>
        <div style="display: flex; align-items: center;">
            <img src="../assets/img/logo.png" alt="" style="width: 50px; height: auto; margin-right: 10px;">
            <h2 style="color: blue; font-weight: bold;">SDRB LINE</h2>
        </div>


        <div class="card-body">
            <div class="table-responsive">
            <table class=" table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
</body>
</html>

</div>
<!-- /.container-fluid -->
<?php include '../include/footer.php'; ?>