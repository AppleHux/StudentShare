<?php
    if(empty($_POST["name"])){
        die("昵称不能为空");
    }
    if($_POST["pass"]!==$_POST["qpass"]){
        die("两次输入的密码不一致");
    }
    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        die("请输入有效的邮箱格式");
    } 
    $pass_hash = password_hash($_POST["pass"], PASSWORD_DEFAULT);
    
    $dbFile = __DIR__ . '/../users.db';
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id        INTEGER PRIMARY KEY AUTOINCREMENT,
        name      TEXT NOT NULL UNIQUE,
        email     TEXT NOT NULL UNIQUE,
        pass_hash TEXT NOT NULL
    )
    ");
    try {
    $stmt = $pdo->prepare("INSERT INTO users (name, email, pass_hash) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['email'], $pass_hash]);
    echo '注册成功';
    } 
    catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            die('昵称或邮箱已存在');
        } else {
        die('数据库错误：' . $e->getMessage());
        }
    }
