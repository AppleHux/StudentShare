<?php
    // 开启会话
    session_start();

    // 检测登录状态
    if (!isset($_SESSION['id'])){
        echo '留言请先登录，五秒后进入登录页面';
        echo '<meta http-equiv="refresh" content="5;url=../login/index.html">';
        exit;
        }

    // 内容取值
    $user_id = intval($_SESSION['id']);
    $note = trim($_POST["note"]);

    // 有效性校验
    if(empty($note)){
        die("内容不能为空");
    }

    // 连接数据库
    $db_path = __DIR__ . '/../db/main.db';
    try {
        $db = new PDO('sqlite:' . $db_path);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("数据库连接失败：" . $e->getMessage());
    }

    // 写入
    try {
        $stmt = $db->prepare("INSERT INTO notes (user_id,content) VALUES (?, ?)");
        $stmt->execute([$user_id,$note]);
        echo '留言成功,五秒后返回留言页面';
        echo '<meta http-equiv="refresh" content="5;url=index.html">';
    } catch (PDOException $e) {
        echo '留言失败：' . $e->getMessage();
    }
