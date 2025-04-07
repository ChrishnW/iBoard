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

  function getAllDepartment_edit(){

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
            
            document.querySelector("#edit_acc_department_avail").insertAdjacentHTML("beforeend", table);
        });</script>';

      }
    }
  }

  // Display Message ----------------------------------------------------------------------------

  if(isset($_SESSION["message"])){

    $message = $_SESSION["message"];

    echo "<script> document.addEventListener('DOMContentLoaded', function () {
  
      document.getElementById('display_message').innerHTML = '$message'; 

      const popup = document.getElementById('popup');
      popup.style.display = 'block';
        
    }); </script>";

    
    echo "<script> document.addEventListener('DOMContentLoaded', function () {

      var account_dashboard = document.getElementById('account_dashboard');
      account_dashboard.style.display = 'block';

    }); </script>";

    unset($_SESSION["message"]);

  }

  // Delete Account Ask Display --------------------------------------------------------------------------

  if(isset($_SESSION["delete_id_acc"])){

    $acc_id = $_SESSION["delete_id_acc"];
    $_SESSION["delete_acc"] = $acc_id;

    echo "<script> document.addEventListener('DOMContentLoaded', function () {

        var popup = document.getElementById('popupFormDelete');
        popup.style.display = 'block';

        var account_dashboard = document.getElementById('account_dashboard');
        account_dashboard.style.display = 'block';

        document.body.style.overflow = 'hidden';

    }); </script>";

    unset($_SESSION["delete_id_acc"]);

  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    // Add Account ------------------------------------------------------------------------------

    if(isset($_POST["add_account"])){

      $acc_name = filter_input(INPUT_POST, "acc_name", FILTER_SANITIZE_SPECIAL_CHARS);
      $acc_department_code = filter_input(INPUT_POST, "acc_department_code", FILTER_SANITIZE_SPECIAL_CHARS);
      $acc_password = 12345;
      $acc_status = 1;
      $acc_access = 2;
      $hashed_password = password_hash($acc_password, PASSWORD_DEFAULT);

      $acc_monitor = 4;
      $acc_monitor_passwod = 123456;
      $hashed_password_monitor = password_hash($acc_monitor_passwod, PASSWORD_DEFAULT);

      $result = mysqli_query($conn, "INSERT INTO tbl_accounts (username, password, access, dept_code, status) VALUES ('$acc_name', '$hashed_password', '$acc_access', '$acc_department_code', '$acc_status')");
      $result1 = mysqli_query($conn, "INSERT INTO tbl_accounts (username, password, access, dept_code, status) VALUES ('$acc_name', '$hashed_password_monitor', '$acc_monitor', '$acc_department_code', '$acc_status')");

      if($result){
          $_SESSION["message"] = "Account added successfully.";
      }
      else{
          $_SESSION["message"] = "Failed to add account.";
      }

      header("Refresh: .3; url = account.php");
      exit;

    }

    // Delete Account Ask --------------------------------------------------------------------------

    if(isset($_POST["delete_account"])){

      $_SESSION["delete_id_acc"] = filter_input(INPUT_POST, "id_account", FILTER_SANITIZE_SPECIAL_CHARS);

      header("Refresh: .3; url = account.php");
      exit;

    } 

    // Delete Account Confirm --------------------------------------------------------------------------

    if(isset($_POST["delete_data"])){

      $acc_id = $_SESSION["delete_acc"];
      $acc_monitor_id = $_SESSION["delete_acc"] + 1;

      $result = mysqli_query($conn, "DELETE FROM tbl_accounts WHERE id = '$acc_id'");
      $result = mysqli_query($conn, "DELETE FROM tbl_accounts WHERE id = '$acc_monitor_id'");

      if($result){
        $_SESSION["message"] = "Account deleted successfully.";
      }
      else{
        $_SESSION["message"] = "Failed to delete account.";
      }
      
      unset($_SESSION["delete_acc"]);
      
      header("Refresh: .3; url = account.php");
      exit;

    }

    // Edit Account --------------------------------------------------------------------------

    if(isset($_POST["edit_account"])){

      $acc_id = filter_input(INPUT_POST, "id_account", FILTER_SANITIZE_SPECIAL_CHARS);

      $_SESSION["acc_id"] = $acc_id;

      header("Refresh: .3; url = account.php");
      exit;

    }

    // Edit Account Submit --------------------------------------------------------------------------

    if(isset($_POST["edit_add_account"])){

      $acc_id = filter_input(INPUT_POST, "edit_acc_id", FILTER_SANITIZE_SPECIAL_CHARS);
      $username = filter_input(INPUT_POST, "edit_acc_name", FILTER_SANITIZE_SPECIAL_CHARS);
      $dept_code = filter_input(INPUT_POST, "edit_acc_department_code", FILTER_SANITIZE_SPECIAL_CHARS);
      $status = filter_input(INPUT_POST, "edit_acc_status", FILTER_SANITIZE_SPECIAL_CHARS);

      $sql_command = "UPDATE tbl_accounts SET username = '$username', dept_code = '$dept_code', status = '$status' WHERE id = '$acc_id'";
      $result = mysqli_query($conn, $sql_command);

      if($result){
        $_SESSION["message"] = "Account updated successfully.";
      }
      else{
        $_SESSION["message"] = "Failed to update account.";
      }

      header("Refresh: .3; url = account.php");
      exit;

    }

    // Reset Password --------------------------------------------------------------------------

    // if(isset($_POST["reset_password"])){

    //   $acc_id = filter_input(INPUT_POST, "edit_acc_id", FILTER_SANITIZE_SPECIAL_CHARS);
    //   $password = 12345;

    //   $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      
    //   $sql_command = "UPDATE tbl_accounts SET password = '$hashed_password' WHERE id = '$acc_id'";
    //   $result = mysqli_query($conn, $sql_command);

    //   if($result){
    //     $_SESSION["message"] = "Account password updated successfully.";
    //   }
    //   else{
    //     $_SESSION["message"] = "Failed to update account password.";
    //   }

    //   header("Refresh: .3; url = account.php");
    //   exit;
    // }

  }

