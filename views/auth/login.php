<?php
// Redirect logged-in users to their dashboard
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: /mini_OnShop/admin/dashboard');
    } elseif ($_SESSION['role'] === 'seller') {
        header('Location: /mini_OnShop/seller/dashboard');
    } else {
        header('Location: /mini_OnShop/customer/home');
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - mini_OnShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .auth-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 15px;
        }
        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 40px 35px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        .auth-logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .auth-logo i { font-size: 28px; color: #fff; }
        .auth-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a2e;
            text-align: center;
            margin-bottom: 6px;
        }
        .auth-subtitle {
            font-size: 14px;
            color: #6c757d;
            text-align: center;
            margin-bottom: 28px;
        }
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 6px;
        }
        .input-group-text {
            background: #f8f9fa;
            border-right: none;
            color: #6c757d;
        }
        .form-control {
            border-left: none;
            padding: 10px 14px;
            font-size: 14px;
            transition: box-shadow 0.2s;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
            border-color: #667eea;
        }
        .input-group:focus-within .input-group-text {
            border-color: #667eea;
            color: #667eea;
        }
        .btn-auth {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            padding: 11px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            color: #fff;
            width: 100%;
            transition: transform 0.15s, box-shadow 0.15s;
        }
        .btn-auth:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: #fff;
        }
        .auth-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }
        .auth-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .auth-footer a:hover { text-decoration: underline; }
        .alert { font-size: 13px; border-radius: 8px; }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo">
            <i class="bi bi-shop"></i>
        </div>
        <h1 class="auth-title">Welcome Back</h1>
        <p class="auth-subtitle">Sign in to your mini_OnShop account</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                Invalid username or password
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['registered'])): ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                Registration successful! Please login.
            </div>
        <?php endif; ?>

        <form method="POST" action="/mini_OnShop/auth/handleLogin">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="name" class="form-control" placeholder="Enter your username" required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-auth">Sign In</button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="/mini_OnShop/auth/signup">Create one</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
