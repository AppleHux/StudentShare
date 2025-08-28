<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/main.css" />
    <link rel="stylesheet" href="/css/nav.css" />
    <link rel="stylesheet" href="register.css" />
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <div class="login-ly">
            <div class="login-h-ly"><h2>海大海科学生会<br>文件分享站</h2></div>
            <form class="form" action="register.php" method="post" novalidate>
                <div class="form-ly"><label for="name"></label>
                <input type="text" id="name" name="name" placeholder="请设置昵称"></div>
                <div><label for="pass"></label>
                <input type="text" id="pass" name="pass" placeholder="请设置密码"></div>
                <div><label for="qpass"></label>
                <input type="text" id="qpass" name="qpass" placeholder="请重复密码"></div>
                <div><label for="email"></label>
                <input type="text" id="email" name="email" placeholder="请输入邮箱"></div>
                <input type="submit" value="登录" name="login">
                <a href="">还没有账号，去注册一个</a>
                </form>
            </div>
            
        </div>
</body>
</html>