?>

<!-- Dashboard Account -->
<div class="container-fluid">

  <div id="account_dashboard" class="account_dashboard" style="display: block;">

    <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
          <h2 class="float-left">Account List</h2>
          <button id="btn_add_account" type="button" class="btn btn-primary float-right">
            <i class="fa fa-plus pr-1"></i> Add Account
          </button>
          <div class="clearfix"></div>
      </div>
        
      <div class="card-body">
        <div class="table-responsive">
          <table class=" table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
            <thead class="bg-primary text-white">
              <tr>
                <th>Username</th>
                <th>Department</th>
                <th>Status</th>
                <th style="width: 170px;">Actions</th>
              </tr>
            </thead>
            <tbody id="insert_here">
              
              <?php

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

              ?>

                <tr>
                    <td><?php echo $username ?></td>
                    <td><?php echo $dept_string ?></td>
                    <td><?php echo $status_word ?></td>
                    <td style="table-layout: fixed; width: 15%;">
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="form_table  d-flex justify-content-between">
                            <input type="hidden" name="id_account" value="<?php echo $acc_id ?>">

                            <input type="submit" class="edit btn btn-primary mr-1" value="Edit" name="edit_account">
                            <input type="submit" class="delete btn btn-danger" value="Delete" name="delete_account">

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

<!-- Add Account -->
<div class="modal" tabindex="-1" id="add_account" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5);">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary">
        <h5 class="modal-title text-white">Add Account</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" id="close_addAccount">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" style="width: 100%; max-width: 600px;">
          <div class="mb-3">
            <label for="acc_name" class="form-label">Username <span style="color: red;">*</span></label>
            <input type="text" name="acc_name" id="acc_name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="acc_department_code" class="form-label">Department <span style="color: red;">*</span></label>
            <select name="acc_department_code" id="acc_department_avail" class="form-control" required>
              <option value="" hidden></option>
            </select>
          </div>

      </div>

          <div class="modal-footer">
            <input type="submit" name="add_account" value="Add Account" class="btn btn-primary pr-3">
            <input type="reset" name="reset" value="Cancel" id="cancel_account"  class="btn btn-secondary ml-2">
          </div>
        
        </form>

    </div>
  </div>
</div>

