<?php
session_start();

$dbFile = __DIR__ . '/../db/users.db';
$pdo = new PDO('sqlite:' . $dbFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 过滤用户输入
$login = trim($_POST["name"]);

// 查询时获取用户名
$stmt = $pdo->prepare(
    'SELECT id, name, pass_hash FROM users WHERE name = :login OR email = :login LIMIT 1'
);
$stmt->execute([':login' => $login]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user === false) {
    die('邮箱或昵称不存在');
}

if (!password_verify($_POST['pass'], $user['pass_hash'])) {
    die('用户名或密码错误');
}

// 登录成功
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];  // 使用数据库中的用户名

// 使用 header 重定向
header('Location: /space/index.php');
exit;