<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<pre>收到数据：';
    print_r($_POST);
    exit;
}
?>
<form method="post">
    <input name="name" placeholder="昵称">
    <input type="submit" value="注册">
</form>