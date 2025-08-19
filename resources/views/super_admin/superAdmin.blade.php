<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logged as {{ Auth::user()->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">SuperAdmin Panel</a>
        <div class="d-flex">
            <span class="text-white me-3">
                Logged in as: <strong>{{ Auth::user()->name }}</strong> 
                ({{ ucfirst(Auth::user()->role) }})
            </span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4 text-center">User Management</h2>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    {{-- Users Table --}}
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark text-center">
                <tr>
                    <th style="width: 20%">Name</th>
                    <th style="width: 25%">Email</th>
                    <th style="width: 20%">Role</th>
                    <th style="width: 20%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <form action="{{ route('superadmin.users.update', $user->id) }}" method="POST">
                            @csrf
                            <td>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" readonly >
                            </td>
                            <td>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" readonly >
                            </td>
                            <td>
                                <select name="role" class="form-select">
                                    <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                    <option value="dispatcher" {{ $user->role == 'dispatcher' ? 'selected' : '' }}>Dispatcher</option>
                                    <option value="finance" {{ $user->role == 'finance' ? 'selected' : '' }}>Finance</option>
                                    <option value="Pending" {{ $user->role == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="suspended" {{ $user->role == 'suspended' ? 'selected' : '' }}>SUSPENDED</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm me-1">Update</button>
                        </form>

                        <form action="{{ route('superadmin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to revoke this account?');">
                                Revoke
                            </button>
                        </form>
                            </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
