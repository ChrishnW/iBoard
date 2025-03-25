<?php include '../include/header.php'; ?>
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row" id="dashboad_insert">

      
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
                          <div><a href=\"\">more info -></a></div>
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