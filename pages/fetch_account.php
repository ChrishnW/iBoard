<?php

    include "../include/connect.php";
    include "../include/auth.php";

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

    $sql_command = "SELECT * FROM tbl_accounts WHERE access = '2'";
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


?>