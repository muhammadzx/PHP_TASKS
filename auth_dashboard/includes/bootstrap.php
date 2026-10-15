<?php
declare(strict_types=1);
ini_set('session.use_strict_mode', '1');
session_set_cookie_params(['httponly' => true, 'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off', 'samesite' => 'Lax']);
session_start();
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
set_exception_handler(function (Throwable $e): void {
    error_log((string)$e);
    http_response_code(500);
    exit('Unable to complete the request. Check the database configuration and server error log.');
});
$config = require __DIR__ . '/../config.php';
$pdo = new PDO("mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset=utf8mb4", $config['username'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]);
function h($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function redirect(string $url): void { header('Location: ' . $url); exit; }
function post(string $key): string { return isset($_POST[$key]) && is_string($_POST[$key]) ? trim($_POST[$key]) : ''; }
function raw_password(): string { return isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password'] : ''; }
function csrf(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function csrf_field(): void { echo '<input type="hidden" name="csrf" value="' . h(csrf()) . '">'; }
function verify_csrf(): void { if (!hash_equals(csrf(), post('csrf'))) { http_response_code(403); exit('Invalid form token. Refresh and try again.'); } }
function require_admin(): void {
    global $pdo;
    if (empty($_SESSION['user_id'])) redirect('login.php');
    $q=$pdo->prepare('SELECT id,name,email FROM users WHERE id=?');
    $q->execute([$_SESSION['user_id']]); $current=$q->fetch();
    if (!$current) { $_SESSION=[]; redirect('login.php'); }
    $_SESSION['user_name']=$current['name']; $_SESSION['user_email']=$current['email'];
}
function validate_user(string $name,string $email,string $phone,string $password,bool $passwordRequired): array {
    $errors=[];
    if (strlen($name)<3 || strlen($name)>100 || !preg_match("/^[\\p{L}\\s'-]+$/u",$name)) $errors[]='Name must contain letters and be between 3 and 100 bytes.';
    if (!filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($email)>190) $errors[]='Enter a valid email (maximum 190 bytes).';
    if (!preg_match('/^[0-9]{10}$/D',$phone)) $errors[]='Phone number must contain exactly 10 digits.';
    if ($passwordRequired || $password!=='') {
        if (!valid_password($password) || !preg_match('/[A-Z]/',$password) || !preg_match('/[a-z]/',$password) || !preg_match('/[0-9]/',$password) || !preg_match('/[^a-zA-Z0-9]/',$password)) $errors[]='Password must be 8–72 bytes and include uppercase, lowercase, a number and a special character.';
    }
    return $errors;
}
function flash(string $message): void { $_SESSION['flash'] = $message; }
function valid_password(string $password): bool { return strlen($password) >= 8 && strlen($password) <= 72; }
