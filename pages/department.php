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


<div id="add_department" class="add_department" style="display: block;">
    
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

</div> 



</div>

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