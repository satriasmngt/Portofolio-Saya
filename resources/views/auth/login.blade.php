<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f4f8ff;
        }

        .card {
            border-radius: 14px;
            border: none;
        }

        /* Tombol custom */
        .btn-primary-custom {
            background-color: #0d6efd;
            border: none;
            color: #fff;
            font-weight: 500;
            transition: 0.2s;
        }

        /* Saat hover */
        .btn-primary-custom:hover {
            background-color: #0d6efd;
            color: #fff;
            opacity: 1;
        }

        /* Saat klik */
        .btn-primary-custom:active {
            background-color: #0d6efd !important;
            color: #fff;
        }

        /* Saat focus */
        .btn-primary-custom:focus {
            background-color: #0d6efd;
            color: #fff;
            box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, .3);
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
                            <div class="position-relative">
                                <input type="password" name="password" id="password" class="form-control pe-5" required>

                                <button type="button" id="togglePassword"
                                    class="btn position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent me-2">

                                    <i class="fa-solid fa-eye text-secondary"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100">
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

    <script>
        const toggle = document.getElementById('togglePassword');
const password = document.getElementById('password');
const icon = toggle.querySelector('i');

toggle.addEventListener('click', function () {
    const type = password.type === 'password' ? 'text' : 'password';
    password.type = type;

    icon.classList.toggle('bi-eye');
    icon.classList.toggle('bi-eye-slash');
});
    </script>
</body>

</html>