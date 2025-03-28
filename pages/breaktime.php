<?php include '../include/header.php'; 

  if(isset($_SESSION["message"])){

    $message = $_SESSION["message"];

    echo "<script> document.addEventListener('DOMContentLoaded', function () {
    
      document.getElementById('display_message').innerHTML = '$message'; 

      const popup = document.getElementById('popup');
      popup.style.display = 'block';
      
    }); </script>";

    echo "<script> document.addEventListener('DOMContentLoaded', function () {

      var breaktime_dashboard = document.getElementById('breaktime_dashboard');
      breaktime_dashboard.style.display = 'block';

      var add_breaktime = document.getElementById('add_breaktime');
      add_breaktime.style.display = 'none';

    }); </script>";

    unset($_SESSION["message"]);
  }

  // Delete Breaktime Ask Display --------------------------------------------------------------------------

  if(isset($_SESSION["delete_id_breaktime"])){

    $break_id = $_SESSION["delete_id_breaktime"];
    $_SESSION["delete_break"] = $break_id;

    echo "<script> document.addEventListener('DOMContentLoaded', function () {

        var popup = document.getElementById('popupFormDelete');
        popup.style.display = 'block';

    }); </script>";

    echo "<script> document.addEventListener('DOMContentLoaded', function () {

        var breaktime_dashboard = document.getElementById('breaktime_dashboard');
        breaktime_dashboard.style.display = 'block';

    }); </script>";

    unset($_SESSION["delete_id_breaktime"]);

  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Add Breaktime ------------------------------------------------------------------------------

    if(isset($_POST["add_breaktime"])){

      $code = filter_input(INPUT_POST, "break_code", FILTER_SANITIZE_SPECIAL_CHARS);

      $tool_start = filter_input(INPUT_POST, "tool_start", FILTER_SANITIZE_SPECIAL_CHARS);
      $tool_end = filter_input(INPUT_POST, "tool_end", FILTER_SANITIZE_SPECIAL_CHARS);

      $start_am = filter_input(INPUT_POST, "break_start_am", FILTER_SANITIZE_SPECIAL_CHARS);
      $end_am = filter_input(INPUT_POST, "break_end_am", FILTER_SANITIZE_SPECIAL_CHARS);

      $start_lunch = filter_input(INPUT_POST, "break_start_lunch", FILTER_SANITIZE_SPECIAL_CHARS);
      $end_lunch = filter_input(INPUT_POST, "break_end_lunch", FILTER_SANITIZE_SPECIAL_CHARS);

      $start_pm = filter_input(INPUT_POST, "break_start_pm", FILTER_SANITIZE_SPECIAL_CHARS);
      $end_pm = filter_input(INPUT_POST, "break_end_pm", FILTER_SANITIZE_SPECIAL_CHARS);

      $start_ot = filter_input(INPUT_POST, "break_start_ot", FILTER_SANITIZE_SPECIAL_CHARS);
      $end_ot = filter_input(INPUT_POST, "break_end_ot", FILTER_SANITIZE_SPECIAL_CHARS);

      $status = "1";

      $sql_command = "INSERT INTO tbl_breaktime (breaktime_code, tool_box_meeting_start, tool_box_meeting_end,
                      am_break_start, am_break_end, lunch_break_start, lunch_break_end, pm_break_start, 
                      pm_break_end, ot_break_start, ot_break_end, status)
                      VALUES ('$code', '$tool_start', '$tool_end', '$start_am', '$end_am', '$start_lunch', '$end_lunch', 
                      '$start_pm', '$end_pm', '$start_ot', '$end_ot', '$status')";

      $result = mysqli_query($conn, $sql_command);

      if($result){
        $_SESSION["message"] = "Breaktime added successfully.";
      }
      else{
        $_SESSION["message"] = "Failed to add breaktime.";
      }

      header("Refresh: .3; url = breaktime.php");
      exit;

    }

    // Delete Breaktime Ask --------------------------------------------------------------------------

    if(isset($_POST["delete_breaktime"])){

      $_SESSION["delete_id_breaktime"] = filter_input(INPUT_POST, "id_breaktime", FILTER_SANITIZE_SPECIAL_CHARS);

      header("Refresh: .3; url = breaktime.php");
      exit;

    } 

    // Delete Breaktime Confirm --------------------------------------------------------------------------

    if(isset($_POST["delete_data"])){

      $break_id = $_SESSION["delete_break"];

      $sql_command = "DELETE FROM tbl_breaktime WHERE id = '$break_id'";
      $result = mysqli_query($conn, $sql_command);

      if($result){
        $_SESSION["message"] = "Breaktime deleted successfully.";
      }
      else{
        $_SESSION["message"] = "Failed to delete breaktime.";
      }
      
      unset($_SESSION["delete_break"]);
      
      header("Refresh: .3; url = breaktime.php");
      exit;

    }

    // Edit Breaktime Ask --------------------------------------------------------------------------

    if(isset($_POST["edit_breaktime"])){

      $break_id = filter_input(INPUT_POST, "id_breaktime", FILTER_SANITIZE_SPECIAL_CHARS);

      $_SESSION["edit_id_breaktime"] = $break_id;

      header("Refresh: .3; url = breaktime.php");
      exit;

    }

    // Edit Breaktime Submit --------------------------------------------------------------------------

    if(isset($_POST["edit_breaktime_submit"])){

      $id = filter_input(INPUT_POST, "edit_break_id", FILTER_SANITIZE_SPECIAL_CHARS);

      $code = filter_input(INPUT_POST, "edit_break_code", FILTER_SANITIZE_SPECIAL_CHARS);
      
      $tool_start = filter_input(INPUT_POST, "edit_tool_start", FILTER_SANITIZE_SPECIAL_CHARS);
      $tool_end = filter_input(INPUT_POST, "edit_tool_end", FILTER_SANITIZE_SPECIAL_CHARS);

      $start_am = filter_input(INPUT_POST, "edit_break_start_am", FILTER_SANITIZE_SPECIAL_CHARS);
      $end_am = filter_input(INPUT_POST, "edit_break_end_am", FILTER_SANITIZE_SPECIAL_CHARS);

      $start_lunch = filter_input(INPUT_POST, "edit_break_start_lunch", FILTER_SANITIZE_SPECIAL_CHARS);
      $end_lunch = filter_input(INPUT_POST, "edit_break_end_lunch", FILTER_SANITIZE_SPECIAL_CHARS);

      $start_pm = filter_input(INPUT_POST, "edit_break_start_pm", FILTER_SANITIZE_SPECIAL_CHARS);
      $end_pm = filter_input(INPUT_POST, "edit_break_end_pm", FILTER_SANITIZE_SPECIAL_CHARS);

      $start_ot = filter_input(INPUT_POST, "edit_break_start_ot", FILTER_SANITIZE_SPECIAL_CHARS);
      $end_ot = filter_input(INPUT_POST, "edit_break_end_ot", FILTER_SANITIZE_SPECIAL_CHARS);

      $status = filter_input(INPUT_POST, "edit_break_status", FILTER_SANITIZE_SPECIAL_CHARS);

      $sql_command = "UPDATE tbl_breaktime SET breaktime_code = '$code', tool_box_meeting_start = '$tool_start',
                      tool_box_meeting_end = '$tool_end', am_break_start = '$start_am', am_break_end = '$end_am',
                      lunch_break_start = '$start_lunch', lunch_break_end = '$end_lunch', pm_break_start = '$start_pm', 
                      pm_break_end = '$end_pm', ot_break_start = '$start_ot', ot_break_end = '$end_ot', status = '$status' 
                      WHERE id = '$id' ";

      $result = mysqli_query($conn, $sql_command);

      if($result){
        $_SESSION["message"] = "Breaktime updated successfully.";
      }
      else{
        $_SESSION["message"] = "Failed to update breaktime.";
      }

      header("Refresh: .3; url = breaktime.php");
      exit;

    }

  }
  
