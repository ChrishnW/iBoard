<?php

    include "../include/connect.php";
    include "../include/auth.php";

    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $rowsPerPage = 5; // Number of rows per page
    $offset = ($page - 1) * $rowsPerPage;

   
    
    // $sql_command = "SELECT * FROM tbl_accounts WHERE dept_code = '$dept_code'";
    // $result = mysqli_query($conn, $sql_command);

    // if(mysqli_num_rows($result) > 0){
    //     while($account = mysqli_fetch_assoc($result)){
    //         $username = $account['username'];

    //         $query = "SELECT * FROM tbl_records WHERE date = '$date' && model = '$username' LIMIT $offset, $rowsPerPage";
    //         $result1 = mysqli_query($conn, $query);

    //         if(mysqli_num_rows($result1) > 0){
    //             while($row = mysqli_fetch_assoc($result1)){
                    
    //                 $model = $row['model'];
    //                 $unit = $row['unit'];
    //                 $status = $row['status'];
    //                 $targetPeDay = $row['target_day'];
    //                 $target = $row['target_now'];
    //                 $actual = $row['actual'];
    //                 $balance = $row['balance'];

    //                 echo "<tr>
    //                         <td class=\"font-weight-bold\" style=\"height: 40px;\">$model</td>
    //                         <td class=\"font-weight-bold\" style=\"height: 40px;\">$unit</td>
    //                         <td style=\"height: 40px;\">$status</td>
    //                         <td style=\"height: 40px;\">$targetPeDay</td>
    //                         <td style=\"height: 40px;\">$target</td>
    //                         <td style=\"height: 40px;\">$actual</td>
    //                         <td class=\"text-danger\" style=\"height: 40px;\">$balance</td>
    //                     </tr>";
    //             }
    //         }



    //     }
    // }

    function getDepartmentName_string($dept_code){
    
        global $conn;
    
        $sql_command = "SELECT dept_name FROM tbl_department WHERE dept_code = '$dept_code'";
        $result = mysqli_query($conn, $sql_command);
    
        if(mysqli_num_rows($result) > 0){
            $department = mysqli_fetch_assoc($result);
            return $department["dept_name"];
        }
        else{
            return "N/A";
        }
    }

    $sql_command = "SELECT * FROM tbl_accounts WHERE access = '2' LIMIT $offset, $rowsPerPage";
    $result = mysqli_query($conn, $sql_command);

    if(mysqli_num_rows($result) > 0){
        while($account = mysqli_fetch_assoc($result)){

            $acc_id = $account["id"];
            $username = $account["username"];
            $dept_code = $account["dept_code"];
            $status = $account["status"];
            $status_word = "";

            $dept_string = getDepartmentName_string($dept_code);

            if($status == "1"){
                $status_word = "Active";
            }
            else{
                $status_word = "Inactive";
            }

            echo "<tr>
                    <td>$acc_id</td>
                    <td>$username</td>
                    <td>$dept_string</td>
                    <td>$status_word</td>
                    <td>
                        <form action=\"account.php\" method=\"post\" class=\"form_table\">
                            <input type=\"hidden\" name=\"id_account\" value=\"$acc_id\">

                            <input type=\"submit\" class=\"edit btn btn-primary ml-2\" value=\"Edit\" name=\"edit_account\">
                            <input type=\"submit\" class=\"delete btn btn-danger\" value=\"Delete\" name=\"delete_account\">

                        </form>
                    </td>
                </tr>";

        }
    }

    

    // Add total page calculation for pagination 
    $totalRowsQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_accounts");
    $totalRows = mysqli_fetch_assoc($totalRowsQuery)['total'];
    $totalPages = ceil($totalRows / $rowsPerPage);

    echo "<input type=\"hidden\" id=\"totalPages\" value=\"$totalPages\">";
?>