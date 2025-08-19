<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dispatcher Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="#">Dispatcher Dashboard</a>
    <div class="text-white">
        {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button class="btn btn-outline-light btn-sm ms-2">Logout</button>
        </form>
    </div>
</nav>

<div class="container mt-4">
    <h4>Today's Dispatch Jobs</h4>
    <table class="table table-bordered table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>Job ID</th>
                <th>Client</th>
                <th>Pickup</th>
                <th>Dropoff</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#1001</td>
                <td>John Doe</td>
                <td>Warehouse A</td>
                <td>Store B</td>
                <td><span class="badge bg-warning">Pending</span></td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>