?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <div id="breaktime_dashboard" class="breaktime_dashboard" style="display: block;">

    <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
          <h2 class="float-left">Breaktime List</h2>
          <button id="btn_add_breaktime" type="button" class="btn btn-primary float-right">
            <i class="fa fa-plus pr-2"></i> Add Breaktime
          </button>
          <div class="clearfix"></div>
      </div>
        
      <div class="card-body">
        <div class="table-responsive">
          
            <table class="table table-bordered table-striped" id="dataTable" width="200%" cellspacing="0">
            
              <thead class="bg-primary text-white text-center" style="font-size: 0.7rem; text-align: center; padding: 0;">

                <tr>
                  <th class="text-center align-middle" style="font-size: 0.75rem; text-align: center; width: 8%;">Breaktime Code</th>

                  <th class="text-center align-middle" style="font-size: 0.75rem; text-align: center; width: 8%;">Tool Box Meeting Start</th>
                  <th class="text-center align-middle" style="font-size: 0.75rem; text-align: center; width: 8%;">Tool Box Meeting End</th>

                  <th class="text-center align-middle" style="font-size: 0.75rem; text-align: center; width: 8%;">Breaktime Start (AM)</th>
                  <th class="text-center align-middle" style="font-size: 0.75rem; text-align: center; width: 8%;">Breaktime End (AM)</th>

                  <th class="text-center align-middle" style="font-size: 0.75rem; text-align: center; width: 8%;">Breaktime Start (Lunch)</th>
                  <th class="text-center align-middle" style="font-size: 0.75rem; text-align: center; width: 8%;">Breaktime End (Lunch)</th>

                  <th class="text-center align-middle" style="font-size: 0.75rem; text-align: center; width: 8%;">Breaktime Start (PM)</th>
                  <th class="text-center align-middle" style="font-size: 0.75rem; text-align: center; width: 8%;">Breaktime End (PM)</th>

                  <th class="text-center align-middle" style="font-size: 0.75rem; text-align: center; width: 8%;">Breaktime Start (OT)</th>
                  <th class="text-center align-middle" style="font-size: 0.75rem; text-align: center; width: 8%;">Breaktime End (OT)</th>

                  <th class="text-center align-middle" style="font-size: 0.75rem; text-align: center; width: 8%;">Status</th>

                  <th class="text-center align-middle" style="font-size: 0.75rem; text-align: center; width: 8%;">Actions</th>
                </tr>

              </thead>

              <tbody id="insert_here">
                
                <?php
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
                ?>

                <tr>
                    <td style="font-size: 1rem;"><?php echo $breaktime_code ?></td>

                    <td style="font-size: 1rem;"><?php echo $tool_start ?></td>
                    <td style="font-size: 1rem;"><?php echo $tool_end ?></td>

                    <td style="font-size: 1rem;"><?php echo $am_start ?></td>
                    <td style="font-size: 1rem;"><?php echo $am_end ?></td>
                    
                    <td style="font-size: 1rem;"><?php echo $lunch_start ?></td>
                    <td style="font-size: 1rem;"><?php echo $lunch_end ?></td>
                    <td style="font-size: 1rem;"><?php echo $pm_start ?></td>
                    <td style="font-size: 1rem;"><?php echo $pm_end ?></td>
                    <td style="font-size: 1rem;"><?php echo $ot_start ?></td>
                    <td style="font-size: 1rem;"><?php echo $ot_end ?></td>
                    <td style="font-size: 1rem;"><?php echo $status_word ?></td>
                    <td class="text-center align-middle">
                      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="justify-content-center form_table d-flex">

                        <input type="hidden" name="id_breaktime" value="<?php echo $breaktime_id ?>">

                        <input type="submit" class="btn btn-primary btn-sm mr-1 ml-n4" name="edit_breaktime" value="Edit">
                        <input type="submit" class="btn btn-danger btn-sm mr-n4" name="delete_breaktime" value="Delete">

                      </form>
                    </td>
                </tr>

                <?php
                    }
                  }
                ?>

              </tbody>

            </table>

        </div>
        
      </div>
    </div>
  </div>

  <!-- Add Breaktime -->

  <div id="add_breaktime" class="add_breaktime" style="display: none;">

    <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
        <h2 class="float-left">Add Breaktime</h2>
          <div class="clearfix"></div>
      </div>

      <div class="card-body shadow-sm m-5 p-5 d-flex justify-content-center align-items-center">
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" style="width: 100%; max-width: 600px;">
      
          <div id="breaktime">
            <div class="mb-3">
              <label for="break_code">Breaktime Code <span style="color: red;">*</span></label>
              <input type="text" class="form-control" name="break_code" id="break_code" placeholder="101" required>
            </div>

            <div class="card mb-4">
              <div class="card-body">

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="tool_start">Tool Box Meeting Start <span style="color: red;">*</span></label><br>
                    <input type="time" class="form-control" name="tool_start" id="tool_start" placeholder="00:00" required>
                  </div>

                  <div class="col-md-6">
                    <label for="tool_end">Tool Box Meeting End <span style="color: red;">*</span></label><br>
                    <input type="time" class="form-control" name="tool_end" id="tool_end" placeholder="00:00" required>
                  </div>
                </div>

                <div id="breaktime_am" class="row mb-3">
                  <div class="col-md-6">
                    <label for="break_start_am">Breaktime Start (AM) <span style="color: red;">*</span></label><br>
                    <input type="time" class="form-control" name="break_start_am" id="break_start_am" placeholder="00:00" required>
                    
                  </div>
                  
                  <div class="col-md-6">
                    <label for="break_end_am">Breaktime End (AM) <span style="color: red;">*</span></label><br>
                    <input type="time" class="form-control" name="break_end_am" id="break_end_am" placeholder="00:00" required>
                  </div>
                </div>

                <div id="breaktime_lunch" class="row mb-3">
                  <div class="col-md-6">
                    <label for="break_start_lunch">Breaktime Start (Lunch) <span style="color: red;">*</span></label> <br>
                    <input type="time" class="form-control" name="break_start_lunch" id="break_start_lunch" placeholder="00:00" required>
                  </div>
                  
                  <div class="col-md-6">
                    <label for="break_end_lunch">Breaktime End (Lunch) <span style="color: red;">*</span></label><br>
                    <input type="time" class="form-control" name="break_end_lunch" id="break_end_lunch" placeholder="00:00" required>
                  </div>
                </div>

                <div id="breaktime_pm" class="row mb-3">
                  <div class="col-md-6">
                   <label for="break_start_pm">Breaktime Start (PM) <span style="color: red;">*</span></label><br>
                    <input type="time" class="form-control" name="break_start_pm" id="break_start_pm" placeholder="00:00" required>
                  </div>
                  
                  <div class="col-md-6">
                    <label for="break_end_pm">Breaktime End (PM) <span style="color: red;">*</span></label><br>
                    <input type="time" class="form-control" name="break_end_pm" id="break_end_pm" placeholder="00:00" required>
                  </div>
                </div>

                <div id="breaktime_ot" class="row mb-3">
                  <div class="col-md-6">
                    <label for="break_start_ot">Breaktime Start (OT) <span style="color: red;">*</span></label><br>
                    <input type="time" class="form-control" name="break_start_ot" id="break_start_ot" placeholder="00:00" required>
                  </div>

                  <div class="col-md-6">
                    <label for="break_end_ot">Breaktime End (OT) <span style="color: red;">*</span></label>
                    <input type="time" class="form-control" name="break_end_ot" id="break_end_ot" placeholder="00:00" required>                  
                  </div>
                </div>
              </div>
            </div>

          <div class="d-flex justify-content-left">
            <input type="submit" name="add_breaktime" value="Add Breaktime" class="btn btn-primary pr-3">
            <input type="reset" name="reset" value="Cancel" id="cancel_add_breaktime"  class="btn btn-secondary ml-2">
          </div> 
        </div>
        
      </form>
    </div>
  </div>
