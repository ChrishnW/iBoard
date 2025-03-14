<?php include '../include/header.php'; ?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <div id="department_dashboard" class="department_dashboard" style="display: none;">

    <div class="card shadow mb-4">
      <div class="card-header py-3.5">
          <h2 class="float-left">Department List</h2>
          <button id="btn_add_department" type="button" class="btn btn-primary float-right">Add Department</button>
          <div class="clearfix"></div>
      </div>
        
      <div class="card-body">
        <div class="table-responsive">
          <table class=" table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead class="bg-primary text-white">
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Department</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
</div>

<div id="add_account" class="add_account" style="display: block;">
    <h2>Add Account</h2>

    <form action="admin.php" method="post">
        <label for="acc_name">Username <span style="color: red;">*</span></label>
        <input type="text" name="acc_name" id="acc_name" placeholder="SDRB" required><br><br>

        <label for="acc_password">Password <span style="color: red;">*</span></label>
        <input type="password" name="acc_password" id="acc_password" placeholder="*******" required><br><br>

        <label for="acc_department_code">Department <span style="color: red;">*</span></label>
        <select name="acc_department_code" id="acc_department_avail" required>
            <option value="" hidden></option>

        </select>

        <label for="acc_status">Status <span style="color: red;">*</span></label>
        <select name="acc_status" id="acc_status" required>
            <option value="" hidden></option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>

        <br><br>
        <input type="submit" name="add_account" value="Add Account" class="submit">
        <input type="reset" name="reset" value="Cancel" id="cancel_account">

    </form>

</div>


</div>
<!-- /.container-fluid -->
<?php include '../include/footer.php'; ?>