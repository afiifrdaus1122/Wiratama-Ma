<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - PT Wiratama Mitra Abadi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .admin-login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }
        .admin-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.5);
            padding: 40px;
        }
        .brand-logo {
            width: 64px;
            height: 64px;
            object-fit: contain;
            margin-bottom: 20px;
        }
        .form-control {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        .form-control:focus {
            background-color: #fff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        .btn-login {
            background: #0f172a;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            margin-top: 24px;
            transition: all 0.2s;
        }
        .btn-login:hover {
            background: #1e293b;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
        }
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
        }
        
        /* Hide native Edge/IE password reveal icon */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
    </style>
</head>
<body>

    <div class="admin-login-wrapper">
        <div class="admin-card">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="WMA Logo" class="brand-logo">
                <h4 class="fw-bold text-dark mb-1">Admin Portal</h4>
                <p class="text-muted small">Sign in to manage your system</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger py-2 px-3 text-center" style="font-size: 0.85rem; border-radius: 8px;">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label mb-0">Password</label>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" required style="border-right: none;">
                        <button class="btn border form-control-bg" type="button" id="togglePassword" style="background-color: #f8fafc; border-left: none; border-color: #e2e8f0; width: 45px; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                            <i class="bi bi-eye-slash text-muted"></i>
                        </button>
                    </div>
                </div>

                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-muted" for="remember" style="font-size: 0.85rem;">
                        Keep me signed in
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    Sign In to Dashboard
                </button>
            </form>

            <div class="text-center mt-4 pt-3 border-top">
                <a href="{{ url('/') }}" class="text-decoration-none text-muted" style="font-size: 0.85rem;">
                    <i class="bi bi-arrow-left me-1"></i> Return to Storefront
                </a>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <p class="text-muted" style="font-size: 0.75rem;">&copy; {{ date('Y') }} PT Wiratama Mitra Abadi. All rights reserved.</p>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function (e) {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                password.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
        
        // Match focus state styling for the input group
        document.getElementById('password').addEventListener('focus', function() {
            document.getElementById('togglePassword').style.borderColor = '#3b82f6';
            document.getElementById('togglePassword').style.backgroundColor = '#fff';
            this.style.backgroundColor = '#fff';
        });
        document.getElementById('password').addEventListener('blur', function() {
            document.getElementById('togglePassword').style.borderColor = '#e2e8f0';
            document.getElementById('togglePassword').style.backgroundColor = '#f8fafc';
            this.style.backgroundColor = '#f8fafc';
        });
    </script>
</body>
</html>