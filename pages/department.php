<?php include '../include/header.php'; 

  // Display Message ----------------------------------------------------------------------------

  if(isset($_SESSION["message"])){

    $message = $_SESSION["message"];

    echo "<script> document.addEventListener('DOMContentLoaded', function () {
    
      document.getElementById('display_message').innerHTML = '$message'; 

      const popup = document.getElementById('popup');
      popup.style.display = 'block';
      
    }); </script>";

    echo "<script> document.addEventListener('DOMContentLoaded', function () {

      var department_dashboard = document.getElementById('department_dashboard');
      department_dashboard.style.display = 'block';

      var add_department = document.getElementById('add_department');
      add_department.style.display = 'none';

    }); </script>";

    unset($_SESSION["message"]);
  }

  // Delete Department Ask Display --------------------------------------------------------------------------

  if(isset($_SESSION["delete_id_dept"])){

    $dept_id = $_SESSION["delete_id_dept"];
    $_SESSION["delete_dept"] = $dept_id;

    global $db_conn;

    echo "<script> document.addEventListener('DOMContentLoaded', function () {

        var popup = document.getElementById('popupFormDelete');
        popup.style.display = 'block';

    }); </script>";

    echo "<script> document.addEventListener('DOMContentLoaded', function () {

        var department_dashboard = document.getElementById('department_dashboard');
        department_dashboard.style.display = 'block';

    }); </script>";

    unset($_SESSION["delete_id_dept"]);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    // Add Department ---------------------------------------------------------------------------

    if(isset($_POST["add_department_submit"])){

      $dept_name = filter_input(INPUT_POST, "dept_name", FILTER_SANITIZE_SPECIAL_CHARS);
      $dept_code = filter_input(INPUT_POST, "dept_code", FILTER_SANITIZE_SPECIAL_CHARS);
      $status = 1;

      $hashed_password = password_hash("12345", PASSWORD_DEFAULT);

      $sql_command = "INSERT INTO tbl_department (dept_name, password, dept_code, status) VALUES ('$dept_name', '$hashed_password', '$dept_code', '$status')";
      $result = mysqli_query($conn, $sql_command);

      if($result){
        $_SESSION["message"] = "Department added successfully.";
      }
      else{
        $_SESSION["message"] = "Failed to add department.";
      }

      header("Refresh: .3; url = department.php");
      exit;

    }

    // Delete Department Ask --------------------------------------------------------------------------

    if(isset($_POST["delete_department"])){

      $_SESSION["delete_id_dept"] = filter_input(INPUT_POST, "id_department", FILTER_SANITIZE_SPECIAL_CHARS);

      header("Refresh: .3; url = department.php");
      exit;

    }

    // Delete Account Confirm --------------------------------------------------------------------------

    if(isset($_POST["delete_data"])){

    $dept_id = $_SESSION["delete_dept"];

    $sql_command = "DELETE FROM tbl_department WHERE id = '$dept_id'";
    $result = mysqli_query($conn, $sql_command);

    if($result){
      $_SESSION["message"] = "Account deleted successfully.";
    }
    else{
      $_SESSION["message"] = "Failed to delete account.";
    }
    
    unset($_SESSION["delete_dept"]);
    
    header("Refresh: .3; url = department.php");
    exit;

    }

    // Edit Department --------------------------------------------------------------------------

    if(isset($_POST["edit_department"])){

      $dept_id = filter_input(INPUT_POST, "id_department", FILTER_SANITIZE_SPECIAL_CHARS);

      $_SESSION["dept_id"] = $dept_id;

      header("Refresh: .3; url = department.php");
      exit;

    }

    // Edit Department Submit --------------------------------------------------------------------------

    if(isset($_POST["edit_department_submit"])){

      $dept_id = filter_input(INPUT_POST, "edit_dept_id", FILTER_SANITIZE_SPECIAL_CHARS);
      $dept_name = filter_input(INPUT_POST, "edit_dept_name", FILTER_SANITIZE_SPECIAL_CHARS);
      $dept_code = filter_input(INPUT_POST, "edit_dept_code", FILTER_SANITIZE_SPECIAL_CHARS);
      $dept_status = filter_input(INPUT_POST, "edit_status", FILTER_SANITIZE_SPECIAL_CHARS);

      $sql_command = "UPDATE tbl_department SET dept_name = '$dept_name', dept_code = '$dept_code', status = '$dept_status' WHERE id = '$dept_id'";
      $result = mysqli_query($conn, $sql_command);

      if($result){
          $_SESSION["message"] = "Department updated successfully.";
      }
      else{
          $_SESSION["message"] = "Failed to update department.";
      }

      header("Refresh: .3; url = department.php");
      exit;

    }

    // Reset Password --------------------------------------------------------------------------

    if(isset($_POST["reset_password"])){

      $acc_id = filter_input(INPUT_POST, "edit_acc_id", FILTER_SANITIZE_SPECIAL_CHARS);
      $password = 12345;

      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      
      $sql_command = "UPDATE tbl_accounts SET password = '$hashed_password' WHERE id = '$acc_id'";
      $result = mysqli_query($conn, $sql_command);

      if($result){
        $_SESSION["message"] = "Department password updated successfully.";
      }
      else{
        $_SESSION["message"] = "Failed to update department password.";
      }

      header("Refresh: .3; url = account.php");
      exit;
    }

  }
 
