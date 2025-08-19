<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Suspended</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-danger d-flex align-items-center justify-content-center" style="height:100vh;">

<div class="card shadow-lg text-center" style="max-width: 500px; border-radius: 15px;">
    <div class="card-body">
        <h2 class="text-danger fw-bold">⚠ Account Suspended</h2>
        <p class="mt-3">
            Hello <strong>{{ Auth::user()->name }}</strong>, your account has been 
            <span class="text-danger fw-bold">suspended</span> by the administrator.
        </p>
        <p class="text-muted">Please contact support or your administrator for further assistance.</p>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-dark mt-3">Logout</button>
        </form>
    </div>
</div>

</body>
</html>
