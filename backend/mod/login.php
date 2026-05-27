<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
require_once __DIR__ . '/auth_mod.php';
initModSession();

if (isMod()) { header('Location: index.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = modLogin($_POST['username'] ?? '', $_POST['password'] ?? '', $_POST['otp'] ?? '');
    if ($result['success']) {
        header('Location: index.php');
        exit;
    }
    $error = $result['error'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mod Login — Educationopedia</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { min-height: 100vh; display: flex; align-items: center; justify-content: center;
         background: #0f172a; font-family: 'Segoe UI', sans-serif; }
  .card { background: #1e293b; border: 1px solid #334155; border-radius: 16px;
          padding: 40px; width: 100%; max-width: 400px; }
  .logo { text-align: center; margin-bottom: 28px; }
  .logo h1 { color: #f8fafc; font-size: 22px; font-weight: 700; }
  .logo h1 span { color: #6366f1; }
  .logo p { color: #94a3b8; font-size: 13px; margin-top: 4px; }
  .badge { display: inline-block; background: #6366f1/20; color: #818cf8;
           border: 1px solid #6366f1; border-radius: 20px; padding: 3px 12px;
           font-size: 11px; font-weight: 600; margin-bottom: 20px; text-align: center; width: 100%; }
  label { display: block; color: #94a3b8; font-size: 12px; font-weight: 600;
          text-transform: uppercase; letter-spacing: .05em; margin-bottom: 6px; margin-top: 16px; }
  input { width: 100%; padding: 10px 14px; background: #0f172a; border: 1px solid #334155;
          border-radius: 8px; color: #f1f5f9; font-size: 14px; outline: none; }
  input:focus { border-color: #6366f1; }
  .btn { width: 100%; margin-top: 24px; padding: 12px; background: #6366f1;
         color: #fff; border: none; border-radius: 8px; font-size: 15px;
         font-weight: 600; cursor: pointer; }
  .btn:hover { background: #4f46e5; }
  .error { background: #450a0a; border: 1px solid #b91c1c; color: #fca5a5;
           border-radius: 8px; padding: 10px 14px; font-size: 13px; margin-top: 16px; }
  .admin-link { text-align: center; margin-top: 20px; }
  .admin-link a { color: #64748b; font-size: 12px; text-decoration: none; }
  .admin-link a:hover { color: #94a3b8; }
</style>
</head>
<body>
<div class="card">
  <div class="logo">
    <h1>EDUCATION<span>OPEDIA</span></h1>
    <p>Moderator Portal</p>
  </div>
  <div class="badge">🎯 Mod Access</div>
  <form method="POST">
    <label>Username</label>
    <input type="text" name="username" required placeholder="your_username">
    <label>Password</label>
    <input type="password" name="password" required placeholder="••••••••">
    <label>Google Authenticator Code</label>
    <input type="text" name="otp" required placeholder="6-digit code" maxlength="6" inputmode="numeric">
    <?php if ($error): ?>
      <div class="error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <button type="submit" class="btn">Login to Mod Portal</button>
  </form>
  <div class="admin-link"><a href="../admin/login.php">← Admin Login</a></div>
</div>
</body>
</html>
