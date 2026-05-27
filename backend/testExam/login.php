<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
require_once __DIR__ . '/../config.php';
session_start();

define('EXAM_ADMIN_USER', 'examadmin');
define('EXAM_ADMIN_PASS', 'ExamPass@2026');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? '');
    $p = trim($_POST['password'] ?? '');
    if ($u === EXAM_ADMIN_USER && $p === EXAM_ADMIN_PASS) {
        $_SESSION['exam_admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Exam Admin Login — Educationopedia</title>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'Segoe UI', Arial, sans-serif;
    min-height: 100vh;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #312e81 100%);
  }
  .card {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 16px;
    padding: 48px 40px;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 25px 60px rgba(0,0,0,.5);
  }
  .logo { text-align: center; margin-bottom: 28px; }
  .logo h1 { font-size: 22px; color: #f8fafc; letter-spacing: .5px; }
  .logo h1 span { color: #818cf8; }
  .logo p { color: #94a3b8; font-size: 13px; margin-top: 4px; }
  label { display: block; font-size: 12px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; }
  input {
    width: 100%; padding: 11px 14px;
    background: #0f172a; border: 1px solid #334155; border-radius: 8px;
    color: #f1f5f9; font-size: 14px; outline: none;
    transition: border-color .2s;
  }
  input:focus { border-color: #818cf8; }
  .field { margin-bottom: 18px; }
  .btn {
    width: 100%; padding: 13px;
    background: linear-gradient(135deg, #6366f1, #818cf8);
    color: #fff; font-size: 15px; font-weight: 700;
    border: none; border-radius: 8px; cursor: pointer;
    margin-top: 8px; transition: opacity .2s;
  }
  .btn:hover { opacity: .88; }
  .error { background: #450a0a; border: 1px solid #7f1d1d; color: #fca5a5; padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 18px; }
  .badge { display: inline-block; background: #312e81; color: #a5b4fc; font-size: 11px; font-weight: 700; border-radius: 20px; padding: 3px 10px; margin-bottom: 18px; }
</style>
</head>
<body>
<div class="card">
  <div class="logo">
    <h1>EDUCATION<span>OPEDIA</span></h1>
    <p>Exam Admin Panel</p>
  </div>
  <div style="text-align:center;"><span class="badge">🎓 Scholarship Exam Management</span></div>
  <?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="field">
      <label>Username</label>
      <input type="text" name="username" autocomplete="username" required placeholder="examadmin" />
    </div>
    <div class="field">
      <label>Password</label>
      <input type="password" name="password" autocomplete="current-password" required placeholder="••••••••" />
    </div>
    <button type="submit" class="btn">Sign In →</button>
  </form>
</div>
</body>
</html>
