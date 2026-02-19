<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // 必须放在最开头！
    session_start();

    // 检查是否登录
    if (!isset($_SESSION['id'])) {
        echo '未登录，五秒后进入登录页面';
        echo '<meta http-equiv="refresh" content="5;url=../login/index.html">';
        exit;
    }

    // 连接数据库
    $db_path = __DIR__ . '/../db/main.db';
    try {
        $db = new PDO('sqlite:' . $db_path);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("数据库连接失败：" . $e->getMessage());
    }

    // 获取用户信息
    try {
        $stmt = $db->prepare(
            'SELECT id, username, create_at FROM users 
            WHERE id = :id 
            LIMIT 1'
        );
        $stmt->execute([':id' => $_SESSION['id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('数据库错误：' . $e->getMessage());
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
                <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                <p><strong>用户ID：</strong><?php echo $_SESSION['id']; ?></p>
                <p><strong>注册时间：</strong><?php echo htmlspecialchars($user['create_at']); ?></p>
                <?php echo isset($_SESSION['id']) ? '✅ 已登录' : '❌ 未登录'; ?>
            </div>

            <div style="margin-top: 20px;">
                <a href="/index.html" class="button">返回主页</a>
                <a href="logout.php" class="button" style="background: #ff4444;">退出登录</a>
            </div>
        </div>
    </div>
</body>
</html>