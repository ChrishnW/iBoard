<?php
    include "../include/connect.php";

    $date = date("Y-m-d");
    $model = isset($_POST['model']) ? $_POST['model'] : null;
    $unit = isset($_POST['unit']) ? $_POST['unit'] : null;
    
    $status = isset($_POST['status']) ? $_POST['status'] : null;

    $targetPeDay = isset($_POST['targetPerDay']) ? $_POST['targetPerDay'] : null;
    $target = isset($_POST['target']) ? $_POST['target'] : null;
    $actual = isset($_POST['actual']) ? $_POST['actual'] : null;
    $balance = isset($_POST['balance']) ? $_POST['balance'] : null;

    mysqli_query($conn, "UPDATE tbl_records SET status = '$status', target_day = '$targetPeDay',
                        target_now = '$target', actual = '$actual', balance = '$balance' 
                        WHERE date = '$date' AND model = '$model' AND unit = '$unit' ");


?>