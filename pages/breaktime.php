<?php include '../include/header.php'; ?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <div id="department_dashboard" class="department_dashboard" style="display: block;">

    <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
          <h2 class="float-left">Department List</h2>
          <button id="btn_add_department" type="button" class="btn btn-primary float-right">Add Department</button>
          <div class="clearfix"></div>
      </div>
        
      <div class="card-body">
        <div class="table-responsive">
          <table class=" table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead class="bg-primary text-white">
              <tr>
                <th>Breaktime Code</th>
                <th>Breaktime Start (AM)</th>
                <th>Breaktime End (AM)</th>
                <th>Breaktime Start (Lunch)</th>
                <th>Breaktime End (Lunch)</th>
                <th>Breaktime Start (PM)</th>
                <th>Breaktime End (PM)</th>
                <th>Breaktime Start (OT)</th>
                <th>Breaktime End (OT)</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>


</div>
<!-- /.container-fluid -->
<?php include '../include/footer.php'; ?>