</div>


<!-- Edit Breaktime -->

  <div id="edit_breaktime" class="edit_dashboard" style="display: none;">
      
    <div class="card shadow mb-4">

      <div class="card-header py-3.5 pt-4">

        <h2 class="float-left">Edit Breaktime</h2>
        
        <div class="clearfix"></div>

      </div>
    
      <div class="card-body shadow-sm m-5 p-5 d-flex justify-content-center align-items-center">

        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" id="edit_breaktime_form" method="post" style="width: 100%; max-width: 600px;">
          
          <?php

            if(isset($_SESSION["edit_id_breaktime"])){

              $break_id = $_SESSION["edit_id_breaktime"];
          
              $sql_command = "SELECT * FROM tbl_breaktime WHERE id = '$break_id'";
              $result = mysqli_query($conn, $sql_command);
          
              if(mysqli_num_rows($result) > 0){
                $break = mysqli_fetch_assoc($result);
          
                $break_code = $break["breaktime_code"];
          
                $tool_start = $break["tool_box_meeting_start"];
                $tool_end = $break["tool_box_meeting_end"];
          
                $am_start = $break["am_break_start"];
                $am_end = $break["am_break_end"];
          
                $lunch_start = $break["lunch_break_start"];
                $lunch_end = $break["lunch_break_end"];
          
                $pm_start = $break["pm_break_start"];
                $pm_end = $break["pm_break_end"];
          
                $ot_start = $break["ot_break_start"];
                $ot_end = $break["ot_break_end"];
          
                $status = $break["status"];
          
                $status_word = "";
          
                if($status == "1"){
                  $status_word = "Active";
                }
                else{
                  $status_word = "Inactive";
                }
          
                echo '<script> document.addEventListener("DOMContentLoaded", function () {
          
                  var breaktime_dashboard = document.getElementById("breaktime_dashboard");
                  breaktime_dashboard.style.display = "none";
          
                  var add_breaktime = document.getElementById("add_breaktime");
                  add_breaktime.style.display = "none";
          
                  var edit_breaktime = document.getElementById("edit_breaktime");
                  edit_breaktime.style.display = "block";
          
                }); </script>';
          ?>

          <input type="hidden" name="edit_break_id" id="edit_break_id" value="<?php echo $break_id ?>">

          <div class="mb-3">
            <label for="edit_break_code">Breaktime Code <span style="color: red;">*</span></label>
            <input type="text" class="form-control" name="edit_break_code" id="edit_break_code" required value="<?php echo $break_code ?>">
          </div>

          <div class="card mb-4">
            <div class="card-boy">
              <div id="tool_meeting" class="row mb-3">
                <div class="col-md-6">
                  <label for="edit_tool_start">Tool Box Meeting Start <span style="color: red;">*</span></label><br>
                  <input type="time" class="form-control" name="edit_tool_start" id="edit_tool_start" required value="<?php echo $tool_start ?>">        
                </div>
                
                <div class="col-md-6">
                  <label for="edit_tool_end">Tool Box Meeting End <span style="color: red;">*</span></label><br>
                  <input type="time" class="form-control" name="edit_tool_end" id="edit_tool_end" required value="<?php echo $tool_end ?>">        
                </div>
              </div>


              <div id="breaktime_am" class="row mb-3">
                <div class="col-md-6">

                  <label for="edit_break_start_am">Breaktime Start (AM) <span style="color: red;">*</span></label><br>
                  <input type="time" class="form-control" name="edit_break_start_am" id="edit_break_start_am" required value="<?php echo $am_start ?>">
                  
                </div>
                
                <div class="col-md-6">
                  <label for="edit_break_end_am">Breaktime End (AM) <span style="color: red;">*</span></label><br>
                  <input type="time" class="form-control" name="edit_break_end_am" id="edit_break_end_am" required value="<?php echo $am_end ?>">
                </div>
              </div>

              <div id="breaktime_lunch" class="row mb-3">
                <div class="col-md-6">
                  <label for="edit_break_start_lunch">Breaktime Start (Lunch) <span style="color: red;">*</span></label> <br>
                  <input type="time" class="form-control" name="edit_break_start_lunch" id="edit_break_start_lunch" required value="<?php echo $lunch_start ?>">
                </div>
                
                <div class="col-md-6">
                  <label for="edit_break_end_lunch">Breaktime End (Lunch) <span style="color: red;">*</span></label><br>
                  <input type="time" class="form-control" name="edit_break_end_lunch" id="edit_break_end_lunch" required value="<?php echo $lunch_end ?>">
                </div>
              </div>

              <div id="breaktime_pm" class="row mb-3">
                <div class="col-md-6">
                  <label for="edit_break_start_pm">Breaktime Start (PM) <span style="color: red;">*</span></label><br>
                  <input type="time" class="form-control" name="edit_break_start_pm" id="edit_break_start_pm" required value="<?php echo $pm_start ?>">
                </div>
                
                <div class="col-md-6">
                  <label for="edit_break_end_pm">Breaktime End (PM) <span style="color: red;">*</span></label><br>
                  <input type="time" class="form-control" name="edit_break_end_pm" id="edit_break_end_pm" required value="<?php echo $pm_end ?>">
                </div>
              </div>

              <div id="breaktime_ot" class="row mb-3">
                <div class="col-md-6">
                  <label for="edit_break_start_ot">Breaktime Start (OT) <span style="color: red;">*</span></label><br>
                  <input type="time" class="form-control" name="edit_break_start_ot" id="edit_break_start_ot" required value="<?php echo $ot_start ?>">
                </div>

                <div class="col-md-6">
                  <label for="edit_break_end_ot">Breaktime End (OT) <span style="color: red;">*</span></label>
                  <input type="time" class="form-control" name="edit_break_end_ot" id="edit_break_end_ot" required value="<?php echo $ot_end ?>">                  
                </div>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="edit_break_status" class="form-label">Status <span style="color: red;">*</span></label>
            <select name="edit_break_status" id="edit_break_status" class="form-control" required> 
              <option value="<?php echo $status ?>" hidden><?php echo $status_word ?></option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select> 
          </div>
        
          <div class="d-flex justify-content-left">
            <input type="submit" name="edit_breaktime_submit" value="Save" class="btn btn-primary pr-3">
            <input type="reset" name="cancel_breaktime" value="Cancel" id="cancel_breaktime"  class="btn btn-secondary ml-2">
          </div> 

          <?php

                }

              unset($_SESSION["edit_id_breaktime"]);
            }
        
          ?>
          
        
        </form>

      </div>

    </div>
  </div>

