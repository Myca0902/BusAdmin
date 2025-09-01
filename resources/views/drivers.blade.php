<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CommuteWise Driver Verification</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f9fafb; }
    .card { border-radius: 15px; }
    .stat-card { min-height: 120px; }
    .badge { font-size: 0.85rem; }
    .search-box { max-width: 350px; }
    .nav-link.active { color: #007bff !important; font-weight: 600; }
  </style>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
  <a class="navbar-brand fw-bold" href="#">
    <img src="https://img.icons8.com/fluency/48/bus.png" width="40"> CommuteWise
  </a>

  <ul class="navbar-nav mx-auto">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('buses') }}">Buses</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('routes') }}">Routes</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="{{ route('drivers') }}">Drivers</a>
    </li>
  </ul>

  <div class="d-flex align-items-center">
    <div class="me-4 text-end">
      <small class="d-block text-muted" id="clock">--:-- --</small>
      <small class="d-block text-success fw-bold">All systems operational</small>
    </div>
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
        <img src="https://via.placeholder.com/40" class="rounded-circle me-2">
        <strong>{{ Auth::user()->fname }} {{ Auth::user()->lname }}</strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <li><a class="dropdown-item" href="#">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- STAT CARDS -->
<div class="container mt-4">
  <div class="row g-3">
    <div class="col-md-4">
      <div class="card shadow-sm stat-card p-3">
        <h6>Total Drivers</h6>
        <h3 id="totalDrivers">248</h3>
        <span class="text-success small">↑ 4.6% since last month</span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm stat-card p-3">
        <h6>Active Drivers</h6>
        <h3 id="activeDrivers">187</h3>
        <span class="text-success small">75.4% of total drivers</span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm stat-card p-3">
        <h6>On-Route Drivers</h6>
        <h3 id="onRouteDrivers">142</h3>
        <span class="text-primary small">Real-time, updated 2 mins ago</span>
      </div>
    </div>
  </div>
</div>

<!-- SEARCH BAR -->
<div class="container mt-4 d-flex justify-content-between align-items-center">
  <input type="text" id="searchInput" class="form-control search-box" placeholder="Search driver...">
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDriverModal">+ Add Driver</button>
</div>

<!-- PENDING APPROVALS TABLE -->
<div class="container mt-4">
  <h4 class="mb-3">Pending Driver Approvals</h4>

  <table class="table table-striped shadow-sm">
    <thead>
      <tr>
        <th>Driver</th>
        <th>Contacts</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="driverTable">
      <!-- Dynamic rows will load here -->
      <tr id="noDataRow" style="display:none;">
        <td colspan="4" class="text-center text-muted fw-bold">
          No Data for "<span id="searchText"></span>"
        </td>
      </tr>
    </tbody>
  </table>
</div>

<!-- ADD DRIVER MODAL -->
<div class="modal fade" id="addDriverModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Driver</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addDriverForm" enctype="multipart/form-data">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Full Name</label>
              <input type="text" name="full_name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Phone Number</label>
              <input type="text" name="phone_number" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Address</label>
              <input type="text" name="address" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Date of Birth</label>
              <input type="date" name="date_of_birth" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Government ID</label>
              <input type="file" name="gov_id_image" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6">
              <label class="form-label">Driver License (Front)</label>
              <input type="file" name="license_front" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6">
              <label class="form-label">Driver License (Back)</label>
              <input type="file" name="license_back" class="form-control" accept="image/*">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveDriverBtn">Save Driver</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // CSRF token for AJAX
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  // Clock
  function updateClock() {
    let now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes().toString().padStart(2, '0');
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;
    document.getElementById('clock').textContent = `${hours}:${minutes} ${ampm}`;
  }
  setInterval(updateClock, 1000); updateClock();

  // Save Driver via AJAX
  document.getElementById('saveDriverBtn').addEventListener('click', function() {
    let form = document.getElementById('addDriverForm');
    let formData = new FormData(form);

    fetch("{{ route('drivers.store') }}", {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert('Driver added successfully!');
        form.reset();
        let modal = bootstrap.Modal.getInstance(document.getElementById('addDriverModal'));
        modal.hide();
        loadDrivers(); // reload driver list
      } else {
        alert('Error: ' + data.message);
      }
    })
    .catch(err => console.error(err));
  });

  // Load drivers dynamically
  function loadDrivers() {
    fetch("{{ route('drivers.list') }}")
    .then(res => res.json())
    .then(data => {
      let tableBody = document.getElementById('driverTable');
      tableBody.innerHTML = '';
      if (data.length === 0) {
        document.getElementById('noDataRow').style.display = '';
        return;
      }
      data.forEach(driver => {
        let row = `
          <tr>
            <td>${driver.full_name}</td>
            <td>${driver.phone_number}<br><small>${driver.email}</small></td>
            <td><span class="badge bg-warning text-dark">${driver.status}</span></td>
            <td>
              <button class="btn btn-success btn-sm">Approve</button>
              <button class="btn btn-danger btn-sm">Reject</button>
            </td>
          </tr>`;
        tableBody.insertAdjacentHTML('beforeend', row);
      });
    });
  }

  loadDrivers(); // Initial load
</script>

</body>
</html>
