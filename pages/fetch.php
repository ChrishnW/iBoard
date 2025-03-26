<?php

    include "../include/connect.php";
    include "../include/auth.php";

    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $rowsPerPage = 10; // Number of rows per page
    $offset = ($page - 1) * $rowsPerPage;

    $dept_code = $_SESSION['department_code'];
    $date = date("Y-m-d");
    
    $sql_command = "SELECT * FROM tbl_accounts WHERE dept_code = '$dept_code'";
    $result = mysqli_query($conn, $sql_command);

    if(mysqli_num_rows($result) > 0){
        while($account = mysqli_fetch_assoc($result)){
            $username = $account['username'];

            $query = "SELECT * FROM tbl_records WHERE date = '$date' && model = '$username' LIMIT $offset, $rowsPerPage";
            $result1 = mysqli_query($conn, $query);

            if(mysqli_num_rows($result1) > 0){
                while($row = mysqli_fetch_assoc($result1)){
                    
                    $model = $row['model'];
                    $unit = $row['unit'];
                    $status = $row['status'];
                    $targetPeDay = $row['target_day'];
                    $target = $row['target_now'];
                    $actual = $row['actual'];
                    $balance = $row['balance'];

                    echo "<tr>
                            <td class=\"font-weight-bold\" style=\"height: 40px;\">$model</td>
                            <td class=\"font-weight-bold\" style=\"height: 40px;\">$unit</td>
                            <td style=\"height: 40px;\">$status</td>
                            <td style=\"height: 40px;\">$targetPeDay</td>
                            <td style=\"height: 40px;\">$target</td>
                            <td style=\"height: 40px;\">$actual</td>
                            <td class=\"text-danger\" style=\"height: 40px;\">$balance</td>
                        </tr>";
                }
            }
            else{
                $blank = "";
                $model = $username;
                echo "<tr>
                        <td class=\"font-weight-bold\" style=\"height: 40px;\">$model</td>
                        <td class=\"font-weight-bold\" style=\"height: 40px;\">$blank</td>
                        <td style=\"height: 40px;\">$blank</td>
                        <td style=\"height: 40px;\">$blank</td>
                        <td style=\"height: 40px;\">$blank</td>
                        <td style=\"height: 40px;\">$blank</td>
                        <td class=\"text-danger\" style=\"height: 40px;\">$blank</td>
                    </tr>";
            }



        }
    }

    

    // Add total page calculation for pagination 
    $totalRowsQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_records WHERE date = '$date'");
    $totalRows = mysqli_fetch_assoc($totalRowsQuery)['total'];
    $totalPages = ceil($totalRows / $rowsPerPage);

    echo "<input type=\"hidden\" id=\"totalPages\" value=\"$totalPages\">";
?>