<?php

    include "../include/connect.php";
    include "../include/auth.php";

    $query = "SELECT * FROM tbl_department";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        while($department = mysqli_fetch_assoc($result)){

            $dept_id = $department["id"];
            $dept_name = $department["dept_name"];
            $dept_code = $department["dept_code"];
            $status = $department["status"];
            $status_word = "";

            if($status == "1"){
                $status_word = "Active";
            }
            else{
                $status_word = "Inactive";
            }

            echo "<tr>
                    <td>$dept_id</td>
                    <td>$dept_name</td>
                    <td>$dept_code</td>
                    <td>$status_word</td>
                    <td>
                        <form action=\"department.php\" method=\"post\" class=\"form_table ml-2\">
                        <input type=\"hidden\" name=\"id_department\" value=\"$dept_id\">

                            <input type=\"submit\" id=\"edit_depatment\" class=\"btn btn-primary\" value=\"Edit\" name=\"edit_department\">
                            <input type=\"submit\" id=\"delete_department\" class=\"btn btn-danger\" value=\"Delete\" name=\"delete_department\">

                        </form>

                    </td>
                </tr>";

        }
    }

?>