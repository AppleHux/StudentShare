<?php
// 必须放在最开头！
session_start();

// 检查是否登录
if (!isset($_SESSION['user_id'])) {
    // 没登录就跳转到登录页
    header('Location: /login/login.html');
    exit;
}

// 连接数据库
$dbFile = __DIR__ . '/../db/users.db';
$pdo = new PDO('sqlite:' . $dbFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 获取用户信息（包含注册时间）
$stmt = $pdo->prepare('SELECT name, created_at FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    die('用户不存在');
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人空间</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/nav.css">
    <style>
        .user-space {
            text-align: center;
            padding: 20px;
        }
        .user-info {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin: 20px auto;
            max-width: 500px;
        }
    </style>
</head>
<body>
    <div id="nav-placeholder"></div>
    <script>
        fetch('/html/nav.html')
        .then(res => res.text())
        .then(html => document.getElementById('nav-placeholder').innerHTML = html);
    </script>
    
    <div class="container">
        <div class="user-space">
            <h1>🎉 欢迎来到你的个人空间</h1>
            
            <div class="user-info">
                <h2><?php echo htmlspecialchars($user['name']); ?></h2>
                <p><strong>用户ID：</strong><?php echo $_SESSION['user_id']; ?></p>
                <p><strong>注册时间：</strong><?php echo htmlspecialchars($user['created_at']); ?></p>
                <p><strong>登录状态：</strong>✅ 已登录</p>
            </div>

            <div style="margin-top: 20px;">
                <a href="/index.html" class="button">返回主页</a>
                <a href="logout.php" class="button" style="background: #ff4444;">退出登录</a>
            </div>
        </div>
    </div>
</body>
</html>