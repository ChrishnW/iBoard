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

      $dept_code = $_POST['depart_code'];
      $_SESSION['department_code'] = $dept_code;

      header("Refresh: .3; url = index.php");
      exit();
      ob_end_flush();
      
    }

    // Back Button ------------------------------------------------------------------------------

    if(isset($_POST['back'])){
      
      unset($_SESSION["department_code"]);

      header("Refresh: .3; url = index.php");
      exit();
      ob_end_flush();
      
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
          <div class="clearfix"></div>
      </div>
        <!-- Content Row -->
      <div class="card-body">          
        <div class="row" id="dashboad_insert"> </div>
      </div>
    </div>
  </div>
</div>

  <div class="container-fluid" id="monitor_department" style="display: none;">

    <div class="card shadow my-4">
        <div class="card-header py-3.5 pt-4 align-items-center ">
            <img src="../assets/img/logo.png" alt="logo.png" class="img-fluid mr-2 border" style="width: 55px;">
            <h2 class="d-inline-block align-middle pt-2 text-primary font-weight-bold "><u>GPI Production Status</u></h2>
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

      $sql_command1 = "SELECT * FROM tbl_accounts WHERE dept_code = '$dept_code' && status = '1'";
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
            <div class=\"col-lg-3 col-md-6 col-sm-12 mb-4\">
              <div class=\"card shadow h-100 py-1\" style=\"border-radius: 15px; border-left: 5px solid #4e73df;\">
                <div class=\"card-body\" style=\"padding: 10px;\">

                  <div class=\"row justify-content-center\">
                  
                    <div class=\"text-center ml-2 mr-1\">
                      <form action=\"index.php\" method=\"post\" class=\"d-flex flex-column align-items-center py-1\" style=\"gap: 5px; line-height: 1;\">
                        <input type=\"hidden\" name=\"depart_code\" value=\"$dept_code\">
                        <div class=\"h5 font-weight-bold text-primary mt-1\" style=\"font-size: 50px; line-height: .85;\">$count</div>
                        <div class=\"text-secondary mt-n2\" style=\"font-size: 12px;\">line number</div>
                        <button type=\"submit\" name=\"submit\" class=\"btn btn-primary px-2 \" style=\"border-radius: 8px; font-size: 12px; padding: 1px 1px;\">More Info</button>                      
                      </form>
                    </div>

                    <div class=\"text-center ml-3 mt-3 pr-2\">
                      <div class=\"h6 mb-0 font-weight-bold text-gray-800\" style=\"font-size: 25px;\">$name</div>
                      <div class=\"h6 text-muted\" style=\"font-size: 25px;\">$number</div>
                    </div>
                  </div>
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

<script>
  
  var depart_code =  "<?php echo isset($_SESSION['department_code']) ? TRUE : FALSE; ?>";

  let currentPage = 1;

  function updateTable() {
    $.ajax({
        method: 'POST',
        url: 'fetch.php',
        data: { page: currentPage },
        success: function (data) {
            document.getElementById('insert_here').innerHTML = data;

            // Update Pagination UI
            const totalPages = parseInt(document.getElementById('totalPages').value || 1, 10);
            updatePagination(totalPages);
            console.log("Success");
        },
        error: function () {
            console.log("Error");
        }
    });
  }

  function updatePagination(totalPages) {
      const pagination = document.querySelector('.pagination');
      pagination.innerHTML = '';

      pagination.innerHTML += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                                  <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Previous</a>
                              </li>`;

      for (let i = 1; i <= totalPages; i++) {
          pagination.innerHTML += `<li class="page-item ${currentPage === i ? 'active' : ''}">
                                      <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                                  </li>`;
      }

      pagination.innerHTML += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                                  <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a>
                              </li>`;
  }

  function changePage(page) {
      if (page > 0) {
          currentPage = page;
          updateTable();
      }
  }

  function back_btn(){
    document.getElementById('back_form').submit();
  }




  
  document.addEventListener('DOMContentLoaded', function () {

    if(depart_code){
      setInterval(updateTable, 1000);
    }

    



  });

</script>