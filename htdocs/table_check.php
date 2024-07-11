<?php
session_start();
require('db.php');

// MySQLデータベースに接続
$conn = new mysqli($dbServer, $dbUser, $dbPass, $dbName);

// 接続をチェック
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// テーブルの存在を確認
$sql = "SHOW TABLES LIKE 'rate'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Table 'rate' exists.<br/>";

    // カラム名を取得するためのクエリ
    $sql = "SHOW COLUMNS FROM `rate`";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 各カラム名を出力
        while ($row = $result->fetch_assoc()) {
            echo $row['Field'] . "<br/>";
        }
    } else {
        echo "No columns  found.";
    }
} else {
    echo "Table 'rate' does not exist.";
}

// 接続を閉じる
$conn->close();
?>
