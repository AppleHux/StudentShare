<?php
    session_start();

    // 内容取值
    $username = trim($_POST["name"] ?? '');
    $pass = trim($_POST["pass"] ?? '');
    
    // 有效性校验
    if(empty($username)){
        die("昵称不能为空");
    }
    if(empty($pass)){
        die("密码不能为空");
    }

    // 连接数据库
    $db_path = __DIR__ . '/../db/main.db';
    try {
        $db = new PDO('sqlite:' . $db_path);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("数据库连接失败：" . $e->getMessage());
    }



    // 查询获取相关信息并比较密码
    try {
        $stmt = $db->prepare(
            'SELECT id, username, passhash FROM users 
            WHERE username = :username 
            LIMIT 1'
        );
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            die('昵称不存在');
        }
        if (!password_verify($pass, $user['passhash'])) {
            die('昵称或密码错误');
        }

        $_SESSION['id'] = $user['id'];
        echo '登录成功，五秒后进入个人空间';
        echo '<meta http-equiv="refresh" content="5;url=../space/index.php">';
    } catch (PDOException $e) {
        die('数据库错误：' . $e->getMessage());
    }
    