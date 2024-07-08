<?php
session_start();
require('db.php');

// ログインフォームが送信された場合の処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST["user_name"];
    $user_pass = $_POST["user_pass"];

    // 学籍番号の桁数を確認
    if (strlen($user_name) !== 7) {
        echo "7桁の学籍番号を入力してください";
    } elseif (!preg_match('/^[a-zA-Z0-9]{4,16}$/', $user_pass)) {
        echo "パスワードは4～16桁の英数字であるか確認してください";
    } else {
        // SQL インジェクション対策としてプリペアドステートメントを使用
        $stmt = $db->prepare("SELECT user_id, user_name, user_pass FROM users WHERE user_name = ?");
        $stmt->execute([$user_name]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // パスワードの比較
            if (password_verify($user_pass, $result["user_pass"])) {
                // ログイン成功時の処理
                $_SESSION["user_id"] = $result["user_id"];  // ユーザーIDをセッションに保存
                $_SESSION["user_name"] = $result["user_name"];  // ユーザー名もセッションに保存
                header("Location: menu.php");
                exit(); // リダイレクト後にスクリプトの実行を終了
            } else {
                // パスワードが一致しない場合
                echo "パスワードが一致しません";
            }
        } else {
            // ユーザーが見つからない場合
            echo "ユーザーが見つかりません";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ログイン画面</title>
    <link href="menu.css" rel="stylesheet" />
</head>
<body>
    <h1>ログイン</h1>
    <div class="form-container">
        <form action="" method="POST">
        <div class="form">
            <label for="user_name">学籍番号:</label>
            <input type="text" id="user_name" name="user_name" required>
        </div>
        <div class="form">
            <label for="user_pass">パスワード:</label>
            <input type="password" id="user_pass" name="user_pass" required>
        </div>
    </div>
        <br>
        <input type="submit" value="ログイン">
    </form>

    <p>未登録の方はこちら</p>
    <a href="index.php">新規登録ページ</a>
</body>
</html>
