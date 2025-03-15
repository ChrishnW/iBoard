<?php include '../include/header.php'; ?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <div id="department_dashboard" class="department_dashboard" style="display: block;">

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

<!-- ADD ACCOUNT -->

<div id="add_account" class="add_account" style="display: none;">

  <div class="card shadow mb-4">
    <div class="card-header py-3.5 pt-4">
      <h2 class="float-left">Add Account</h2>
      <div class="clearfix"></div>
    </div>

    <div class="card-body shadow-sm m-5 p-5 d-flex justify-content-center align-items-center">
      <form action="admin.php" method="post" style="width: 100%; max-width: 600px;">
        <div class="mb-3">
          <label for="acc_name" class="form-label">Username <span style="color: red;">*</span></label>
          <input type="text" name="acc_name" id="acc_name" class="form-control" placeholder="SDRB" required>
        </div>

        <div class="mb-3">
          <label for="acc_password" class="form-label">Password <span style="color: red;">*</span></label>
          <input type="password" name="acc_password" id="acc_password" class="form-control" placeholder="*******" required>
        </div>

        <div class="mb-3">
          <label for="acc_department_code" class="form-label">Code <span style="color: red;">*</span></label>
          <select name="acc_department_code" id="acc_department_avail" class="form-control" required>
            <option value="" hidden></option>
          </select>
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
          <input type="submit" name="add_account" value="Add Account" class="btn btn-primary pr-3">
          <input type="reset" name="reset" value="Cancel" id="cancel_account"  class="btn btn-secondary ml-2">
        </div>
      </form>
    </div>
  </div>
</div>


</div>
<!-- /.container-fluid -->
<?php include '../include/footer.php'; 



?>

<script>

  document.addEventListener('DOMContentLoaded', function () {

    const btn_add_department = document.getElementById('btn_add_department');
    const department_dashboard = document.getElementById('department_dashboard');
    const add_account = document.getElementById('add_account');

    btn_add_department.addEventListener("click", function(){
      department_dashboard.style.display = 'none';
      add_account.style.display = 'block';
    });
    

  });

</script>