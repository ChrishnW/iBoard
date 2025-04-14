<?php
    include '../include/connect.php'; 
    session_start();
    $today = date('Y-m-d');
    header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=Output_Records_".$today.".xls");
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
        <div style="font-family: Arial, sans-serif; text-align: center; margin-bottom: 20px;">
            <br>
            <b style="font-size: 30px; color: #007bff;">GLORY (PHILIPPINES), INC.</b>
            <br>
            <b style="font-size: 20px; color: #333;">i-Board System</b>
            <br>
            <br>
            <h3 style="font-size: 28px; color: #555; margin-top: 10px;"><b>Output Records</b></h3>
        </div>
    </center>
    <br>

    <div id="table-scroll">
        <table border="1" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #333; color: white; padding: 8px; text-align: center; font-weight: bold;">
                    <th>Date</th>
                    <th>Department</th>
                    <th>Building</th>
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

                    $startDate = new DateTime($start);
                    $endDate = new DateTime($end);
                    $j = 0;

                    for($i = 1; $i <= $_SESSION['gap']; $i++){

                        $formattedDate = $startDate->format('Y-m-d');

                        $conn->next_result();
                        $result = mysqli_query($conn,"SELECT tbl_line.building, tbl_records.date, tbl_department.dept_name, tbl_records.model,tbl_records.unit, tbl_records.status, tbl_records.target_day, tbl_records.actual, tbl_records.balance, tbl_line.incharge_name FROM tbl_records INNER JOIN tbl_line ON tbl_line.line_name=tbl_records.unit INNER JOIN tbl_accounts ON tbl_accounts.username=tbl_records.model INNER JOIN tbl_department ON tbl_department.dept_code=tbl_accounts.dept_code WHERE tbl_records.date='$formattedDate'");  
                        while($row = mysqli_fetch_array($result))
                        {
                            $j++;
                        echo "
                        <tr style='background-color: ". (($j % 2 == 0) ? "#d1e7dd" : "#f8f9fa") .";'>
                            <td style='text-align: left;'>". $row['date'] ."</td>
                            <td style='text-align: left;'>". $row['dept_name'] ."</td>
                            <td style='text-align: left;'>". $row['building'] ."</td>
                            <td style='text-align: left;'>". $row['model'] ."</td>
                            <td style='text-align: left;'>". $row['unit'] ."</td>
                            <td style='text-align: left;'>". $row['status'] ."</td>
                            <td style='text-align: left;'>". $row['target_day'] ."</td>
                            <td style='text-align: left;'>". $row['actual'] ."</td>
                            <td style='text-align: left;'>". $row['balance'] ."</td>
                            <td style='text-align: left;'>". $row['incharge_name'] ."</td>
                        </tr>";
                        } 

                        $startDate->modify('+1 day');
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
