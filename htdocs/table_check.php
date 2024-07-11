<?php
session_start();
require('db.php');

// MySQLデータベースに接続
$conn = new mysqli($dbServer, $dbUser, $dbPass, $dbName);

// 接続をチェック
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM menu ORDER BY menu_name";
$stmt = $conn->prepare($sql);
$stmt->execute();

// 結果の取得
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    print_r($row);
    echo("<br/>");
}

// ステートメントを閉じる
$stmt->close();
// 接続を閉じる
$conn->close();
?>
