<script>
  document.addEventListener('click', function(event) {
    // Change Photo Button
    if (event.target.classList.contains('changePhotoBtn')) {
      const card = event.target.closest('.card');
      const photoInput = card.querySelector('.photoInput');
      photoInput.click();
    }

    // Remove Photo Button
    if (event.target.classList.contains('removePhotoBtn')) {
      const card = event.target.closest('.card');
      const itemImage = card.querySelector('#itemImage');
      const photoInput = card.querySelector('.photoInput');
      const removePhoto = card.querySelector('#removePhoto');

      removePhoto.value = '1'; // Set the remove photo input value to 1
      itemImage.src = '../uploads/no_image.jpg';
      photoInput.value = null; // Clear the file input
    }
  });

  document.addEventListener('change', function(event) {
    if (event.target.classList.contains('photoInput')) {
      const file = event.target.files[0];
      const card = event.target.closest('.card');
      const itemImage = card.querySelector('#itemImage');

      if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
          itemImage.src = e.target.result;
        };

        reader.readAsDataURL(file);
      }
    }
  });
</script>

<script>
  // Function to update the employee details (ID and department) based on the selected employee
  function updateEmployeeDetails() {
    const selectedEmployee = document.getElementById('issuedTo').value;
    const options = document.getElementById('issuedTo').options;

    for (let option of options) {
      if (option.value === selectedEmployee) {
        // Get employee ID and department from data attributes
        const employeeId = option.getAttribute('data-employeeid');
        const department = option.getAttribute('data-department');

        // Update the corresponding input fields
        document.getElementById('employeeId').value = employeeId;
        document.getElementById('department').value = department;
        break;
      }
    }
  }
</script>

<script>
  // Function to handle checkbox changes
  function toggleUserFields() {
    const noUserCheck = document.getElementById('noUserCheck');
    const issuedToGroup = document.getElementById('issuedToGroup');
    const employeeIdGroup = document.getElementById('employeeIdGroup');
    const issuedInGroup = document.getElementById('issuedInGroup');

    if (!noUserCheck || !issuedToGroup || !employeeIdGroup || !issuedInGroup) {
      return; // Exit if elements are not found
    }

    if (noUserCheck.checked) {
      issuedToGroup.style.display = 'none';
      employeeIdGroup.style.display = 'none';
      issuedInGroup.style.display = 'block';
    } else {
      issuedToGroup.style.display = 'block';
      employeeIdGroup.style.display = 'block';
      issuedInGroup.style.display = 'none';
    }
  }

  // Function to check and bind event listener when AJAX loads content
  function observeDynamicContent() {
    const targetNode = document.getElementById('viewModal');

    const observer = new MutationObserver(() => {
      const noUserCheck = document.getElementById('noUserCheck');
      if (noUserCheck) {
        toggleUserFields(); // Run immediately on load
        noUserCheck.addEventListener('change', toggleUserFields); // Attach event listener
      }
    });

    observer.observe(targetNode, {
      childList: true,
      subtree: true
    });
  }

  // Start observing for dynamically loaded content
  document.addEventListener("DOMContentLoaded", observeDynamicContent);
</script>