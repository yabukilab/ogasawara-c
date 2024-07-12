<?php
session_start();
require('db.php');

// MySQLデータベースに接続
$conn = new mysqli($dbServer, $dbUser, $dbPass, $dbName);

// 接続をチェック 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_id = isset($_POST['menu_id']) ? intval($_POST['menu_id']) : 0;
    $rate = isset($_POST['rate']) ? intval($_POST['rate']) : 0;
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0; // セッションからユーザーIDを取得

    // 入力値のチェック
    if ($menu_id > 0 && $rate >= 1 && $rate <= 5 && $user_id > 0) {
        // 既存の評価があるかチェック
        $stmt = $conn->prepare("SELECT rate_id FROM rate WHERE menu_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $menu_id, $user_id);
        $stmt->execute();
        $stmt->bind_result($rate_id);
        $stmt->fetch();
        $stmt->close();

        if ($rate_id) {
            // 既存の評価を更新
            $stmt = $conn->prepare("UPDATE rate SET rate = ? WHERE rate_id = ?");
            $stmt->bind_param("ii", $rate, $rate_id);
        } else {
            // 新しい評価を挿入
            $stmt = $conn->prepare("INSERT INTO rate (menu_id, user_id, rate) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $menu_id, $user_id, $rate);
        }

        // 評価を保存
        if ($stmt->execute()) {
            // 平均評価を計算して更新
            $stmt->close();

            $stmt = $conn->prepare("SELECT ROUND(AVG(rate), 1) as average_rate FROM rate WHERE menu_id = ?");
            $stmt->bind_param("i", $menu_id);
            $stmt->execute();
            $stmt->bind_result($average_rate);
            $stmt->fetch();
            $stmt->close();

            // menuテーブルの平均評価を更新
            $stmt = $conn->prepare("UPDATE menu SET average_rate = ? WHERE menu_id = ?");
            $stmt->bind_param("di", $average_rate, $menu_id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// メニュー一覧にリダイレクト
header("Location: menu.php");
exit;
?>
