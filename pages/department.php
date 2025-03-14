<?php include '../include/header.php'; 

  // session_start();

  // Display Message ----------------------------------------------------------------------------

  // if(isset($_SESSION["message"])){

  //   $message = $_SESSION["message"];

  //   echo "<script> document.addEventListener('DOMContentLoaded', function () {
    
  //     document.getElementById('display_message').innerHTML = '$message'; 

  //     const popup = document.getElementById('popupForm');
  //     popup.style.display = 'block';
      
  //   }); </script>";

  //   echo "<script> document.addEventListener('DOMContentLoaded', function () {

  //     var manage_department = document.getElementById('manage_department');
  //     manage_department.style.display = 'block';

  //   }); </script>";

  //   unset($_SESSION["message"]);
  // }


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    
    // Add Department ---------------------------------------------------------------------------

    if(isset($_POST["add_department"])){

      $dept_name = filter_input(INPUT_POST, "dept_name", FILTER_SANITIZE_SPECIAL_CHARS);
      $dept_code = filter_input(INPUT_POST, "dept_code", FILTER_SANITIZE_SPECIAL_CHARS);
      $status = filter_input(INPUT_POST, "status", FILTER_SANITIZE_SPECIAL_CHARS);

      $sql_command = "INSERT INTO tbl_department (dept_name, dept_code, status) VALUES ('$dept_name', '$dept_code', '$status')";
      $result = mysqli_query($conn, $sql_command);

      // if($result){
      //     $_SESSION["message"] = "Department added successfully.";
      //     $_SESSION["add_code"] = "1";
      // }
      // else{
      //     $_SESSION["message"] = "Failed to add department.";
      // }

      header("Refresh: .3; url = admin.php");
      exit;

    }
  
  
  
  }




?>
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
              <th>Code</th>
              <th>Name</th>
              <th>Status</th>
              <th></th>                
            </tr>

          </thead>

        </table>
        
      </div>

    </div>

  </div>

</div> 


<!-- ADD DEPARTMENT -->

<div id="add_department" class="add_department" style="display: block;">
  
  <div class="card shadow mb-4">
    <div class="card-header py-3.5">
      <h2 class="float-left">Add Department</h2>        
    </div>

    <div class="card-body shadow-sm m-5 p-5 d-flex justify-content-center align-items-center">
      <form action="admin.php" method="post" style="width: 100%; max-width: 600px;">
        <div class="mb-3">
          <label for="dept_name" class="form-label">Department Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="dept_name" id="dept_name" placeholder="Production 1" required>
        </div>

        <div class="mb-3">
          <label for="dept_code" class="form-label">Code <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="dept_code" id="dept_code" placeholder="101" required>
        </div>

        <div class="mb-3">
          <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
          <select class="form-control" name="status" id="status" required>
            <option value="" hidden></option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
          </select>
        </div>

        <div class="d-flex justify-content-left">
          <button type="submit" name="add_department_submit" class="btn btn-primary pr-3">Add Department</button>
          <button type="reset" name="reset" class="btn btn-secondary ml-2">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div> 



</div>

<!-- Pop up Modal -->

<!-- <div class="modal" tabindex="-1" style="display: block; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5);">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->

<!-- /.container-fluid -->

<?php 
  
  include '../include/footer.php'; 

  // Display Department List------------------------------------------------------------------------

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

        echo '<script> document.addEventListener("DOMContentLoaded", function () {
            const table = `
            <tr>
                <td>' . $dept_id . '</td>
                <td>' . $dept_name . '</td>
                <td>' . $dept_code . '</td>
                <td>' . $status_word . '</td>
                <td>
                    <form action="admin.php" method="post" class="form_table">
                      <input type="hidden" name="id_department" value=' . $dept_id . '>

                      <input type="submit" id="edit_depatment" class="edit" value="Edit" name="edit_department">
                      <input type="submit" id="delete_department" class="delete" value="Delete" name="delete_department">

                    </form>

                </td>
            </tr>`;
            
            document.querySelector("#dataTable").insertAdjacentHTML("beforeend", table);
        });</script>';

      }
  }







?>