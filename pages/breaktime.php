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





  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Add Account ------------------------------------------------------------------------------

    if(isset($_POST["add_breaktime"])){

      $code = filter_input(INPUT_POST, "break_code", FILTER_SANITIZE_SPECIAL_CHARS);

      $start_am = filter_input(INPUT_POST, "break_start_am", FILTER_SANITIZE_SPECIAL_CHARS);;
      $end_am = filter_input(INPUT_POST, "break_end_am", FILTER_SANITIZE_SPECIAL_CHARS);;

      $start_lunch = filter_input(INPUT_POST, "break_start_lunch", FILTER_SANITIZE_SPECIAL_CHARS);;
      $end_lunch = filter_input(INPUT_POST, "break_end_lunch", FILTER_SANITIZE_SPECIAL_CHARS);;

      $start_pm = filter_input(INPUT_POST, "break_start_pm", FILTER_SANITIZE_SPECIAL_CHARS);;
      $end_pm = filter_input(INPUT_POST, "break_end_pm", FILTER_SANITIZE_SPECIAL_CHARS);;

      $start_ot = filter_input(INPUT_POST, "break_start_ot", FILTER_SANITIZE_SPECIAL_CHARS);;
      $end_ot = filter_input(INPUT_POST, "break_end_ot", FILTER_SANITIZE_SPECIAL_CHARS);;

      $status = filter_input(INPUT_POST, "acc_status", FILTER_SANITIZE_SPECIAL_CHARS);;

      $sql_command = "INSERT INTO tbl_breaktime (breaktime_code, am_break_start, am_break_end, lunch_break_start, 
                      lunch_break_end, pm_break_start, pm_break_end, ot_break_start, ot_break_end, status)
                      VALUES ('$code', '$start_am', '$end_am', '$start_lunch', '$end_lunch', 
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




  }
  




?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <div id="breaktime_dashboard" class="breaktime_dashboard" style="display: block;">

    <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
          <h2 class="float-left">Breaktime List</h2>
          <button id="btn_add_breaktime" type="button" class="btn btn-primary float-right">Add Breaktime</button>
          <div class="clearfix"></div>
      </div>
        
      <div class="card-body">
        <div class="table-responsive">
          
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            
            <thead class="bg-primary text-white text-center" style="font-size: 0.75rem;">

              <tr>
              <th class="align-text-top">Breaktime Code</th>
              <th class="align-text-top">Breaktime Start (AM)</th>
              <th class="align-text-top">Breaktime End (AM)</th>
              <th class="align-text-top">Breaktime Start (Lunch)</th>
              <th class="align-text-top">Breaktime End (Lunch)</th>
              <th class="align-text-top">Breaktime Start (PM)</th>
              <th class="align-text-top">Breaktime End (PM)</th>
              <th class="align-text-top">Breaktime Start (OT)</th>
              <th class="align-text-top">Breaktime End (OT)</th>
              <th class="align-text-top">Status</th>
              <th></th>
              </tr>

            </thead>

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

            <div class="mb-3">
              <label for="acc_status" class="form-label">Status <span style="color: red;">*</span></label>
              <select name="acc_status" id="acc_status" class="form-control" required> 
                <option value="" hidden></option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select> 
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
        <form action="admin.php" method="post" style="width: 100%; max-width: 600px;">
      
          <div id="breaktime">
            <div class="mb-3">
              <label for="break_code">Breaktime Code</label>
              <input type="text" class="form-control" name="break_code" id="break_code" placeholder="101" required>
            </div>

            <div class="card mb-4">
              <div class="card-body">
                <div id="breaktime_am" class="row mb-3">
                  <div class="col-md-6">
                    <label for="break_start_am">Breaktime Start (AM)</label><br>
                    <input type="time" class="form-control" name="break_start_am" id="break_start_am" placeholder="00:00" required>
                    
                  </div>
                  
                  <div class="col-md-6">
                    <label for="break_end_am">Breaktime End (AM)</label><br>
                    <input type="time" class="form-control" name="break_end_am" id="break_end_am" placeholder="00:00" required>
                  </div>
                </div>

                <div id="breaktime_lunch" class="row mb-3">
                  <div class="col-md-6">
                    <label for="break_start_lunch">Breaktime Start (Lunch)</label> <br>
                    <input type="time" class="form-control" name="break_start_lunch" id="break_start_lunch" placeholder="00:00" required>
                  </div>
                  
                  <div class="col-md-6">
                    <label for="break_end_lunch">Breaktime End (Lunch)</label><br>
                    <input type="time" class="form-control" name="break_end_lunch" id="break_end_lunch" placeholder="00:00" required>
                  </div>
                </div>

                <div id="breaktime_pm" class="row mb-3">
                  <div class="col-md-6">
                   <label for="break_start_pm">Breaktime Start (PM)</label><br>
                    <input type="time" class="form-control" name="break_start_pm" id="break_start_pm" placeholder="00:00" required>
                  </div>
                  
                  <div class="col-md-6">
                    <label for="break_end_pm">Breaktime End (PM)</label><br>
                    <input type="time" class="form-control" name="break_end_pm" id="break_end_pm" placeholder="00:00" required>
                  </div>
                </div>

                <div id="breaktime_ot" class="row mb-3">
                  <div class="col-md-6">
                    <label for="break_start_ot">Breaktime Start (OT)</label><br>
                    <input type="time" class="form-control" name="break_start_ot" id="break_start_ot" placeholder="00:00" required>
                  </div>

                  <div class="col-md-6">
                    <label for="break_end_ot">Breaktime End (OT)</label>
                    <input type="time" class="form-control" name="break_end_ot" id="break_end_ot" placeholder="00:00" required>                  
                  </div>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="acc_status" class="form-label">Status <span style="color: red;">*</span></label>
              <select name="acc_status" id="acc_status" class="form-control" required> 
                <option value="" hidden></option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select> 
            </div>

            <div class="d-flex justify-content-left">
              <input type="submit" name="add_breaktime" value="Save" class="btn btn-primary pr-3">
              <input type="reset" name="reset" value="Cancel" id="cancel_breaktime"  class="btn btn-secondary ml-2">
            </div> 
          </div>
        </div>
      </form>
    </div>
  </div>

