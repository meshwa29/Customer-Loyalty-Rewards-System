<?php
// Local XAMPP configuration. Update these values if your MySQL setup differs.
const DB_HOST = 'localhost';
const DB_NAME = 'loyalty_rewards';
const DB_USER = 'root';
const DB_PASS = '';
const APP_NAME = 'Factory Rewards';
const POINTS_PER_CODE = 10;
const MAX_CODE_ATTEMPTS_PER_HOUR = 20;

if (session_status() === PHP_SESSION_NONE) { session_start(); }

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
    return $pdo;
}
function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function redirect(string $url): never { header('Location: ' . $url); exit; }
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function verify_csrf(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419); exit('Invalid form token. Please go back and try again.');
    }
}
function flash(string $message, string $type = 'success'): void { $_SESSION['flash'] = [$message, $type]; }
function show_flash(): void {
    if (!empty($_SESSION['flash'])) { [$m,$t] = $_SESSION['flash']; unset($_SESSION['flash']); echo '<div class="alert '.e($t).'">'.e($m).'</div>'; }
}
function require_customer(): void { if (empty($_SESSION['customer_id'])) redirect('../login.php'); }
function require_admin(): void { if (empty($_SESSION['admin_id'])) redirect('../admin/login.php'); }
function current_customer(): ?array {
    if (empty($_SESSION['customer_id'])) return null;
    $s = db()->prepare('SELECT id,name,email,phone,points,created_at FROM customers WHERE id=?');
    $s->execute([$_SESSION['customer_id']]); return $s->fetch() ?: null;
}
function page_start(string $title): void {
    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'.e($title).' | '.APP_NAME.'</title><link rel="stylesheet" href="'.(str_contains($_SERVER['PHP_SELF'],'/admin/') || str_contains($_SERVER['PHP_SELF'],'/customer/') ? '../assets/style.css' : 'assets/style.css').'"></head><body><header class="top"><a class="brand" href="'.(str_contains($_SERVER['PHP_SELF'],'/admin/') || str_contains($_SERVER['PHP_SELF'],'/customer/') ? '../index.php' : 'index.php').'">★ '.APP_NAME.'</a><nav>';
    if (!empty($_SESSION['admin_id'])) echo '<a href="dashboard.php">Dashboard</a><a href="codes.php">Codes</a><a href="customers.php">Customers</a><a href="rewards.php">Rewards</a><a href="reward_requests.php">Reward requests</a><a href="logout.php">Logout</a>';
    elseif (!empty($_SESSION['customer_id'])) echo '<a href="'.(str_contains($_SERVER['PHP_SELF'],'/customer/')?'dashboard.php':'customer/dashboard.php').'">My Rewards</a><a href="'.(str_contains($_SERVER['PHP_SELF'],'/customer/')?'../':'').'logout.php">Logout</a>';
    else echo '<a href="index.php">Home</a><a href="login.php">Customer Login</a><a href="register.php">Register</a><a href="admin/login.php">Admin</a>';
    echo '</nav></header><main class="container"><h1>'.e($title).'</h1>'; show_flash();
}
function page_end(): void { echo '</main><footer>Factory Rewards · Secure one-time product code redemption</footer></body></html>'; }
?>
