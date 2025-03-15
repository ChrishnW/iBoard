<?php include '../include/header.php'; 

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

  function getAllDepartment(){

    global $conn;

    $sql_command = "SELECT * FROM tbl_department WHERE status = '1'";
    $result = mysqli_query($conn, $sql_command);

    if(mysqli_num_rows($result) > 0){
      while($department = mysqli_fetch_assoc($result)){

        $dept_name = $department["dept_name"];
        $dept_code = $department["dept_code"];

        echo '<script> document.addEventListener("DOMContentLoaded", function () {
            const table = `
            <option value="' . $dept_code . '">' . $dept_name . '</option>`;
            
            document.querySelector("#edit_acc_code").insertAdjacentHTML("beforeend", table);
        });</script>';

      }
    }
  }


?>


<!-- Begin Page Content -->
<div class="container-fluid">

  <div id="department_dashboard" class="department_dashboard" style="display: none;">

    <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
          <h2 class="float-left">Account List</h2>
          <button id="btn_add_department" type="button" class="btn btn-primary float-right">Add Account</button>
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

<div id="edit_account" class="edit_account" style="display: block;">
  <h2>Edit Account</h2>

  <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="edit_account_form">

    <input type="hidden" name="edit_acc_id" id="edit_acc_id" value="$acc_id">

    <label for="edit_acc_name">Username <span style="color: red;">*</span></label>
    <input type="text" name="edit_acc_name" id="edit_acc_name" required value="$username"><br><br>

    <label for="edit_acc_code">Department <span style="color: red;">*</span></label>
    <select name="edit_acc_code" id="edit_acc_code" required >
        <option value="$dept_code"hidden>$dept_name</option>
    </select>

    <label for="edit_status_acc">Status <span style="color: red;">*</span></label>
    <select name="edit_status_acc" id="edit_status_acc" required >
        <option value="$status"hidden>$status_word</option>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select>

    <br><br>
    <input type="submit" name="edit_account_submit" value="Save" class="submit"> 
    <input type="reset" name="reset" value="Cancel" id="cancel_edit_account">

  </form>

</div>


</div>
<!-- /.container-fluid -->
<?php include '../include/footer.php'; 

  // Display Account List----------------------------------------------------------------------------

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

        echo '<script> document.addEventListener("DOMContentLoaded", function () {
            const table = `
            <tr>
                <td>' . $acc_id . '</td>
                <td>' . $username . '</td>
                <td>' . $dept_string . '</td>
                <td>' . $status_word . '</td>
                <td>
                    <form action="account.php" method="post" class="form_table">
                        <input type="hidden" name="id_account" value=' . $acc_id . '>

                        <input type="submit" id="edit_account" class="edit btn btn-primary" value="Edit" name="edit_account">
                        <input type="submit" id="delete_account" class="delete btn btn-danger" value="Delete" name="delete_account">

                    </form>
                </td>
            </tr>`;
            
            document.querySelector("#dataTable").insertAdjacentHTML("beforeend", table);
        });</script>';

      }
  }

  // Display All Department in Add Account --------------------------------------------------------------------------

  $sql_command = "SELECT * FROM tbl_department WHERE status = '1'";
  $result = mysqli_query($conn, $sql_command);

  if(mysqli_num_rows($result) > 0){
    while($department = mysqli_fetch_assoc($result)){

      $dept_name = $department["dept_name"];
      $dept_code = $department["dept_code"];

      echo '<script> document.addEventListener("DOMContentLoaded", function () {
        const table = `
        <option value="' . $dept_code . '">' . $dept_name . '</option>`;
        
        document.querySelector("#acc_department_avail").insertAdjacentHTML("beforeend", table);
      });</script>';

    }
  }

?>

<script>

  document.addEventListener('DOMContentLoaded', function () {

    const btn_add_department = document.getElementById('btn_add_department');
    const department_dashboard = document.getElementById('department_dashboard');
    const add_account = document.getElementById('add_account');
    const cancel_account = document.getElementById('cancel_account');

    btn_add_department.addEventListener("click", function(){
      department_dashboard.style.display = 'none';
      add_account.style.display = 'block';
    });
    
    cancel_account.addEventListener("click", function(){
      department_dashboard.style.display = 'block';
      add_account.style.display = 'none';
    });

  });

</script>