<!-- Pop up Modal -->

<div class="modal" tabindex="-1" id="popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5);">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>

        <button type="button" aria-hidden="true" class="fa fa-times" data-bs-dismiss="modal" aria-label="Close" id="close_popup"></button>
      </div>
      <div class="modal-body">

        <h5 id="display_message"></h5>

      </div>
      
    </div>
  </div>
</div> 


</div>
<!-- /.container-fluid -->
<?php include '../include/footer.php'; 

  // Display Account List----------------------------------------------------------------------------

  $sql_command = "SELECT * FROM tbl_breaktime";
  $result = mysqli_query($conn, $sql_command);

  if(mysqli_num_rows($result) > 0){
      while($breaktime = mysqli_fetch_assoc($result)){

        $breaktime_id = $breaktime["id"];

        $breaktime_code = $breaktime["breaktime_code"];
        $am_start = $breaktime["am_break_start"];
        $am_end = $breaktime["am_break_end"];

        $lunch_start = $breaktime["lunch_break_end"];
        $lunch_end = $breaktime["lunch_break_end"];

        $pm_start = $breaktime["pm_break_end"];
        $pm_end = $breaktime["pm_break_end"];
        
        $ot_start = $breaktime["ot_break_end"];
        $ot_end = $breaktime["ot_break_end"];

        $status = $breaktime["status"];

        $status_word = "";

        if($status == "1"){
            $status_word = "Active";
        }
        else{
            $status_word = "Inactive";
        }

        echo '<script> document.addEventListener("DOMContentLoaded", function () {
            const table = `
            <tr>
                <td>' . $breaktime_code . '</td>
                <td>' . $am_start . '</td>
                <td>' . $am_end . '</td>
                
                <td>' . $lunch_start . '</td>
                <td>' . $lunch_end . '</td>
                <td>' . $pm_start . '</td>
                <td>' . $pm_end . '</td>
                <td>' . $ot_start . '</td>
                <td>' . $ot_end . '</td>
                <td>' . $status_word . '</td>
                <td>
                    <form action="breaktime.php" method="post" class="form_table d-flex justify-content-between">
                      <input type="hidden" name="id_breaktime" value="<?php echo $breaktime_id; ?>">
                      <button type="submit" class="btn btn-primary btn-sm mr-1" name="edit_breaktime"">Edit</button>
                      <button type="submit" class="btn btn-danger btn-sm" name="delete_breaktime">Delete</button>
                    </form>
                    </form>
                </td>
            </tr>`;
            
            document.querySelector("#dataTable").insertAdjacentHTML("beforeend", table);
        });</script>';

      }
  }






?>


<script>

  document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('close_popup').addEventListener('click', function () {
      document.getElementById('popup').style.display = 'none';
    });


    const btn_add_breaktime = document.getElementById('btn_add_breaktime');
    const breaktime_dashboard = document.getElementById('breaktime_dashboard');
    const add_breaktime = document.getElementById('add_breaktime');
    const cancel_add_breaktime= document.getElementById('cancel_add_breaktime');


    btn_add_breaktime.addEventListener('click', function () {
      breaktime_dashboard.style.display = 'none';
      add_breaktime.style.display = 'block';
    });

    cancel_add_breaktime.addEventListener('click', function () {
      breaktime_dashboard.style.display = 'block';
      add_breaktime.style.display = 'none';
    });






  });








</script>