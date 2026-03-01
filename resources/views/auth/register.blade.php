<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .password-toggle {
            width: 42px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .password-toggle i {
            transition: 0.2s;
        }

        .password-toggle:hover i {
            color: #0d6efd;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-4">

                    <h4 class="text-center mb-4 text-primary fw-bold">Register</h4>

                    <form id="registerForm" action="{{ url('/register') }}" method="POST">
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
                            <div class="position-relative">
                                <input type="password" id="password" name="password" class="form-control pe-5" required>

                                <span class="position-absolute top-0 end-0 password-toggle" data-target="password">
                                    <i class="fa-solid fa-eye text-secondary"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Konfirmasi Password</label>

                            <div class="position-relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control pe-5" required>

                                <span class="position-absolute top-0 end-0 password-toggle"
                                    data-target="password_confirmation">
                                    <i class="fa-solid fa-eye text-secondary"></i>
                                </span>
                            </div>

                            <div class="invalid-feedback">
                                Password tidak cocok
                            </div>
                        </div>
                        <button type="submit" id="submitBtn" class="btn btn-primary-custom w-100">
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
        const form = document.getElementById("registerForm");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("password_confirmation");
    const submitBtn = document.getElementById("submitBtn");

    function validatePassword() {

        // Jika salah satu kosong → disable submit
        if (password.value === "" || confirmPassword.value === "") {
            confirmPassword.classList.remove("is-invalid", "is-valid");
            submitBtn.disabled = true;
            return false;
        }

        // Jika tidak cocok
        if (password.value !== confirmPassword.value) {
            confirmPassword.classList.add("is-invalid");
            confirmPassword.classList.remove("is-valid");
            submitBtn.disabled = true;
            return false;
        }

        // Jika cocok
        confirmPassword.classList.remove("is-invalid");
        confirmPassword.classList.add("is-valid");
        submitBtn.disabled = false;
        return true;
    }

    password.addEventListener("input", validatePassword);
    confirmPassword.addEventListener("input", validatePassword);

    // Blok submit kalau tidak valid
    form.addEventListener("submit", function (e) {
        if (!validatePassword()) {
            e.preventDefault();
        }
    });

    // Toggle password
    document.querySelectorAll(".password-toggle").forEach(toggle => {
        toggle.addEventListener("click", function () {
            const input = document.getElementById(this.dataset.target);
            const icon = this.querySelector("i");

            input.type = input.type === "password" ? "text" : "password";

            icon.classList.toggle("fa-eye");
            icon.classList.toggle("fa-eye-slash");
        });
    });

    // Disable tombol saat pertama load
    submitBtn.disabled = true;
    </script>
</body>

</html>