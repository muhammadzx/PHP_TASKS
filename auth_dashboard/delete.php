<?php
require __DIR__ . '/includes/bootstrap.php'; require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); header('Allow: POST'); exit; }
verify_csrf();
$id=filter_var(post('id'),FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]);
$entity=post('entity');
if (!$id || !in_array($entity,['user','product'],true)) { http_response_code(400); exit('Invalid delete request.'); }
if ($entity==='user') $q=$pdo->prepare('DELETE FROM users WHERE id=?');
else $q=$pdo->prepare('DELETE FROM products WHERE id=?');
$q->execute([$id]);
if ($entity==='user' && (int)$id===(int)$_SESSION['user_id']) { $_SESSION=[]; session_destroy(); redirect('login.php'); }
flash($q->rowCount() ? ucfirst($entity).' deleted successfully.' : 'Record no longer exists.');
redirect('users.php#'.($entity==='user' ? 'users' : 'products'));
