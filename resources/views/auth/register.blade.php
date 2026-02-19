<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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

        /* Hover */
        .btn-primary-custom:hover {
            background-color: #0d6efd;
            color: #fff;
            opacity: 1;
        }

        /* Klik */
        .btn-primary-custom:active {
            background-color: #0d6efd !important;
            color: #fff;
        }

        /* Focus */
        .btn-primary-custom:focus {
            background-color: #0d6efd;
            color: #fff;
            box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, .3);
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-4">

                    <h4 class="text-center mb-4 text-primary fw-bold">Register</h4>

                    <form action="{{ url('/register') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" required>

                            <div class="invalid-feedback">
                                Password tidak cocok
                            </div>
                        </div>
                            <button type="submit" class="btn btn-primary-custom w-100">
                                Register
                            </button>
                    </form>

                    <p class="text-center mt-3">
                        Sudah punya akun?
                        <a href="{{ route('login') }}">Login</a>
                    </p>

                </div>
            </div>
        </div>
    </div>


    <script>
        const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');

    function checkPasswordMatch() {
        if (confirmPassword.value === "") {
            confirmPassword.classList.remove("is-invalid");
            confirmPassword.classList.remove("is-valid");
            return;
        }

        if (password.value !== confirmPassword.value) {
            confirmPassword.classList.add("is-invalid");
            confirmPassword.classList.remove("is-valid");
        } else {
            confirmPassword.classList.remove("is-invalid");
            confirmPassword.classList.add("is-valid");
        }
    }

    password.addEventListener("input", checkPasswordMatch);
    confirmPassword.addEventListener("input", checkPasswordMatch);
    </script>
</body>

</html>