<?php
    
    session_start();

    $_SESSION = [];
    
    echo '退出成功，五秒后进入主页';
    echo '<meta http-equiv="refresh" content="5;url=../index.html">';