?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <div id="department_dashboard" class="department_dashboard" style="display: block;">
      
    <div class="card shadow mb-4">

      <div class="card-header py-3.5 pt-4">

        <h2 class="float-left">Department List</h2>
        <button id="btn_add_department" type="button" class="btn btn-primary float-right">
            <i class="fa fa-plus pr-2"></i> Add Department
        </button>
        
        <div class="clearfix"></div>

      </div>
        
      <div class="card-body">

        <div class="table-responsive">

          <table class=" table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
            
            <thead class="bg-primary text-white">

              <tr>
                <th>ID</th>
                <th>Department Name</th>
                <th>Code</th>
                <th>Status</th>
                <th style="width: 170px;"></th>                
              </tr>

            </thead>

            <tbody id="insert_here">

            <?php
                $query = "SELECT * FROM tbl_department";
                $result = mysqli_query($conn, $query);

                if(mysqli_num_rows($result) > 0){
                    while($department = mysqli_fetch_assoc($result)){

                        $dept_id = $department["id"];
                        $dept_name = $department["dept_name"];
                        $dept_code = $department["dept_code"];
                        $status = $department["status"];
                        $status_word = "";

                        if($status == "1"){
                            $status_word = "Active";
                        }
                        else{
                            $status_word = "Inactive";
                        } 
            ?>

                <tr>
                    <td><?php echo $dept_id ?>  </td>
                    <td><?php echo $dept_name ?></td>
                    <td><?php echo $dept_code ?></td>
                    <td><?php echo $status_word ?></td>
                    <td style="table-layout: fixed; width: 15%;">
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="form_table d-flex justify-content-between">
                        <input type="hidden" name="id_department" value="<?php echo $dept_id ?>">

                            <input type="submit" id="edit_depatment" class="btn btn-primary mr-2" value="Edit" name="edit_department">
                            <input type="submit" id="delete_department" class="btn btn-danger" value="Delete" name="delete_department">

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

  <!-- ADD DEPARTMENT -->

  <div id="add_department" class="add_department" style="display: none;">
    
    <div class="card shadow mb-4">

      <div class="card-header py-3.5 pt-4">
        <h2 class="float-left">Add Department</h2>        
      </div>

      <div class="card-body shadow-sm m-5 p-5 d-flex justify-content-center align-items-center">
        
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" style="width: 100%; max-width: 600px;">
          
          <div class="mb-3" id="insert_dept_code">
            <label for="dept_code" class="form-label">Department Code</label>
          </div>
        
          <div class="mb-3">
            <label for="dept_name" class="form-label">Department Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="dept_name" id="dept_name" required>
          </div>

          <div class="d-flex justify-content-left">
            <input type="submit" name="add_department_submit" class="btn btn-primary pr-3" value="Add Department">
            <input type="reset" name="reset" class="btn btn-secondary ml-2" value="Cancel" id="cancel_department">
          </div>

        </form>

      </div>

    </div>

  </div> 

  <!-- Edit DEPARTMENT -->

  <div id="edit_department" class="edit_department" style="display: none;">

    <div class="card shadow mb-4">
      
      <div class="card-header py-3.5 pt-4">

        <h2 class="float-left">Edit Department</h2>
        <div class="clearfix"></div>

      </div>

      <div class="card-body shadow-sm m-5 p-5 d-flex justify-content-center align-items-center">
        
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="edit_department_form" style="width: 100%; max-width: 600px;">
          
          <?php

            if(isset($_SESSION["dept_id"])){

              $dept_id = $_SESSION["dept_id"];
          
              $sql_command = "SELECT * FROM tbl_department WHERE id = '$dept_id'";
              $result = mysqli_query($conn, $sql_command);
          
              if(mysqli_num_rows($result) > 0){
                $department = mysqli_fetch_assoc($result);
          
                $dept_name = $department["dept_name"];
                $dept_code = $department["dept_code"];
                $status = $department["status"];
                $status_word = "";
          
                if($status == "1"){
                    $status_word = "Active";
                }
                else{
                    $status_word = "Inactive";
                }
          
                echo '<script> document.addEventListener("DOMContentLoaded", function () {
          
                  var department_dashboard = document.getElementById("department_dashboard");
                  department_dashboard.style.display = "none";
          
                  var add_department = document.getElementById("add_department");
                  add_department.style.display = "none";
          
                  var edit_department = document.getElementById("edit_department");
                  edit_department.style.display = "block";
          
                }); </script>';
                
          ?>

          <input type="hidden" name="edit_dept_id" id="edit_dept_id" value="<?php echo $dept_id ?>" >
          
          <div class="mb-3">
            <label for="edit_dept_code" class="form-label">Department Code </label>
            <input type="text" name="edit_dept_code" id="edit_dept_code" readonly value="<?php echo $dept_code ?>" class="form-control">
          </div>

          <div class="mb-3">
            <label for="edit_dept_name" class="form-label">Department Name <span style="color: red;">*</span></label>
            <input type="text" name="edit_dept_name" id="edit_dept_name" required value="<?php echo $dept_name ?>" class="form-control">
          </div>

          <div class="mb-3">
            <label for="edit_status">Status <span style="color: red;">*</span></label>
            <select name="edit_status" id="edit_status" class="form-control" required >
                <option value="<?php echo $status ?>"hidden><?php echo $status_word ?></option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select> 
          </div>
          
          <?php
              }
              unset($_SESSION["dept_id"]);
            }
          ?>

          <div class="d-flex justify-content-left">

            <input type="submit" name="edit_department_submit" value="Save" class="submit btn btn-primary pr-3"> 
            <input type="submit" name="reset_password" value="Reset Password" class="btn btn-danger pr-3 ml-2">
            <input type="reset" name="reset" value="Cancel" id="cancel_edit_department" class="btn btn-secondary ml-2">
          
          </div>

        </form>

      </div>

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
        <p class="h5">Are you sure you want to delete this department permanently?</p> 
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

