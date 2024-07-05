<?php
// db.php を読み込む
require('db.php');

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
        $check_sql = "SELECT * FROM users WHERE user_name = :user_name";
        $stmt = $db->prepare($check_sql);
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "この学籍番号はすでに登録されています";
        } else {
            // パスワードをハッシュ化
            $hashed_password = password_hash($user_pass, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (user_name, user_pass, user_gender) VALUES (:user_name, :user_pass, :user_gender)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
            $stmt->bindParam(':user_pass', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':user_gender', $user_gender, PDO::PARAM_STR);

            try {
                $stmt->execute();
                echo "登録が完了しました";
                // 登録後にログインページにリダイレクト
                header("Location: login.php");
                exit();
            } catch (PDOException $e) {
                echo "Error: " . h($e->getMessage());
            }
        }
    }
}
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
    <a href="login.php">ログインページ</a>
</body>
</html>
