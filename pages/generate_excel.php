<?php

include '../include/connect.php'; 
session_start();
$today = date('Y-m-d');
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Output Records".$today.".xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <center>
        <b>
            <font color="blue">GLORY (PHILIPPINES), INC.</font>
        </b>
        <br>
        <b>i-Board System</b>
        <br>
        <h3><b>Output Records</b></h3>
        <br>
    </center>
    <br>

    <div id="table-scroll">
        <table width="100%" border="1" align="left">
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Model</th>
                    <th>Unit</th>
                    <th>Status</th>
                    <th>Daily Target</th>
                    <th>Daily Output</th>
                    <th>Daily Balance</th>
                    <th>In-Charge</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $start = $_SESSION["start_from"];
                $end = $_SESSION["end_to"];
                $dept_code = $_SESSION['department_code'];

                $startDate = new DateTime($start);
                $endDate = new DateTime($end);

                for($i = 1; $i <= $_SESSION['gap']; $i++){

                    $formattedDate = $startDate->format('Y-m-d');

                    $conn->next_result();
                    $result = mysqli_query($conn,"SELECT tbl_records.date, tbl_department.dept_name, tbl_records.model,tbl_records.unit, tbl_records.status, tbl_records.target_day, tbl_records.actual, tbl_records.balance, tbl_line.incharge_name FROM tbl_records INNER JOIN tbl_line ON tbl_line.line_name=tbl_records.model INNER JOIN tbl_accounts ON tbl_accounts.username=tbl_records.model INNER JOIN tbl_department ON tbl_department.dept_code=tbl_accounts.dept_code WHERE tbl_records.date='$formattedDate' AND tbl_department.dept_code='$dept_code'");  
                    while($row = mysqli_fetch_array($result))
                    {
                    echo "
                    <tr>
                        <td>". $row['dept_name'] ."</td>
                        <td>". $row['model'] ."</td>
                        <td>". $row['unit'] ."</td>
                        <td>". $row['status'] ."</td>
                        <td>". $row['target_day'] ."</td>
                        <td>". $row['actual'] ."</td>
                        <td>". $row['balance'] ."</td>
                        <td>". $row['incharge_name'] ."</td>
                    </tr> ";
                    } 

                    $startDate->modify('+1 day');
                }
                    
            ?>
            </tbody>
        </table>
    </div>
</body>

</html>