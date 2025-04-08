<?php include '../include/header.php'; 
  ob_start();

  if(isset($_SESSION['department_code'])){   
    echo "<script>
      document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('display_department').style.display = 'none';
        document.getElementById('monitor_department').style.display = 'block';    
      });
    </script>";
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Viewing monitor ------------------------------------------------------------------------------
    if(isset($_POST['submit'])){
      $_SESSION['department_code'] = $_POST['depart_code'];
      $_SESSION['department_name'] = $_POST['depart_name'];

      header("Refresh: .3; url = dashboard.php");
      exit();
      ob_end_flush(); 
    }

    // Back Button ------------------------------------------------------------------------------
    if(isset($_POST['back'])){      
      unset($_SESSION["department_code"]);

      header("Refresh: .3; url = dashboard.php");
      exit();
      ob_end_flush();      
    }

    // Download to Excel ------------------------------------------------------------------------------
    if(isset($_POST['submit1'])){
      $start = $_POST["date_from"];
      $end = $_POST["date_to"];
  
      $startDate = new DateTime($start);
      $endDate = new DateTime($end);
      $gap = $startDate->diff($endDate)->days;
  
      $_SESSION['start_from'] = $start;
      $_SESSION['end_to'] = $end;
      $_SESSION['gap'] = $gap + 1;
  
      header("Location: admin_excel.php");
      exit;
    }
  }
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <div id="display_department" style="display: block;">
    <div class="card shadow mb-4">
      
      <div class="card-header py-3.5 pt-4">
        <!-- Page Heading -->
        <h2 class="float-left">Dashboard</h1>

        <a class="btn btn-success float-right mr-2" href="#" onclick="showReportsModal()">
          <i class="fa fa-download mr-1" aria-hidden="true"></i>
          Reports
        </a>

        <a class="btn btn-warning float-right mr-2" href="admin_monitor.php" target="_blank">
          <i class="fa fa-desktop mr-1" aria-hidden="true"></i>
          Monitor
        </a>

        <div class="clearfix"></div>
      </div>
        <!-- Content Row -->
      <div class="card-body">   
        <div class="row" id="dashboad_insert">
        <?php 
          $result = mysqli_query($conn, "SELECT * FROM tbl_department WHERE status = '1'");

          if(mysqli_num_rows($result) > 0){
            while($department = mysqli_fetch_assoc($result)){
              $dept_name = $department['dept_name'];
              $dept_code = $department['dept_code'];
        
              $part = explode(" ", $dept_name);
              $name = $part[0];
              $number = $part[1];
        
              $result1 = mysqli_query($conn, "SELECT * FROM tbl_accounts WHERE dept_code = '$dept_code' && status = '1' && access = '2'");
        
              $count = 0;
        
              if(mysqli_num_rows($result1) > 0){
                while($account = mysqli_fetch_assoc($result1)){
                  $count++;
                }
              }
        ?>

          <div class="col-lg-3 col-md-4 col-sm-8 mb-4">
            <div class="card shadow h-100" style="border-radius: 8px; border-left: 5px solid #4e73df;">
              <div class="card-body">
                <div class="row justify-content-center" >
                  <div class="text-center">
                    <form action="dashboard.php" method="post" class="d-flex flex-column align-items-center py-1" style="gap: 5px; line-height: .75;">
                      <input type="hidden" name="depart_code" value="<?php echo $dept_code; ?>">
                      <input type="hidden" name="depart_name" value="<?php echo $dept_name; ?>">
                      <div class="text-secondary mt-2 mb-1\" style="font-size: 12px;">Number of lines</div>
                      <div class="h1 font-weight-bold text-primary" style="line-height: .75;"><?php echo $count ?></div>
                      <button type="submit" name="submit" class="btn btn-primary px-2 mt-n1" style="border-radius: 8px; font-size: 12px; padding: 1px 1px;">More Info</button>
                    </form>
                  </div>
                  
                  <div class="text-center my-2 mx-2 pl-2 pt-3">
                    <div class="h6 mb-0 font-weight-bold text-gray-800"><?php echo $name ?></div>
                    <div class="h3 text-muted"><?php echo $number ?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        <?php 
            }
          }
        ?>
        </div> 
      </div>
    </div>
  </div>
</div>

