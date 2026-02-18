<?php
header('Content-Type: application/json; charset=utf-8'); 

    // 连接数据库
    $db_path = __DIR__ . '/../db/main.db';
    try {
        $db = new PDO('sqlite:' . $db_path);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("数据库连接失败：" . $e->getMessage());
    }

    // 获取留言内容与其他信息
    try {
        $stmt = $db->query('SELECT id , time, content, user_id FROM notes ORDER BY time DESC');
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('查询留言失败：' . $e->getMessage());
    }


    // 获取并添加昵称
    if (!empty($messages)) {
        // 提取所有留言的用户ID，去重（避免重复查询）
        $userIds = array_column($messages, 'user_id'); // 注意：这里的user_id要和note表中的用户ID字段名一致
        $userIds = array_unique($userIds);
        $userIds = array_filter($userIds); // 过滤空值

        if (!empty($userIds)) {
            try {
                // 构造参数化查询，批量获取用户名
                $placeholders = rtrim(str_repeat('?,', count($userIds)), ','); // 生成多个?占位符
                $stmt = $db->prepare("SELECT id, username FROM users WHERE id IN ($placeholders)");
                $stmt->execute($userIds);
                $userList = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // 以用户ID为键，昵称为值的数组
            } catch (PDOException $e) {
                error_log('查询用户名失败：' . $e->getMessage());
                $userList = [];
            }

            // 第三步：为每条留言补充用户名
            foreach ($messages as &$message) {
                $userId = $message['user_id'];
                // 匹配用户名，若未找到则显示默认值（如"未知用户"）
                $message['username'] = $userList[$userId] ?? '未知用户';
            }
            unset($message); // 释放引用变量
        }
    }

    // 返回
    echo json_encode(['messages' => $messages]);