<!-- Edit Account -->
<div class="modal" tabindex="-1" id="edit_account" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5);">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary">
        <h5 class="modal-title text-white">Edit Account</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" id="close_editAccount">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" style="width: 100%; max-width: 600px;">
          
          <?php

            if(isset($_SESSION["acc_id"])){

              $acc_id = $_SESSION["acc_id"];

              $sql_command = "SELECT * FROM tbl_accounts WHERE id = '$acc_id'";
              $result = mysqli_query($conn, $sql_command);

              if(mysqli_num_rows($result) > 0){
                $account = mysqli_fetch_assoc($result);

                $username = $account["username"];
                $access = $account["access"];
                $dept_code = $account["dept_code"];
                $status = $account["status"];
                $status_word = "";

                if($status == "1"){
                  $status_word = "Active";
                }
                else{
                  $status_word = "Inactive";
                }

                $dept_name = getDepartmentName_string($dept_code);

                echo '<script> document.addEventListener("DOMContentLoaded", function () {

                  var edit_account = document.getElementById("edit_account");
                  edit_account.style.display = "block";

                  document.body.style.overflow = "hidden";

                }); </script>';

          ?>

          <input type="hidden" name="edit_acc_id" id="edit_acc_id" value="<?php echo $acc_id ?>">

          <div class="mb-3">
            <label for="edit_acc_name" class="form-label">Username <span style="color: red;">*</span></label>
            <input type="text" name="edit_acc_name" id="edit_acc_name" class="form-control" required value="<?php echo $username ?>">
          </div>

          <div class="mb-3">
            <label for="edit_acc_department_code" class="form-label">Department <span style="color: red;">*</span></label>
            <select name="edit_acc_department_code" id="edit_acc_department_avail" class="form-control" required>
              <option value="<?php echo $dept_code ?>" hidden><?php echo $dept_name ?></option>
            </select>
          </div>

          <div class="mb-3">
            <label for="edit_acc_status" class="form-label">Status <span style="color: red;">*</span></label>
            <select name="edit_acc_status" id="edit_acc_status" class="form-control" required>
              <option value="<?php echo $status ?>"hidden><?php echo $status_word ?></option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>

          <?php
                getAllDepartment_edit();
              }
              unset($_SESSION["acc_id"]);
            }
          ?>

      </div>

          <div class="modal-footer">
            <input type="submit" name="edit_add_account" value="Save" class="btn btn-primary pr-3">
            <!-- <input type="submit" name="reset_password" value="Reset Password" class="btn btn-danger pr-3 ml-2 mt-3"> -->
            <input type="reset" name="reset" value="Cancel" id="edit_cancel_account" class="btn btn-secondary ml-2">
          </div>
        
        </form>

    </div>
  </div>
</div>

<!-- Pop up for Message -->
<div class="modal" tabindex="-1" id="popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5);">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">Notification</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" id="close_popup">
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
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white">Delete Confirmation</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" id="close_popup2">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <p class="h5">Are you sure you want to delete this account permanently?</p> 
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
<?php include '../include/footer.php'; 

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
  
  $(document).ready(function(){
    $('#dataTable').DataTable();
  });

  // function updateTable() {
  //     $.ajax({
  //         method: 'POST',
  //         url: 'fetch_account.php',
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

    //updateTable();

    document.getElementById('close_popup').addEventListener('click', function () {
      document.getElementById('popup').style.display = 'none';
    });

    document.getElementById('close_popup2').addEventListener('click', function () {
      document.getElementById('popupFormDelete').style.display = 'none';
      document.body.style.overflow = 'auto';
    });

    const btn_add_account = document.getElementById('btn_add_account');
    const account_dashboard = document.getElementById('account_dashboard');

    const add_account = document.getElementById('add_account');
    const cancel_account = document.getElementById('cancel_account');
    const close_addAccount = document.getElementById('close_addAccount');

    const edit_cancel_account = document.getElementById('edit_cancel_account');
    const edit_account = document.getElementById('edit_account');

    btn_add_account.addEventListener("click", function() {
      add_account.style.display = 'block'; 
      document.body.style.overflow = 'hidden';
    });

    cancel_account.addEventListener("click", function(){
      add_account.style.display = 'none';
      document.body.style.overflow = 'auto';
    });

    close_addAccount.addEventListener("click", function(){
      add_account.style.display = 'none';
      document.body.style.overflow = 'auto';
    });

    edit_cancel_account.addEventListener("click", function(){
      edit_account.style.display = 'none';
      document.body.style.overflow = 'auto';
    });

    close_editAccount.addEventListener("click", function(){
      edit_account.style.display = 'none';
      document.body.style.overflow = 'auto';
    });

  });

  const popup2 = document.getElementById("popupFormDelete");

  function closePopup2() {
    popup2.style.display = "none";
    document.body.style.overflow = 'auto';
  }

</script>