<div class="container-fluid" id="monitor_department" style="display: none;">
  <div class="card shadow my-4">
    <div class="card-header py-3 align-items-center ">
      <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid mr-2 border" style="width: 55px;">
        <h2 class="d-inline-block align-middle pt-2 text-primary font-weight-bold "><u id="prod_name"></u></h2>
        <a class="btn btn-danger float-right mt-2" href="#" onclick="back_btn()">
            <i class="fas fa-sign-out-alt"></i> Back
        </a>
      
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="back_form">
          <input type="hidden" name="back" value="back">
        </form>
      <div class="clearfix"></div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-sm table-striped" id="dataTable" width="100%" cellspacing="0">
          <thead class="bg-primary text-white text-center">
          <tr>
              <th rowspan="2" class="text-center align-middle">Model</th>
              <th rowspan="2" class="text-center align-middle">Unit</th>
              <th rowspan="2" class="text-center align-middle">Status</th>
              <th colspan="2" class="text-center align-middle">TARGET</th>
              <th rowspan="2" class="text-center align-middle">Actual</th>
              <th rowspan="2" class="text-center align-middle">Balance</th>
          </tr>
          <tr>
              <th class="text-center align-middle">(Day)</th>
              <th class="text-center align-middle">(Now)</th>
          </tr>
          </thead>

          <tbody class="text-black text-center" id="insert_here">

          </tbody>
        </table>
      </div>         
    </div>
  </div>
</div>

<!-- Reports Modal -->
<div class="modal" tabindex="-1" id="reportsModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5);">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-gradient-primary">
            <h5 class="modal-title text-white">Download Reports</h5>
            <button type="button" class="close text-white" aria-label="Close" id="close_popup1">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <div>
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" id="form">
              <label for="date_from">From: <span style="color: red;">*</span></label>
              <input type="date" class="form-control" id="date_from" name="date_from" onchange="from_min()" required>
              <br>
              <label for="date_to">To: <span style="color: red;">*</span></label>
              <input type="date" class="form-control" id="date_to" name="date_to" required>
          </div>     
        </div>
        <div class="modal-footer">
              <input type="submit" name="submit1" value="Download" class="btn btn-primary">
              <input type="reset" name="reset" value="Cancel" onclick="closePopupReports()" class="btn btn-secondary" style="text-decoration: none;">
            </form>
        </div>
      </div>
  </div>
</div>

<!-- /.container-fluid -->
<?php include '../include/footer.php'; ?>

<script>

  function from_min(){
    const from = document.getElementById("date_from").value;
    const to = document.getElementById("date_to");

    to.min = from;
      
  }
  function showReportsModal(){
    const modal = document.getElementById('reportsModal');
    modal.style.display = 'block';

    document.getElementById('date_from').value = '';
    document.getElementById('date_to').value = '';

  }

  function closePopupReports() {
    const modal = document.getElementById('reportsModal');
    modal.style.display = 'none'; 
  }

  document.getElementById('close_popup1').addEventListener('click', function () {
    document.getElementById('reportsModal').style.display = 'none';
  });
  
  var depart_code =  "<?php echo isset($_SESSION['department_code']) ? TRUE : FALSE; ?>";
  var depart_name =  "<?php echo isset($_SESSION['department_name']) ? $_SESSION['department_name'] : FALSE; ?>";
  
  function back_btn(){
    document.getElementById('back_form').submit();
  }

  function updateTable() {
    $.ajax({
      method: 'POST',
      url: 'fetch.php',
      success: function (data) {

        document.getElementById('insert_here').innerHTML = data;
        $('#dataTable').DataTable();
        console.log("Success");

        document.getElementById("prod_name").innerHTML = ("GPI " + depart_name + " Status")
      },

      error: function () {
        console.log("Error");
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    if(depart_code){
      setInterval(updateTable, 1000);
    }
  });

  // function updateTable() {
  //   $.ajax({
  //       method: 'POST',
  //       url: 'fetch.php',
  //       success: function (data) {
  //           var table = $('#dataTable').DataTable(); 
  //           var page = table.page(); // Get the current page
  //           var order = table.order(); // Get the current order
  //           var search = table.search(); // Get the current search value

  //           table.destroy(); 
  //           document.getElementById('insert_here').innerHTML = data;

  //           $('#dataTable').DataTable({
  //               order: order, // Restore the order
  //               pageLength: table.page.len(), // Restore the page length
  //               search: { search: search } // Restore the search value
  //           }).page(page).draw(false); // Restore the page and redraw without resetting
  //           console.log("Success");
  //       },
  //       error: function () {
  //           console.log("Error");
  //       }
  //   });
  // }

  // document.addEventListener('DOMContentLoaded', function () {
  //   if(depart_code){
  //     setInterval(updateTable, 1000);
  //   }
  // });

</script>