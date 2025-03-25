<?php include '../include/header.php'; 
  ob_start();

  if(isset($_SESSION['tigger'])){
    
    //unset($_SESSION['tigger']);

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

      $dept_code = $_POST['depart_code'];
      $_SESSION['depart_code'] = $dept_code;
      $_SESSION['tigger'] = 1;

      header("Refresh: .3; url = index.php");
      exit();
      ob_end_flush();
      
    }


  }









?>

  <!-- Begin Page Content -->
  <div class="container-fluid" id="display_department" style="display: block;">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row" id="dashboad_insert">

      
    </div>

  </div>

  <div class="container-fluid" id="monitor_department" style="display: none;">

    <div class="card shadow my-4">
        <div class="card-header py-3.5 pt-4 align-items-center ">
            <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid mr-2 border" style="width: 55px;">
            <h2 class="d-inline-block align-middle pt-2 text-primary font-weight-bold "><u>GPI Production Status</u></h2>
            <a class="btn btn-danger float-right mt-2" href="index.php">
                <i class="fas fa-sign-out-alt"></i> Exit
            </a>
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

            <div class="d-flex justify-content-end">
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>

                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        
                        <li class="page-item">
                            <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                        </li>

                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

  </div>







<!-- /.container-fluid -->
<?php include '../include/footer.php'; 

  // Fetching Active Departments ..............................................

  $sql_command = "SELECT * FROM tbl_department WHERE status = '1'";
  $result = mysqli_query($conn, $sql_command);

  if(mysqli_num_rows($result) > 0){
    while($department = mysqli_fetch_assoc($result)){
      $dept_name = $department['dept_name'];
      $dept_code = $department['dept_code'];

      $part = explode(" ", $dept_name);
      $name = $part[0];
      $number = $part[1];

      $sql_command1 = "SELECT * FROM tbl_accounts WHERE dept_code = '$dept_code'";
      $result1 = mysqli_query($conn, $sql_command1);

      $count = 0;

      if(mysqli_num_rows($result1) > 0){
        while($account = mysqli_fetch_assoc($result1)){

          $count++;

        }
      }

      echo "<script>
        document.addEventListener('DOMContentLoaded', function () {

          const table = `
              <div class=\"col-xl-3 col-md-6 mb-4\">
                  <div class=\"card border-left-primary shadow h-100 py-2\">
                      <div class=\"card-body\">
                          <div class=\"row no-gutters align-items-center\">
                              <div class=\"col mr-2\">
                                <div class=\"h5 mb-0 font-weight-bold text-gray-800\" style=\"font-size: 35px;\">$count</div>
                              </div>
                              <div class=\"col-auto\">
                                <div class=\"h5 mb-0 font-weight-bold text-gray-800\"><h3>$name</h3></div>
                                <div class=\"ml-5\"><h3>$number</h3></div>
                              </div>
                          </div>
                          <form action=\"index.php\" method=\"post\">
                              <input type=\"hidden\" name=\"depart_code\" value=\"$dept_code\">
                              <input type=\"submit\" name=\"submit\" value=\"More Info ->\" id=\"btn_submit1\">
                          </form>
                      </div>
                  </div>
              </div>
        
          `;
      
          document.querySelector(\"#dashboad_insert\").insertAdjacentHTML(\"beforeend\", table);

        });
      </script>";



    }
  }









?>