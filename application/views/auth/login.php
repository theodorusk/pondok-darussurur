<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Informasi Keuangan Pesantren</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        :root {
            --primary-color: #3597e1;
            /* Warna biru kustom */
            --primary-hover: #2e86d1;
        }

        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-image: url('<?= base_url('assets/img/bg-pesantren.jpg') ?>');
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
            background-color: rgba(248, 249, 250, 0.85);
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background: white;
            border: none;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header img {
            height: 60px;
            margin-bottom: 1.5rem;
        }

        .login-title {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .login-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }

        .form-control {
            height: 46px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 0.5rem 1rem;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .btn-login {
            background-color: var(--primary-color);
            border: none;
            height: 46px;
            font-weight: 500;
            width: 100%;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background-color: var(--primary-hover);
        }

        .copyright {
            text-align: center;
            margin-top: 2rem;
            color: #6c757d;
            font-size: 0.8rem;
        }

        /* Animasi */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card {
            animation: fadeIn 0.4s ease-out;
        }
    </style>
</head>

<body>
    <div class="container px-3">
        <div class="login-card mx-auto">
            <div class="login-header">
                <img src="<?= base_url('assets/img/logo/logo99.png') ?>" alt="Logo Pesantren" class="img-fluid" style="height: 150px;">
                <h1 class="login-title">Sistem Informasi Keuangan</h1>
                <p class="login-subtitle">Pondok Pesantren Darussurur</p>
            </div>

            <!-- Pesan error -->
            <div id="flash-message" data-error="<?= $this->session->flashdata('error') ?>"></div>

            <form id="loginForm" method="post" action="<?= base_url('auth/login') ?>">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                        <span class="input-group-text" id="toggle-password" style="cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-login mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk
                </button>
            </form>

            <div class="copyright">
                &copy; 2023 Pondok Pesantren Darussurur. All rights reserved.
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle flash messages dengan SweetAlert
            const errorMessage = document.getElementById('flash-message').getAttribute('data-error');

            if (errorMessage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: errorMessage,
                    confirmButtonColor: 'var(--primary-color)',
                    timer: 5000
                });
            }

            // Form submission handling
            const loginForm = document.getElementById('loginForm');
            loginForm.addEventListener('submit', function(e) {
                const submitBtn = loginForm.querySelector('button[type="submit"]');
                submitBtn.innerHTML = `
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Memproses...
                `;
                submitBtn.disabled = true;
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('toggle-password');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const icon = togglePassword.querySelector('i');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>

</html>