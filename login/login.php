<?php
    $dbFile = __DIR__ . '/../db/users.db';
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pass_hash = password_hash($_POST["pass"], PASSWORD_DEFAULT);
    $name = $_POST["name"];

    $stmt = $pdo->prepare(
    'SELECT id, pass_hash FROM users WHERE name = :login OR email = :login LIMIT 1'
    );
    $stmt->execute([':login' => $_POST['name']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user === false) {
        die('邮箱或昵称不存在');
    }
    if (!$user || password_verify($_POST['pass'], $user['pass_hash'])) {
        echo"登陆成功";
        echo "<script>window.location.href='/user/user.php?uname=$name'</script>";
    }  else{
        die('用户名或密码错误');
    }
