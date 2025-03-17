function Login() {
  const credentials = new FormData(document.getElementById('loginDetails'));
  $.ajax({
    method: 'POST',
    url: 'include/login.php',
    data: credentials,
    processData: false,
    contentType: false,
    success: function (response) {
      if(response == 'Admin'){
        window.location.href = 'pages/index.php';
      }
      else if(response == 'User'){
        window.location.href = 'pages/user.php';
      }
      else if(response == 'Monitor'){
        window.location.href = 'pages/monitor.php';
      }
      else {
        alert(response);
      }
    }
  });
}

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
})

function itemDetails(id, readonly = false) {
  const data = { id: id, deviceInfo: true };
  if (readonly) {
    data.readonly = true;
  }
  $.ajax({
    method: 'POST',
    url: '../include/query.php',
    data: data,
    success: function (response) {
      $('#viewModal .modal-content').html(response);
      $('#viewModal').modal('show');
      $('.selectpicker').selectpicker('refresh');
    }
  });
}

function itemDispose(id) {
  $.ajax({
    method: 'POST',
    url: '../include/query.php',
    data: { id: id, diposeInfo: true },
    success: function (response) {
      $('#viewModal .modal-content').html(response);
      $('#viewModal').modal('show');
    }
  });
}

function diposeItem() {
  const diposeInfo = new FormData(document.getElementById('itemDiposeForm'));
  $.ajax({
    method: 'POST',
    url: '../include/query.php',
    data: diposeInfo,
    processData: false,
    contentType: false,
    success: function (response) {
      if (response == 'Success') {
        alert('Item disposed successfully');
        location.reload();
      } else {
        alert(response);
      }
    }
  });
}

function deviceInfoSave(id) {
  const itemInfo = new FormData(document.getElementById('itemDetailsForm'));
  const itemImage = document.getElementById('itemImageInput').files[0];
  const removePhoto = document.getElementById('removePhoto').value;
  const noUserCheck = document.getElementById('noUserCheck'); // Get the checkbox

  // Determine if checkbox is checked (1 if true, 0 if false)
  const isCheck = noUserCheck.checked ? 1 : 0;

  // Append values to FormData
  itemInfo.append('removePhoto', removePhoto);
  itemInfo.append('itemImage', itemImage);
  itemInfo.append('id', id);
  itemInfo.append('deviceInfoSave', true);
  itemInfo.append('isCheck', isCheck); // Add checkbox state
  $.ajax({
    method: 'POST',
    url: '../include/query.php',
    data: itemInfo,
    processData: false,
    contentType: false,
    success: function (response) {
      if (response == 'Success') {
        alert('Device information saved successfully');
        location.reload();
      } else {
        alert(response);
      }
    }
  });
}

function addItem() {
  $('#viewModal').modal('show');

  $.ajax({
    method: 'POST',
    url: '../include/query.php',
    data: { addItem: true },
    success: function (response) {
      $('#viewModal .modal-content').html(response);
      $('#viewModal').modal('show');
      $('.selectpicker').selectpicker('refresh');
    }
  });
}

function deviceSave() {
  const itemInfo = new FormData(document.getElementById('additemForm'));
  itemInfo.append('saveItem', true);
  $.ajax({
    method: 'POST',
    url: '../include/query.php',
    data: itemInfo,
    processData: false,
    contentType: false,
    success: function (response) {
      if (response == 'Success') {
        alert('Item added successfully');
        location.reload();
      } else {
        alert(response);
      }
    }
  });
}

function accountSave() {
  const accountInfo = new FormData(document.getElementById('accountForm'));
  accountInfo.append('accountSave', true);
  $.ajax({
    method: 'POST',
    url: '../include/query.php',
    data: accountInfo,
    processData: false,
    contentType: false,
    success: function (response) {
      if (response == 'Success') {
        alert('Account information saved successfully');
        location.reload();
      } else {
        alert(response);
      }
    }
  });
}

function saveSupplier() {
  const supplierInfo = new FormData(document.getElementById('supplierForm'));
  supplierInfo.append('saveSupplier', true);
  $.ajax({
    method: 'POST',
    url: '../include/query.php',
    data: supplierInfo,
    processData: false,
    contentType: false,
    success: function (response) {
      if (response == 'Success') {
        alert('Supplier information saved successfully');
        location.reload();
      } else {
        alert(response);
      }
    }
  });
}

function editSave() {
  const accountInfo = new FormData(document.getElementById('editForm'));
  accountInfo.append('editSave', true);
  $.ajax({
    method: 'POST',
    url: '../include/query.php',
    data: accountInfo,
    processData: false,
    contentType: false,
    success: function (response) {
      if (response == 'Success') {
        alert('Account information saved successfully');
        location.reload();
      } else {
        alert(response);
      }
    }
  });
}

function newAccount() {
  $.ajax({
    method: 'POST',
    url: '../include/query.php',
    data: {
      newAccount: true
    },
    success: function (response) {
      $('#viewModal .modal-content').html(response);
      $('#viewModal').modal('show');
      $('.selectpicker').selectpicker('refresh');
    }
  });
}

function editAccount(id) {
  $.ajax({
    method: 'POST',
    url: '../include/query.php',
    data: {
      editAccount: true,
      id: id
    },
    success: function (response) {
      $('#viewModal .modal-content').html(response);
      $('#viewModal').modal('show');
      $('.selectpicker').selectpicker('refresh');
    }
  });
}

function delAccount(id) {
  if (confirm('Are you sure you want to delete this account?')) {
    $.ajax({
      method: 'POST',
      url: '../include/query.php',
      data: {
        delAccount: true,
        id: id
      },
      success: function (response) {
        if (response == 'Success') {
          alert('Account deleted successfully.');
          location.reload();
        } else {
          alert(response);
          location.reload();
        }
      }
    });
  }
}