<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CommuteWise Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f9fafb; }
        .nav-link.active { color: #007bff !important; font-weight: 600; }
        .card { border-radius: 15px; }
        .status-dot { height: 12px; width: 12px; border-radius: 50%; display: inline-block; margin-right: 6px; }
        .status-green { background: #28a745; }
        .status-yellow { background: #ffc107; }
        .status-red { background: #dc3545; }
        .bus-status { font-size: 0.9rem; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
    <a class="navbar-brand fw-bold" href="#">
        <img src="https://img.icons8.com/fluency/48/bus.png" width="40"> CommuteWise 
    </a>

    <ul class="navbar-nav mx-auto">
        <li class="nav-item">
            <a class="nav-link active" href="#">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('buses') }}">Buses</a>
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
                <strong>{{ Auth::user()->fname }}</strong></h4>
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

<div class="container-fluid p-4">
    <div class="row g-4">

        <!-- Left: Map -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Live Fleet Tracking</h5>
                    <p>
                        <span class="status-dot status-green"></span> On Time
                        <span class="status-dot status-yellow ms-3"></span> Delayed
                        <span class="status-dot status-red ms-3"></span> Critical
                    </p>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d489503.2144624953!2d120.10029996355897!3d16.564228294862644!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391909fd996bb73%3A0xa80df5423012ac11!2sLa%20Union!5e0!3m2!1sen!2sph!4v1755705284894!5m2!1sen!2sph" width="1200" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>

        <!-- Right: Active Buses -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100"style="max-height: 569px; overflow-y: auto;">
                <div class="card-body">
                    <h5 class="card-title mb-3">Active Buses</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>B12</strong> Route 42 - Downtown Express <br>
                                <small class="text-muted">Michael Thompson</small>
                            </div>
                            <span class="badge bg-success">On Time</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>B07</strong> Route 15 - Airport Shuttle <br>
                                <small class="text-muted">Sarah Johnson</small>
                            </div>
                            <span class="badge bg-success">On Time</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>B15</strong> Route 27 - Suburban Express <br>
                                <small class="text-muted">Emily Parker</small>
                            </div>
                            <span class="badge bg-warning text-dark">10 min delay</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>B09</strong> Route 51 - Harbor Line <br>
                                <small class="text-muted">David Martinez</small>
                            </div>
                            <span class="badge bg-danger">25 min delay</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>B12</strong> Route 42 - Downtown Express <br>
                                <small class="text-muted">Michael Thompson</small>
                            </div>
                            <span class="badge bg-success">On Time</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>B07</strong> Route 15 - Airport Shuttle <br>
                                <small class="text-muted">Sarah Johnson</small>
                            </div>
                            <span class="badge bg-success">On Time</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>B15</strong> Route 27 - Suburban Express <br>
                                <small class="text-muted">Emily Parker</small>
                            </div>
                            <span class="badge bg-warning text-dark">10 min delay</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>B09</strong> Route 51 - Harbor Line <br>
                                <small class="text-muted">David Martinez</small>
                            </div>
                            <span class="badge bg-danger">25 min delay</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>B12</strong> Route 42 - Downtown Express <br>
                                <small class="text-muted">Michael Thompson</small>
                            </div>
                            <span class="badge bg-success">On Time</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>B07</strong> Route 15 - Airport Shuttle <br>
                                <small class="text-muted">Sarah Johnson</small>
                            </div>
                            <span class="badge bg-success">On Time</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>B15</strong> Route 27 - Suburban Express <br>
                                <small class="text-muted">Emily Parker</small>
                            </div>
                            <span class="badge bg-warning text-dark">10 min delay</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>B09</strong> Route 51 - Harbor Line <br>
                                <small class="text-muted">David Martinez</small>
                            </div>
                            <span class="badge bg-danger">25 min delay</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom: Performance Analytics -->
        <div class="col-lg-12 mt-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card shadow-sm text-center p-3">
                        <h6>Passenger Count</h6>
                        <h3>24,587</h3>
                        <small class="text-success">▲ 12.5% vs last week</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm text-center p-3">
                        <h6>On-time Performance</h6>
                        <h3>92.3%</h3>
                        <small class="text-success">▲ 3.2% vs last month</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm text-center p-3">
                        <h6>Active Routes</h6>
                        <h3>12/15</h3>
                        <small class="text-muted">3 routes in maintenance</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm text-center p-3">
                        <h6>Daily Revenue</h6>
                        <h3>$8,745</h3>
                        <small class="text-success">▲ 5.7% vs yesterday</small>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function updateClock() {
    let now = new Date();

    let hours = now.getHours();
    let minutes = now.getMinutes().toString().padStart(2, '0');
    let ampm = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12;
    hours = hours ? hours : 12; // convert 0 -> 12

    document.getElementById('clock').textContent = `${hours}:${minutes} ${ampm}`;
  }

  setInterval(updateClock, 1000);
  updateClock(); // run once immediately
</script>
</body>
</html>
