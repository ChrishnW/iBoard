<?php 
    ob_start();
    include '../include/header.php'; 

    // Display Message ----------------------------------------------------------------------------
    if(isset($_SESSION["message"])){
        $message = $_SESSION["message"];

        echo "<script> document.addEventListener('DOMContentLoaded', function () {

        document.getElementById('display_message').innerHTML = '$message'; 

        const popup = document.getElementById('popup');
        popup.style.display = 'block';
        
        }); </script>";

        echo "<script> document.addEventListener('DOMContentLoaded', function () {

        var building_dashboard = document.getElementById('building_dashboard');
        building_dashboard.style.display = 'block';

        }); </script>";

        unset($_SESSION["message"]);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
        // Add Building --------------------------------------------------------------------------
        if(isset($_POST["add_building_submit"])){
            $building_name = filter_input(INPUT_POST, "building_name", FILTER_SANITIZE_SPECIAL_CHARS);
            $status = 1;

            $result = mysqli_query($conn, "INSERT INTO tbl_building (building_name, status) VALUES ('$building_name', '$status')");

            if($result){
                $_SESSION["message"] = "Building added successfully.";
            }
            else{
                $_SESSION["message"] = "Failed to add building.";
            }

            header("Refresh: .3; url = building.php");
            exit;
            ob_end_flush();
            
        }

        // Edit Building display --------------------------------------------------------------------------
        if(isset($_POST["edit_building"])){
            $build_id = filter_input(INPUT_POST, "id_building", FILTER_SANITIZE_SPECIAL_CHARS);

            $_SESSION["building_id"] = $build_id;

            header("Refresh: .3; url = building.php");
            exit;
            ob_end_flush();
        }
    }
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <div id="building_dashboard" class="building_dashboard" style="display: block;">      
    <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
        <h2 class="float-left">Building List</h2>
        <button id="btn_add_building" type="button" class="btn btn-primary float-right">
            <i class="fa fa-plus pr-1"></i> Add Building
        </button>

        <div class="clearfix"></div>
      </div>
        
      <div class="card-body">
        <div class="table-responsive">
          <table class=" table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">     
            <thead class="bg-primary text-white">
              <tr>
                <th>ID</th>
                <th>Building Name</th>
                <th>Status</th>
                <th style="width: 170px;">Actions</th>                
              </tr>
            </thead>

            <tbody id="insert_here">
                <?php
                    $query = "SELECT * FROM tbl_building";
                    $result = mysqli_query($conn, $query);

                    if(mysqli_num_rows($result) > 0){
                        while($building = mysqli_fetch_assoc($result)){
                            $building_id = $building["id"];
                            $status = $building["status"];
                            $status_word = "";

                            if($status == "1"){
                                $status_word = "Active";
                            }
                            else{
                                $status_word = "Inactive";
                            } 
                ?>

                <tr>
                    <td><?php echo $building["id"]?></td>
                    <td><?php echo $building["building_name"]?></td>
                    <td><?php echo $status_word ?></td>
                    <td>
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="form_table d-flex justify-content-center align-items-center">
                            <input type="hidden" name="id_building" value="<?php echo $building_id ?>">
                            <input type="submit" class="btn btn-primary mr-2" value="Edit" name="edit_building">
                            <input type="submit" id="delete_building" class="btn btn-danger" value="Delete" name="delete_building">
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

<!-- ADD BUILDING -->
<div class="modal" tabindex="-1" id="add_building" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-gradient-primary">
          <h5 class="modal-title text-white">Add Building</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" id="close_addBuilding">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" style="width: 100%; max-width: 600px;">         
            <div class="mb-3 pb-3">
              <label for="building_name" class="form-label">Building Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="building_name" id="building_name" required>
            </div>

            <div class="modal-footer">
              <input type="submit" name="add_building_submit" class="btn btn-primary pr-3" value="Add Building">
              <input type="reset" name="reset" class="btn btn-secondary ml-2" value="Cancel" id="cancel_building">
            </div>
          </form>
        </div>
      </div>
    </div>
</div> 

<!-- Edit Building -->
<div class="modal" tabindex="-1" id="edit_building" class="edit_building" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white">Edit Building</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" id="close_EditBuilding">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" style="width: 100%; max-width: 600px;">           
                    <?php
                    if(isset($_SESSION["building_id"])){
                        $building_id = $_SESSION["building_id"];
                    
                        $sql_command = "SELECT * FROM tbl_building WHERE id = '$building_id'";
                        $result = mysqli_query($conn, $sql_command);
                    
                        if(mysqli_num_rows($result) > 0){
                            $building = mysqli_fetch_assoc($result);
                        
                            $building_name = $building["building_name"];
                            $status = $building["status"];
                            $status_word = "";
                        
                            if($status == "1"){
                                $status_word = "Active";
                            }
                            else{
                                $status_word = "Inactive";
                            }
                        
                            echo '<script> 
                                        document.addEventListener("DOMContentLoaded", function () {
                                            var edit_building = document.getElementById("edit_building");
                                            edit_building.style.display = "block";

                                            document.body.style.overflow = "hidden";
                                        }); 
                                    </script>';
                    ?>

                    <input type="hidden" name="edit_building_id" id="edit_building_id" value="<?php echo $building_id ?>" >

                    <div class="mb-3">
                        <label for="edit_building_name" class="form-label">Building Name <span style="color: red;">*</span></label>
                        <input type="text" name="edit_building_name" id="edit_building_name" required value="<?php echo $building_name ?>" class="form-control">
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
                        unset($_SESSION["building_id"]);
                    }
                    ?>            

                    <div class="modal-footer">
                        <input type="submit" name="edit_building_submit" value="Save" class="submit btn btn-primary pr-3"> 
                        <input type="reset" name="reset" value="Cancel" id="cancel_edit_building" class="btn btn-secondary ml-2">           
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</div>

<!-- Pop up Modal -->
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
                <p class="h5">Are you sure you want to delete this building permanently?</p> 
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
?>

<script>
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });

    document.addEventListener('DOMContentLoaded', function () {

        document.getElementById('close_popup').addEventListener('click', function () {
            document.getElementById('popup').style.display = 'none';
        });

        document.getElementById('close_popup2').addEventListener('click', function () {
            document.getElementById('popupFormDelete').style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        const btn_add_building = document.getElementById('btn_add_building');
        const building_dashboard = document.getElementById('building_dashboard');
        
        const add_building = document.getElementById('add_building');
        const cancel_building = document.getElementById('cancel_building');
        const close_addBuilding = document.getElementById('close_addBuilding');

        const cancel_edit_building = document.getElementById('cancel_edit_building');
        const edit_building = document.getElementById('edit_building');

        btn_add_building.addEventListener('click', function () {
            add_building.style.display = 'block'; 
            document.body.style.overflow = 'hidden'; 
        });

        close_addBuilding.addEventListener("click", function(){
            building_dashboard.style.display = 'block';
            add_building.style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        cancel_building.addEventListener('click', function () {
            building_dashboard.style.display = 'block';
            add_building.style.display = 'none';
            document.body.style.overflow = 'auto';
        });   

        close_EditBuilding.addEventListener("click", function(){
            edit_building.style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        cancel_edit_building.addEventListener('click', function () {
            edit_building.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
    });

    const popup2 = document.getElementById("popupFormDelete");

    function closePopup2() {
        popup2.style.display = "none";
        document.body.style.overflow = 'auto';
    }
</script>