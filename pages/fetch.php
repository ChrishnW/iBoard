<?php

    include "../include/connect.php";
    include "../include/auth.php";

    $date = date("Y-m-d");
    $result = mysqli_query($conn, "SELECT * FROM tbl_records WHERE date = '$date'");

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            
            $model = $row['model'];
            $unit = $row['unit'];
            $status = $row['status'];
            $targetPeDay = $row['target_day'];
            $target = $row['target_now'];
            $actual = $row['actual'];
            $balance = $row['balance'];

            echo "<tr>
                    <td class=\"font-weight-bold\">$model</td>
                    <td class=\"font-weight-bold\">$unit</td>
                    <td>$status</td>
                    <td>$targetPeDay</td>
                    <td>$target</td>
                    <td>$actual</td>
                    <td class=\"text-danger\">$balance</td>
                </tr>";
        }
    }






?>