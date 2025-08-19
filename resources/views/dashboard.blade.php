<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">SuperAdmin </a>
        <div class="d-flex">
            <span class="navbar-text text-white me-3">
                {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
            </span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <!-- Welcome Message -->
    <div class="alert alert-info text-center shadow-sm">
        <h4 class="mb-0">👋 Hello, <strong>{{ Auth::user()->name }}</strong>!</h4>
        <small>Please kindly wait for the confirmation of the admins.</small>
    </div>


</body>
</html>
