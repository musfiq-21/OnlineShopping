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
    <title>Sign Up - mini_OnShop</title>
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
            max-width: 440px;
            padding: 15px;
        }
        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 36px 35px;
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
            margin-bottom: 26px;
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
        .form-control, .form-select {
            border-left: none;
            padding: 10px 14px;
            font-size: 14px;
            transition: box-shadow 0.2s;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
            border-color: #667eea;
        }
        .input-group:focus-within .input-group-text {
            border-color: #667eea;
            color: #667eea;
        }
        .role-option {
            display: none;
        }
        .role-cards {
            display: flex;
            gap: 10px;
        }
        .role-card {
            flex: 1;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 14px 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .role-card:hover {
            border-color: #b8c0ea;
            background: #f8f9ff;
        }
        .role-card.active {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102,126,234,0.08), rgba(118,75,162,0.08));
        }
        .role-card i {
            font-size: 22px;
            display: block;
            margin-bottom: 5px;
            color: #6c757d;
        }
        .role-card.active i { color: #667eea; }
        .role-card span {
            font-size: 12px;
            font-weight: 600;
            color: #495057;
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
        .pw-row { display: flex; gap: 12px; }
        .pw-row > div { flex: 1; }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo">
            <i class="bi bi-shop"></i>
        </div>
        <h1 class="auth-title">Create Account</h1>
        <p class="auth-subtitle">Join mini_OnShop and start exploring</p>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'exists'): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                Username already exists. Try a different one.
            </div>
        <?php endif; ?>

        <form method="POST" action="/mini_OnShop/auth/handleSignup">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="name" class="form-control" placeholder="Choose a username" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">I want to join as</label>
                <input type="hidden" name="role" id="roleInput" value="customer">
                <div class="role-cards">
                    <div class="role-card active" data-role="customer" onclick="selectRole(this)">
                        <i class="bi bi-bag-heart"></i>
                        <span>Customer</span>
                    </div>
                    <div class="role-card" data-role="seller" onclick="selectRole(this)">
                        <i class="bi bi-shop-window"></i>
                        <span>Seller</span>
                    </div>
                </div>
            </div>

            <div class="pw-row mb-3">
                <div>
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Create" required>
                    </div>
                </div>
                <div>
                    <label class="form-label">Confirm</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-auth">Create Account</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="/mini_OnShop/auth/login">Sign in</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function selectRole(el) {
    document.querySelectorAll('.role-card').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('roleInput').value = el.dataset.role;
}
</script>
</body>
</html>
