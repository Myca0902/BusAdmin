<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CommuteWise Buses</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background-color: #f9fafb; }
    .nav-link.active { color: #007bff !important; font-weight: 600; }
    .card { border-radius: 15px; }
    .status-dot { height: 12px; width: 12px; border-radius: 50%; display: inline-block; margin-right: 6px; }
    .status-green { background: #28a745; }
    .status-yellow { background: #ffc107; }
    .status-red { background: #dc3545; }
    .bus-status { font-size: 0.9rem; }
    .action-btn { border: none; background: none; color: #444; margin-right: 8px; }
    .action-btn:hover { color: #007bff; }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
  <a class="navbar-brand fw-bold" href="#">
    <img src="https://img.icons8.com/fluency/48/bus.png" width="40"> CommuteWise System
  </a>

  <ul class="navbar-nav mx-auto">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="{{ route('buses') }}">Buses</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('routes') }}">Routes</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('drivers') }}">Drivers</a>
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
        <li>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="dropdown-item">Logout</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- DASHBOARD CARDS -->
<div class="container-fluid my-4">
  <div class="row g-3">
    <div class="col-md-3">
      <div class="card p-3 shadow-sm">
        <h6>Total Fleet</h6>
        <h3>128</h3>
        <small class="text-success">↑ 4.3% from last month</small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 shadow-sm">
        <h6>Active Buses</h6>
        <h3>98</h3>
        <small class="text-success">↑ 2.1% from yesterday</small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 shadow-sm">
        <h6>In Maintenance</h6>
        <h3>17</h3>
        <small class="text-danger">↑ 5.8% from last week</small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 shadow-sm">
        <h6>Daily Utilization</h6>
        <h3>76.4%</h3>
        <small class="text-success">↑ 3.2% from last month</small>
      </div>
    </div>
  </div>
</div>

<!-- SEARCH & CONTROLS -->
<div class="container-fluid my-3">
  <div class="d-flex justify-content-between align-items-center">
    <div class="input-group w-25">
      <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
      <input type="number" id="searchInput" class="form-control" placeholder="Search bus..">
    </div>
    <div>
     
<!-- Add Bus Button -->
<div class="d-flex justify-content-between align-items-center mb-3">
   <button class="btn btn-outline-secondary me-2"><i class="bi bi-list"></i> List</button>
      <button class="btn btn-outline-secondary me-2"><i class="bi bi-geo-alt"></i> Maps</button>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBusModal">
    + Add Bus
  </button>
</div>

<!-- Add Bus Modal -->
<div class="modal fade" id="addBusModal" tabindex="-1" aria-labelledby="addBusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="addBusModalLabel">Add New Bus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
        
        <div class="modal-body">
          <div class="row g-3">
            
            <!-- Model / Type -->
            <div class="col-md-6">
              <label class="form-label">Model / Type</label>
              <input type="text" name="model" class="form-control" placeholder="e.g., Hyundai Aero City" required>
            </div>

            <!-- Capacity -->
            <div class="col-md-6">
              <label class="form-label">Capacity</label>
              <input type="number" name="capacity" class="form-control" placeholder="e.g., 50" required>
            </div>

            <!-- Route -->
            <div class="col-md-6">
              <label class="form-label">Route</label>
              <select name="route" class="form-select" required>
                <option value="" disabled selected>-- Select Route --</option>
                <option value="Route 1">Route 1 - Downtown</option>
                <option value="Route 2">Route 2 - Uptown</option>
                <option value="Route 3">Route 3 - Suburbs</option>
              </select>
            </div>

            <!-- Driver -->
            <div class="col-md-6">
              <label class="form-label">Driver</label>
              <select name="driver" class="form-select" required>
                <option value="" disabled selected>-- Select Driver --</option>
                <option value="1">Juan Dela Cruz</option>
                <option value="2">Maria Santos</option>
                <option value="3">Pedro Reyes</option>
              </select>
            </div>

            <!-- Last Maintenance -->
            <div class="col-md-6">
              <label class="form-label">Last Maintenance</label>
              <input type="date" name="last_maintenance" class="form-control" required>
            </div>

          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Save Bus</button>
        </div>
        <div class="modal fade" id="addBusModal" tabindex="-1" aria-labelledby="addBusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="addBusModalLabel">Add New Bus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      
        <div class="modal-body">
          <div class="row g-3">
            
            <!-- Model / Type -->
            <div class="col-md-6">
              <label class="form-label">Model / Type</label>
              <input type="text" name="model" class="form-control" placeholder="e.g., Hyundai Aero City" required>
            </div>

            <!-- Capacity -->
            <div class="col-md-6">
              <label class="form-label">Capacity</label>
              <input type="number" name="capacity" class="form-control" placeholder="e.g., 50" required>
            </div>

            <!-- Route -->
            <div class="col-md-6">
              <label class="form-label">Route</label>
              <select name="route" class="form-select" required>
                <option value="" disabled selected>-- Select Route --</option>
                <option value="Route 1">Route 1 - Downtown</option>
                <option value="Route 2">Route 2 - Uptown</option>
                <option value="Route 3">Route 3 - Suburbs</option>
              </select>
            </div>

            <!-- Driver -->
            <div class="col-md-6">
              <label class="form-label">Driver</label>
              <select name="driver" class="form-select" required>
                <option value="" disabled selected>-- Select Driver --</option>
                <option value="1">Juan Dela Cruz</option>
                <option value="2">Maria Santos</option>
                <option value="3">Pedro Reyes</option>
              </select>
            </div>

            <!-- Last Maintenance -->
            <div class="col-md-6">
              <label class="form-label">Last Maintenance</label>
              <input type="date" name="last_maintenance" class="form-control" required>
            </div>

          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Save Bus</button>
        </div>
      </form>
    </div>
  </div>
</div>
    
    </div>
  </div>
</div>
    </div>
  </div>
</div>

<!-- TABLE -->
<div class="container-fluid">
  <div class="card shadow-sm p-3">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>Bus ID</th>
          <th>Model/Type</th>
          <th>Capacity</th>
          <th>Status</th>
          <th>Route</th>
          <th>Driver</th>
          <th>Last Maintenance</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="busTable">
        <tr>
          <td>BUS-1072</td>
          <td>Daewoo BS106</td>
          <td>60 Seats</td>
          <td><span class="badge bg-success">Active</span></td>
          <td>Route 42 – Downtown Express</td>
          <td>Robert Johnson</td>
          <td>April 28, 2025</td>
          <td>
            <button class="action-btn"><i class="bi bi-eye"></i></button>
            <button class="action-btn"><i class="bi bi-pencil"></i></button>
          </td>
        </tr>
        <tr>
          <td>BUS-1111</td>
          <td>Volvo 9600</td>
          <td>60 Seats</td>
          <td><span class="badge bg-warning text-dark">Delayed</span></td>
          <td>Route 15 – Airport Shuttle</td>
          <td>Jake Parker</td>
          <td>May 2, 2025</td>
          <td>
            <button class="action-btn"><i class="bi bi-eye"></i></button>
            <button class="action-btn"><i class="bi bi-pencil"></i></button>
          </td>
        </tr>
        <tr>
          <td>BUS-1024</td>
          <td>Hino RN8J</td>
          <td>60 Seats</td>
          <td><span class="badge bg-danger">Maintenance</span></td>
          <td>Unassigned</td>
          <td>Unassigned</td>
          <td>May 7, 2025</td>
          <td>
            <button class="action-btn"><i class="bi bi-eye"></i></button>
            <button class="action-btn"><i class="bi bi-pencil"></i></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<script>
  // Clock
  function updateClock() {
    let now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes().toString().padStart(2, '0');
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;
    document.getElementById('clock').textContent = `${hours}:${minutes} ${ampm}`;
  }
  setInterval(updateClock, 1000);
  updateClock();

  // Search functionality (Bus ID only)
  document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toUpperCase();
    let rows = document.querySelectorAll('#busTable tr');

    rows.forEach(row => {
      let busId = row.cells[0].textContent.toUpperCase(); // first column (Bus ID)
      if (busId.indexOf(filter) > -1) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
