<?php
require('db.php')

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST["user_name"];
    $user_pass = $_POST["user_pass"];
    $confirm_password = $_POST["confirm_password"];
    $user_gender = $_POST["user_gender"];

    // パスワードと確認パスワードが一致するかを確認
    if ($user_pass !== $confirm_password) {
        echo "パスワードが間違っています．もう一度入力し直してください．";
    } else {
        // 学籍番号が既に存在するか確認
        $check_sql = "SELECT * FROM Users WHERE user_name = '$user_name'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            echo "この学籍番号はすでに登録されています";
        } else {
            // パスワードをハッシュ化
            $hashed_password = password_hash($user_pass, PASSWORD_DEFAULT);

            $sql = "INSERT INTO Users (user_name, user_pass, user_gender) VALUES ('$user_name', '$hashed_password', '$user_gender')";

            if ($conn->query($sql) === TRUE) {
                echo "登録が完了しました";
                // 登録後にログインページにリダイレクト
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>新規登録画面</title>
    <link href="menu.css" rel="stylesheet" />
</head>
<body>
    <h2>新規登録</h2>
    <form action="" method="POST">
        <label for="user_name">学籍番号:</label>
        <input type="text" id="user_name" name="user_name" required>
        <br>
        <label for="user_pass">パスワード:</label>
        <input type="password" id="user_pass" name="user_pass" required>
        <br>
        <label for="confirm_password">パスワード再入力:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <br>
        <label for="user_gender">性別:</label>
        <input type="radio" id="male" name="user_gender" value="male" checked>
        <label for="male">男性</label>
        <input type="radio" id="female" name="user_gender" value="female">
        <label for="female">女性</label>
        <input type="radio" id="none" name="user_gender" value="none">
        <label for="none">未選択</label>
        <br>
        <input type="submit" value="登録">
    </form>
    
    <p>登録済みの方はこちら</p>
    <a href="index.php">ログインページ</a>
</body>
</html>