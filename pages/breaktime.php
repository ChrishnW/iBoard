<?php include '../include/header.php'; ?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <div id="department_dashboard" class="department_dashboard" style="display: none;">

    <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
          <h2 class="float-left">Department List</h2>
          <button id="btn_add_department" type="button" class="btn btn-primary float-right">Add Department</button>
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

  <div id="add_breaktime" class="add_breaktime" style="display: block;" id="add_breaktime">
    <h2>Add Breaktime</h2>

    <form action="admin.php" method="post">       
      <label for="break_code">Breaktime Code</label>
      <input type="text" name="break_code" id="break_code" placeholder="101" required><br><br>

      <div id="breaktime">
          <label for="break_start_am">Breaktime Start (AM)</label>
          <input type="time" name="break_start_am" id="break_start_am" placeholder="00:00" required><br><br>

          <label for="break_end_am">Breaktime End (AM)</label>
          <input type="time" name="break_end_am" id="break_end_am" placeholder="00:00" required><br><br>

          <label for="break_start_lunch">Breaktime Start (Lunch)</label>
          <input type="time" name="break_start_lunch" id="break_start_lunch" placeholder="00:00" required><br><br>

          <label for="break_end_lunch">Breaktime End (Lunch)</label>
          <input type="time" name="break_end_lunch" id="break_end_lunch" placeholder="00:00" required><br><br>

          <label for="break_start_pm">Breaktime Start (PM)</label>
          <input type="time" name="break_start_pm" id="break_start_pm" placeholder="00:00" required><br><br>

          <label for="break_end_pm">Breaktime End (PM)</label>
          <input type="time" name="break_end_pm" id="break_end_pm" placeholder="00:00" required><br><br>

          <label for="break_start_ot">Breaktime Start (OT)</label>
          <input type="time" name="break_start_ot" id="break_start_ot" placeholder="00:00" required><br><br>

          <label for="break_end_ot">Breaktime End (OT)</label>
          <input type="time" name="break_end_ot" id="break_end_ot" placeholder="00:00" required><br><br>
      </div>
      

      <label for="break_status">Status</label>
      <select name="break_status" id="break_status" required>
          <option value="" hidden></option>
          <option value="1">Active</option>
          <option value="0">Inactive</option>
      </select> 

      <br><br>
      <input type="submit" name="add_breaktime" value="Add Breaktime" class="submit">
      <input type="reset" name="reset" value="Cancel" id="cancel_breaktime">
    </form> 

  </div>


</div>
<!-- /.container-fluid -->
<?php include '../include/footer.php'; ?>