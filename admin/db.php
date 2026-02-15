<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo '<h1>hello</h1>';

try {
    $db = new SQLite3('/var/www/StudentShare/db/main.db');
    echo '连接成功！';
    // 可以继续执行数据库操作...
} catch (Exception $e) {
    die('连接失败：' . $e->getMessage());
}

?>