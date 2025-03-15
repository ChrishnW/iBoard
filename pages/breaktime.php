<?php include '../include/header.php'; ?>
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
          
          <table class=" table table-bordered" id="dataTable" width="100%" cellspacing="0">
            
            <thead class="bg-primary text-white">

              <tr>
                <th>Breaktime Code</th>
                <th>Breaktime Start (AM)</th>
                <th>Breaktime End (AM)</th>
                <th>Breaktime Start (Lunch)</th>
                <th>Breaktime End (Lunch)</th>
                <th>Breaktime Start (PM)</th>
                <th>Breaktime End (PM)</th>
                <th>Breaktime Start (OT)</th>
                <th>Breaktime End (OT)</th>
                <th>Status</th>
                <th></th>
              </tr>

            </thead>

          </table>

        </div>
      </div>
    </div>
  </div>

  <div id="add_breaktime" class="add_breaktime" style="display: block;">

    <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
        <h2 class="float-left">Add Breaktime</h2>
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
            <input type="submit" name="add_breaktime" value="Add Breaktime" class="btn btn-primary pr-3">
            <input type="reset" name="reset" value="Cancel" id="cancel_breaktime"  class="btn btn-secondary ml-2">
          </div> 
        </div>
    </form>
  </div>
</div>


</div>
<!-- /.container-fluid -->
<?php include '../include/footer.php'; 








?>


<script>

</script>