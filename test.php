<?php
$db = new SQLite3(__DIR__ . '/users.db');
$rows = $db->query("SELECT id,name,email FROM users");
echo "<pre>";
while ($row = $rows->fetchArray(SQLITE3_ASSOC)) {
    print_r($row);
}
echo "</pre>";
?>
