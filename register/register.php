<?php
    // 内容取值
    $username = trim($_POST["name"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $pass = trim($_POST["pass"] ?? '');
    $qpass = trim($_POST["qpass"] ?? '');

    // 有效性校验
    if(empty($username)){
        die("昵称不能为空");
    }
    if(empty($pass)){
        die("密码不能为空");
    }
    if($pass!==$qpass){
        die("两次输入的密码不一致");
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        die("请输入有效的邮箱格式");
    } 
    
    // 密码加密
    $passhash = password_hash($pass, PASSWORD_DEFAULT);

    // 连接数据库
<<<<<<< HEAD
    $db_path = __DIR__ . '/../db/main.db';
    try {
        $db = new PDO('sqlite:' . $db_path);
=======
    $db_PATH = __DIR__ . '/../db/main.db';
    try {
        $db = new PDO('sqlite:' . $db_PATH);
>>>>>>> 117fa25395038868824c9ee824bad9d400f44ccb
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("数据库连接失败：" . $e->getMessage());
    }

    // 预处理与插入
    try {
        $stmt = $db->prepare("INSERT INTO users (username, email, passhash) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $passhash]);
        echo '注册成功，五秒后进入登录页面';
        echo '<meta http-equiv="refresh" content="5;url=../login/index.html">';
    } catch (PDOException $e) {
        if (in_array($e->getCode(), [19, 2067])) {
            die('昵称已存在');
        }else {
            die('数据库错误：' . $e->getMessage());
        }
    }


