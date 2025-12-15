<?php
echo 'PHP 用户: ' . trim(shell_exec('whoami')) . PHP_EOL;
echo 'DB 路径: ' . realpath('/home/banana/Desktop/StudentShare/db/users.db') . PHP_EOL;

$db = new PDO('sqlite:/home/banana/Desktop/StudentShare/db/users.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
    $db->exec("INSERT INTO users (name,email,pass_hash) VALUES ('test','t@local','fake');");
    echo "✅ 写入成功";
} catch (Exception $e) {
    echo "❌ 写入失败: " . $e->getMessage();
}