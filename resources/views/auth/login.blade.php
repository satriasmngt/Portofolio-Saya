<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f8ff;
        }
        .card {
            border-radius: 14px;
            border: none;
        }
        .btn-primary-custom {
            background-color: #0d6efd;
            border: none;
        }
    </style>
</head>

<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body p-4">
                <h4 class="text-center mb-4 text-primary fw-bold">Login</h4>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ url('/login') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button class="btn btn-primary-custom text-white w-100">
                        Login
                    </button>
                </form>

                <p class="text-center mt-3">
                    Belum punya akun?
                    <a href="{{ route('register') }}">Register</a>
                </p>
            </div>
        </div>
    </div>
</div>
</body>
</html>