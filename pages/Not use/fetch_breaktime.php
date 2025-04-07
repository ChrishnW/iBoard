<?php

    include "../include/connect.php";
    include "../include/auth.php";

    $sql_command = "SELECT * FROM tbl_breaktime ";
    $result = mysqli_query($conn, $sql_command);

    if(mysqli_num_rows($result) > 0){
        while($breaktime = mysqli_fetch_assoc($result)){

            $breaktime_id = $breaktime["id"];

            $breaktime_code = $breaktime["breaktime_code"];

            $tool_start = $breaktime["tool_box_meeting_start"];
            $tool_end = $breaktime["tool_box_meeting_end"];

            $am_start = $breaktime["am_break_start"];
            $am_end = $breaktime["am_break_end"];

            $lunch_start = $breaktime["lunch_break_start"];
            $lunch_end = $breaktime["lunch_break_end"];

            $pm_start = $breaktime["pm_break_start"];
            $pm_end = $breaktime["pm_break_end"];
            
            $ot_start = $breaktime["ot_break_start"];
            $ot_end = $breaktime["ot_break_end"];

            $status = $breaktime["status"];

            $status_word = "";

            if($status == "1"){
                $status_word = "Active";
            }
            else{
                $status_word = "Inactive";
            }

            echo "<tr>
                    <td>$breaktime_code</td>

                    <td>$tool_start</td>
                    <td>$tool_end</td>

                    <td>$am_start</td>
                    <td>$am_end</td>
                    
                    <td>$lunch_start</td>
                    <td>$lunch_end</td>
                    <td>$pm_start</td>
                    <td>$pm_end</td>
                    <td>$ot_start</td>
                    <td>$ot_end</td>
                    <td>$status_word</td>
                    <td>
                        <form action=\"breaktime.php\" method=\"post\" class=\"form_table d-flex justify-content-between\">

                        <input type=\"hidden\" name=\"id_breaktime\" value=\"$breaktime_id\">

                        <input type=\"submit\" class=\"btn btn-primary btn-sm mr-1\" name=\"edit_breaktime\" value=\"Edit\">
                        <input type=\"submit\" class=\"btn btn-danger btn-sm\" name=\"delete_breaktime\" value=\"Delete\">

                        </form>
                    </td>
                </tr>";

        }
    }

?>