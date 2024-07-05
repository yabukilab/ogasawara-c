<?php
session_start();

$servername = "localhost";
$username = "db_food";
$password = "YES";
$dbname = "mydb";

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST["user_name"];
    $user_pass = $_POST["user_pass"];

    // SQL インジェクション対策としてプリペアドステートメントを使用
    $stmt = $conn->prepare("SELECT user_id, user_name, user_pass FROM Users WHERE user_name = ?");
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($user_pass, $row["user_pass"])) {
            // ログイン成功時の処理
            $_SESSION["user_id"] = $row["user_id"];  // ユーザーIDをセッションに保存
            $_SESSION["user_name"] = $row["user_name"];  // ユーザー名もセッションに保存
            $stmt->close();
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

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ログイン画面</title>
    <link href="menu.css" rel="stylesheet" />
</head>
<body>
    <h2>ログイン</h2>
    <form action="" method="POST">
        <label for="user_name">学籍番号:</label>
        <input type="text" id="user_name" name="user_name" required>
        <br>
        <label for="user_pass">パスワード:</label>
        <input type="password" id="user_pass" name="user_pass" required>
        <br>
        <input type="submit" value="ログイン">
    </form>

    <p>未登録の方はこちら</p>
    <a href="register.php">新規登録ページ</a>
</body>
</html>