<!-- Pop up Modal -->

<div class="modal" tabindex="-1" id="popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5);">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_popup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body my-2">
        <p class="h5" id="display_message"></p>
      </div>
    </div>
  </div>
</div> 

<!-- Pop up for Delete -->

<div class="modal" tabindex="-1" id="popupFormDelete" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5);">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger">Delete Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_popup2">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <p class="h5">Are you sure you want to delete this breaktime permanently?</p> 
      </div>

      <div class="modal-footer">
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
          <input type="submit" name="delete_data" value="Confirm" class="submit btn btn-danger pr-3"> 
          <a href="#" onclick="closePopup2()" class="close_popup btn btn-secondary" style="text-decoration: none;">Cancel</a>
        </form>
      </div>

    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->
<?php include '../include/footer.php'; ?>

<script>

  $(document).ready(function(){
    $('#dataTable').DataTable();
  });

  // function updateTable() {
  //     $.ajax({
  //         method: 'POST',
  //         url: 'fetch_breaktime.php',
  //         data: { page: currentPage },
  //         success: function (data) {
  //             document.getElementById('insert_here').innerHTML = data;
  //             console.log("Success");
  //         },
  //         error: function () {
  //             console.log("Error");
  //         }
  //     });
  // }

  

  document.addEventListener('DOMContentLoaded', function () {
    
    // updateTable();

    document.getElementById('close_popup').addEventListener('click', function () {
      document.getElementById('popup').style.display = 'none';
    });

    document.getElementById('close_popup2').addEventListener('click', function () {
      document.getElementById('popupFormDelete').style.display = 'none';
    });

    const btn_add_breaktime = document.getElementById('btn_add_breaktime');
    const breaktime_dashboard = document.getElementById('breaktime_dashboard');
    const add_breaktime = document.getElementById('add_breaktime');
    const cancel_add_breaktime = document.getElementById('cancel_add_breaktime');

    edit_breaktime = document.getElementById('edit_breaktime');
    cancel_breaktime = document.getElementById('cancel_breaktime');

    btn_add_breaktime.addEventListener('click', function () {
      breaktime_dashboard.style.display = 'none';
      add_breaktime.style.display = 'block';
    });

    cancel_add_breaktime.addEventListener('click', function () {
      breaktime_dashboard.style.display = 'block';
      add_breaktime.style.display = 'none';
    });

    cancel_breaktime.addEventListener('click', function () {
      breaktime_dashboard.style.display = 'block';
      edit_breaktime.style.display = 'none';
    });

  });

  const popup2 = document.getElementById("popupFormDelete");

  function closePopup2() {
    popup2.style.display = "none";
  }

</script>