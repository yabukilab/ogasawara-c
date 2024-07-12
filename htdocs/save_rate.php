<?php
session_start();
require('db.php');

// MySQLデータベースに接続
$conn = new mysqli($dbServer, $dbUser, $dbPass, $dbName);

// 接続をチェック
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// セッションからユーザーIDを取得
$user_id = $_SESSION['user_id'];
$menu_id = $_POST['menu_id'];
$rate = $_POST['rate'];

// 評価を保存または更新
$stmt = $conn->prepare("INSERT INTO rate (user_id, menu_id, rate) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE rate = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("iiii", $user_id, $menu_id, $rate, $rate);
$stmt->execute();
if ($stmt->error) {
    die("Execute failed: " . $stmt->error);
}
$stmt->close();

// 平均評価を更新するためにmenuテーブルを更新する
$stmt_update_average = $conn->prepare("UPDATE menu SET average_rate = (SELECT ROUND(AVG(rate), 1) FROM rate WHERE menu_id = ?) WHERE menu_id = ?");
if (!$stmt_update_average) {
    die("Prepare failed: " . $conn->error);
}
$stmt_update_average->bind_param("ii", $menu_id, $menu_id);
$stmt_update_average->execute();
if ($stmt_update_average->error) {
    die("Execute failed: " . $stmt_update_average->error);
}
$stmt_update_average->close();

$conn->close();

// 評価が保存された後にmenu.phpにリダイレクトする
header("Location: menu.php");
exit();
?>