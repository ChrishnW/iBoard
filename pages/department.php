<?php include '../include/header.php'; ?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- <h1>Manage Department</h1> 
  <hr>
  <br> -->

  <div id="department_dashboard" class="department_dashboard" style="display: block;">
      
  <!-- <h2>Department List</h2>
  <hr>
  <br> 
  <button id="btn_add_department">Add Department</button> 
      
  <div class="table">
    <table id="department_table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Code</th>
            <th>Status</th>
            <th></th>
        </tr>
    </table>
  </div> -->

      <div class="card shadow mb-4">
        <div class="card-header py-3.5">
            <h2 class="float-left">Department List</h2>
            <button id="btn_add_department" type="button" class="btn btn-primary float-right">Add Department</button>
            <div class="clearfix"></div>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead style="background-color: blue; color: white;">
          <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Name</th>
            <th>Status</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>Tiger Nixon</td>
            <td>System Architect</td>
            <td>Edinburgh</td>
            <td>61</td>
            <td>button</td>
          </tr>
          </tbody>
          </table>
        </div>
      </div>
  </div>
<!-- 
  <div id="add_department" class="add_department" style="display: none;">
      
      

      <form action="admin.php" method="post">
          <label for="dept_name">Department Name <span style="color: red;">*</span></label>
          <input type="text" name="dept_name" id="dept_name" placeholder="Production 1" required><br><br>

          <label for="dept_code">Department Code <span style="color: red;">*</span></label>
          <input type="text" name="dept_code" id="dept_code" placeholder="101" required ><br><br> 

          <label for="status">Status <span style="color: red;">*</span></label>
          <select name="status" id="status" required>
              <option value="" hidden></option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
          </select>

          <br><br>
          <input type="submit" name="add_department" value="Add Department" class="submit">
          <input type="reset" name="reset" value="Cancel" id="cancel_department">
      </form>
  </div> -->

</div>
<!-- /.container-fluid -->
<?php include '../include/footer.php'; ?>