<?php 
  
  include '../include/footer.php'; 

  // Generate Department Code ..............................................

  $department_code = 100;

  $sql_command = "SELECT * FROM tbl_department";
  $result = mysqli_query($conn, $sql_command);

  if(mysqli_num_rows($result) > 0){
    while($dept = mysqli_fetch_assoc($result)) {

      $code = (int)$dept['dept_code'];
      $department_code = $department_code > $code ? $department_code : $code;

    }

    $department_code++;
    echo "<script> document.addEventListener('DOMContentLoaded', function () {

      const table = `
        <input type=\"text\" class=\"form-control\" name=\"dept_code\" id=\"dept_code\" value=\"$department_code\" readonly>
      `;
      
      document.querySelector(\"#insert_dept_code\").insertAdjacentHTML(\"beforeend\", table);

    }); </script>";

  }

?>

<script>

  $(document).ready(function () {
    $('#dataTable').DataTable();
  });

  // function updateTable() {
  //     $.ajax({
  //         method: 'POST',
  //         url: 'fetch_department.php',
  //         success: function (data) {
  //             $('#dataTable').DataTable().destroy(); // Destroy existing DataTable instance
  //             document.getElementById('insert_here').innerHTML = data;
  //             $('#dataTable').DataTable(); // Reinitialize DataTable
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
    });

    const btn_add_department = document.getElementById('btn_add_department');
    const department_dashboard = document.getElementById('department_dashboard');
    const add_department = document.getElementById('add_department');
    const cancel_department = document.getElementById('cancel_department');

    const cancel_edit_department = document.getElementById('cancel_edit_department');
    const edit_department = document.getElementById('edit_department');

    cancel_edit_department.addEventListener('click', function () {
      edit_department.style.display = 'none';
      department_dashboard.style.display = 'block';
    });

    btn_add_department.addEventListener('click', function () {
      department_dashboard.style.display = 'none';
      add_department.style.display = 'block';
    });

    cancel_department.addEventListener('click', function () {
      department_dashboard.style.display = 'block';
      add_department.style.display = 'none';
    });

  });
  const popup2 = document.getElementById("popupFormDelete");

  function closePopup2() {
    popup2.style.display = "none";
  }

</script>