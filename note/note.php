<?php
    if(empty($_POST["name"])){
        die("昵称不能为空");
    }
    if(empty($_POST["note"])){
        die("内容不能为空");
    }
    $dbFile = __DIR__ . '/../db/note.db';
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("
    CREATE TABLE IF NOT EXISTS note (
        id       INTEGER PRIMARY KEY AUTOINCREMENT,
        name     TEXT NOT NULL,
        time     DATETIME NOT NULL,
        note     TEXT NOT NULL
    )
    ");
    try {
    $time = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO note (name,time,note) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['name'], $time, $_POST['note']]);
    echo '留言成功';
    } catch (PDOException $e) {
        echo '留言失败：' . $e->getMessage();
    }
