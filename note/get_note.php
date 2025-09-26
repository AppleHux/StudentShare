<?php
header('Content-Type: application/json');

try {
    $dbFile = __DIR__ . '/../db/note.db';
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query('SELECT id ,name, time, note FROM note ORDER BY time DESC');
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['messages' => $messages]);
} catch (PDOException $e) {
    error_log('查询留言失败：' . $e->getMessage());
    echo json_encode(['error' => '查询留言失败，请稍后再试']);
}