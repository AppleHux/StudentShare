<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$file = $_FILES['file'] ?? [];
$tmp = $file['tmp_name'] ?? '';
$name = $file['name'] ?? '';
if ($tmp && $name && is_uploaded_file($tmp)){
    move_uploaded_file($tmp,$_SERVER['DOCUMENT_ROOT'] . '/Files to be classified/' . basename($name));
    echo '上传成功：' . htmlspecialchars($name , ENT_QUOTES) . '五秒后回到主页';
    echo '<meta http-equiv="refresh" content="5;url=/">';
}else {
    echo '上传失败';
}
$line = [$name, $_POST['department']??'', $_POST['category']??''];
file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/Files to be classified/collect.txt',
                  implode("\t", $line).PHP_EOL,
                  FILE_APPEND|LOCK_EX);
if (($file['error'] ?? 4) !== UPLOAD_ERR_OK) {
    exit('上传错误码：' . ($file['error'] ?? 4));
}