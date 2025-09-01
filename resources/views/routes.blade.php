<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CommuteWise Routes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f9fafb; }
        .nav-link.active { color: #007bff !important; font-weight: 600; }
        .card { border-radius: 15px; }
        .status-badge { padding: 0.35rem 0.65rem; border-radius: 10px; font-size: 0.8rem; font-weight: 600; }
        .status-green { background: #d4edda; color: #155724; }
        .status-yellow { background: #fff3cd; color: #856404; }
        .status-red { background: #f8d7da; color: #721c24; }
        .search-box { border-radius: 10px; padding-left: 2.2rem; }
        .search-icon { position: absolute; top: 50%; left: 15px; transform: translateY(-50%); color: #aaa; }
    </style>
</head>
<body>

{{-- Navbar --}}
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
            <a class="nav-link active" href="{{ route('routes') }}">Routes</a>
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
                <li>
                    <a class="dropdown-item" href="#">Profile</a>
                </li>
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

{{-- Clock Script --}}
<script>
  function updateClock() {
    let now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes().toString().padStart(2, '0');
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; 
    document.getElementById('clock').textContent = `${hours}:${minutes} ${ampm}`;
  }
  setInterval(updateClock, 1000);
  updateClock();
</script>

<div class="container-fluid mt-4">

    {{-- Top Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6>Total Routes</h6>
                <h3 class="fw-bold">42</h3>
                <small class="text-success">↑ 3.2% from last month</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6>Active Routes</h6>
                <h3 class="fw-bold">35</h3>
                <small class="text-success">↑ 1.8% from yesterday</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6>Scheduled Routes</h6>
                <h3 class="fw-bold">7</h3>
                <small class="text-danger">↓ 2.1% from last week</small>
            </div>
        </div>
    </div>

    {{-- Search & Actions --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="position-relative w-25">
            <i class="bi bi-search search-icon"></i>
            <input type="text" class="form-control search-box" placeholder="Search routes..">
        </div>
        <div>
            <button class="btn btn-outline-secondary me-2">List</button>
            <button class="btn btn-outline-secondary me-2">Maps</button>
            <button class="btn btn-primary">+ Add Route</button>
        </div>
    </div>

    {{-- Routes Table --}}
    <div class="card shadow-sm p-3">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Route ID</th>
                    <th>Route Name</th>
                    <th>Start/End Points</th>
                    <th>Schedule</th>
                    <th>Active Buses</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>RT-1072</td>
                    <td>Downtown Express</td>
                    <td>Central Station → Business District</td>
                    <td>06:00 - 22:00 (Every 15 min)</td>
                    <td>4 (8 total)</td>
                    <td><span class="status-badge status-green">Active</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>RT-1111</td>
                    <td>Airport Shuttle</td>
                    <td>City Center → International Airport</td>
                    <td>04:30 - 23:30 (Every 30 min)</td>
                    <td>3 (6 total)</td>
                    <td><span class="status-badge status-yellow">Delayed</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>RT-11024</td>
                    <td>Central Line</td>
                    <td>North Terminal → South Terminal</td>
                    <td>05:30 - 23:00 (Every 10 min)</td>
                    <td>5 (10 total)</td>
                    <td><span class="status-badge status-red">Maintenance</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>RT-1052</td>
                    <td>Suburban Express</td>
                    <td>Downtown Hub → Westside Suburbs</td>
                    <td>06:30 - 21:00 (Every 20 min)</td>
                    <td>4 (7 total)</td>
                    <td><span class="status-badge status-green">On Duty</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
