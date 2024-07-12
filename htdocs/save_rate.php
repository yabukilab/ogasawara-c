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

    // デバッグ用コード
    echo "menu_id: " . $menu_id . "<br>";
    echo "rate: " . $rate . "<br>";
    echo "user_id: " . $user_id . "<br>";

    // テーブルの存在確認
    $result = $conn->query("SHOW TABLES LIKE 'menu'");
    if ($result->num_rows == 0) {
        die("menuテーブルが存在しません。");
    }
    $result = $conn->query("SHOW TABLES LIKE 'rate'");
    if ($result->num_rows == 0) {
        die("rateテーブルが存在しません。");
    }
    $result = $conn->query("SHOW TABLES LIKE 'users'");
    if ($result->num_rows == 0) {
        die("usersテーブルが存在しません。");
    }

    // menuテーブルの内容をデバッグ出力
    $result = $conn->query("SELECT * FROM menu");
    echo "<br>menuテーブルの内容:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "menu_id: " . $row['menu_id'] . ", menu_name: " . $row['menu_name'] . "<br>";
    }

    // menu_idがmenuテーブルに存在するかチェック
    $stmt = $conn->prepare("SELECT menu_id FROM menu WHERE menu_id = ?");
    $stmt->bind_param("i", $menu_id);
    $stmt->execute();
    $stmt->bind_result($exists_menu_id);
    $stmt->fetch();
    $stmt->close();
    if (!$exists_menu_id) {
        die("menu_idがmenuテーブルに存在しません。");
    }

    // user_idがusersテーブルに存在するかチェック
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($exists_user_id);
    $stmt->fetch();
    $stmt->close();
    if (!$exists_user_id) {
        die("user_idがusersテーブルに存在しません。");
    }

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
