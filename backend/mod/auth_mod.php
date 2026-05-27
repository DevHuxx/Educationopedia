<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../admin/auth.php'; 

function initModSession(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_name('edu_mod');
        session_start();
    }
}

function isMod(): bool {
    initModSession();
    return !empty($_SESSION['mod_id']);
}

function requireMod(): void {
    if (!isMod()) {
        header('Location: login.php');
        exit;
    }
}

function modLogin(string $username, string $password, string $otpCode): array {
    $db = getDB();
    $stmt = $db->prepare("SELECT id, password_hash, totp_secret, full_name, active FROM mod_users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) return ['success' => false, 'error' => 'Invalid username'];
    if (!$user['active']) return ['success' => false, 'error' => 'Your account has been disabled. Contact admin.'];
    if (!password_verify($password, $user['password_hash'])) return ['success' => false, 'error' => 'Invalid password'];
    if (!TOTP::verify($user['totp_secret'], $otpCode)) return ['success' => false, 'error' => 'Invalid OTP. Check your Google Authenticator.'];

    initModSession();
    $_SESSION['mod_id']       = $user['id'];
    $_SESSION['mod_username'] = $username;
    $_SESSION['mod_name']     = $user['full_name'];

    return ['success' => true];
}

function modLogout(): void {
    initModSession();
    session_destroy();
}
