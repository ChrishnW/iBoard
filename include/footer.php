</div>
<!-- End of Main Content -->

<!-- Log out Pop up Modal -->
<div class="modal" tabindex="-1" id="popoutLogout" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5);">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger">Logout Account Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_popup2">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <p class="h6">Are you sure you want to log out? Once logged out, you will need to log in again to access your account.</p>
      </div>

      <div class="modal-footer">
        <!-- Confirm button triggers JavaScript logout logic -->
        <button onclick="handleLogout()" class="btn btn-danger">Logout</button>
        <a href="#" onclick="closePopupLogout()" class="btn btn-secondary" style="text-decoration: none;">Cancel</a>
      </div>

    </div>
  </div>
</div>

<script>
  function handleLogout() {
    window.location.href = '../include/logout.php';
  }

  function closePopupLogout() {
    // Close the modal by hiding it
    const modal = document.getElementById("popoutLogout");
    modal.style.display = "none";

    // Remove the backdrop if any is present
    const modalBackdrops = document.getElementsByClassName("modal-backdrop");
    while (modalBackdrops.length > 0) {
      modalBackdrops[0].parentNode.removeChild(modalBackdrops[0]);
    }
  }

  
</script>

<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>&copy; GPI (Information System). All rights reserved.</span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript -->
<?php include 'script.php'; ?>

</body>

</html>