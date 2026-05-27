<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
require_once __DIR__ . '/../config.php'; require_once __DIR__ . '/auth.php'; initSession(); if (isAdmin()) { header('Location: index.php'); exit; } $error = ''; if ($_SERVER['REQUEST_METHOD'] === 'POST') { $username = trim($_POST['username'] ?? ''); $password = $_POST['password'] ?? ''; $otp = trim($_POST['otp'] ?? ''); if (empty($username) || empty($password) || empty($otp)) { $error = 'All fields are required.'; } else { $result = adminLogin($username, $password, $otp); if ($result['success']) { header('Location: index.php'); exit; } else { $error = $result['error']; } } } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Educationopedia CMS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #0f172a; color: #e2e8f0; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: #1e293b; border: 1px solid #334155; border-radius: 16px; padding: 48px; max-width: 420px; width: 100%; margin: 20px; }
        .logo { text-align: center; margin-bottom: 32px; }
        .logo h2 { font-size: 22px; font-weight: 800; letter-spacing: -0.5px; }
        .logo h2 span { color: #3b82f6; }
        .logo p { font-size: 13px; color: #64748b; margin-top: 4px; }
        label { display: block; font-size: 13px; font-weight: 600; color: #94a3b8; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
        input { width: 100%; padding: 12px 16px; background: #0f172a; border: 1px solid #334155; border-radius: 10px; color: #e2e8f0; font-size: 15px; outline: none; transition: border 0.2s; }
        input:focus { border-color: #3b82f6; }
        input::placeholder { color: #475569; }
        .field { margin-bottom: 20px; }
        .btn { display: block; width: 100%; background: #3b82f6; color: #fff; border: none; padding: 14px; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .btn:hover { background: #2563eb; }
        .error { background: #7f1d1d; border: 1px solid #ef4444; border-radius: 10px; padding: 12px; margin-bottom: 20px; font-size: 13px; color: #fca5a5; text-align: center; }
        .otp-hint { font-size: 12px; color: #64748b; margin-top: 4px; }
        .lock-icon { font-size: 40px; text-align: center; margin-bottom: 12px; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">
        <div class="lock-icon">🔐</div>
        <h2>EDUCATION<span>OPEDIA</span></h2>
        <p>Admin Panel — Secure Login</p>
    </div>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="field">
            <label>Username</label>
            <input type="text" name="username" placeholder="admin" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autocomplete="username" />
        </div>

        <div class="field">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
        </div>

        <div class="field">
            <label>Google Authenticator OTP</label>
            <input type="text" name="otp" placeholder="6-digit code" maxlength="6" pattern="[0-9]{6}" required inputmode="numeric" autocomplete="one-time-code" />
            <div class="otp-hint">Open Google Authenticator and enter the 6-digit code</div>
        </div>

        <button type="submit" class="btn">Login →</button>
    </form>
</div>
</body>
</html>
