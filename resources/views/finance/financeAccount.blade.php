<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finance Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-success px-3">
    <a class="navbar-brand" href="#">Finance Dashboard</a>
    <div class="text-white">
        {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button class="btn btn-outline-light btn-sm ms-2">Logout</button>
        </form>
    </div>
</nav>

<div class="container mt-4">
    <div class="row text-center">
        <div class="col-md-4">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5>Total Revenue</h5>
                    <p class="fs-4">$120,000</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-danger mb-3">
                <div class="card-body">
                    <h5>Outstanding Payments</h5>
                    <p class="fs-4">$15,000</p>
                </div>
            </div>
        </div>
    </div>

    <h4>Recent Transactions</h4>
    <table class="table table-striped mt-3">
        <thead class="table-success">
            <tr>
                <th>Invoice #</th>
                <th>Client</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>INV-001</td>
                <td>Acme Corp</td>
                <td>$5,000</td>
                <td><span class="badge bg-success">Paid</span></td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>
