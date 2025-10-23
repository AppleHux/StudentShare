<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$file = $_FILES['file'] ?? [];
$tmp = $file['tmp_name'] ?? '';
$name = $file['name'] ?? '';
if ($tmp && $name && is_uploaded_file($tmp)){
    move_uploaded_file($tmp, __DIR__ . '/Files to be classified/' . basename($name));
    echo '上传成功：' . htmlspecialchars($name , ENT_QUOTES) . '五秒后回到主页';
    echo '<meta http-equiv="refresh" content="5;url=/">';
}else {
    echo '上传失败';
}