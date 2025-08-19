<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark text-center">
                    <h4>Forgot Password</h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.forgot-password.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Email:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <button class="btn btn-warning w-100">Send Reset Link</button>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <a href="{{ route('admin.login') }}">Back to Login</a>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>
