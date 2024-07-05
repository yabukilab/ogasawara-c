<!DOCTYPE html>
<html>
<head>
    <title>メニュー管理</title>
    <link href="menu.css" rel="stylesheet" />
</head>
<body>
    <h1>メニュー管理</h1>

    <h2>メニュー追加</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="add_menu_name">メニュー名:</label>
        <input type="text" id="add_menu_name" name="menu_name" required>
        <label for="add_menu_img">画像:</label>
        <input type="file" id="add_menu_img" name="menu_img" accept="image/*" required>
        <input type="submit" name="add_menu" value="メニューを追加">
    </form>

    <?php
    session_start();
    require('db.php');

    $conn = new mysqli($dbServer, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_menu'])) {
        $menu_name = trim($_POST['menu_name']);
        $menu_img = $_FILES['menu_img']['tmp_name'];

        if (empty($menu_name) || empty($menu_img)) {
            echo "<script>alert('メニュー名と画像の両方を入力してください。');</script>";
        } else {
            // 画像データの取得とバイナリエンコーディング
            $img_data = file_get_contents($menu_img);

            // メニュー名の重複チェック
            $stmt = $conn->prepare("SELECT menu_id FROM Menu WHERE menu_name = ?");
            $stmt->bind_param("s", $menu_name);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
                // メニューをデータベースに追加
                $stmt = $conn->prepare("INSERT INTO Menu (menu_name, menu_img) VALUES (?, ?)");
                $stmt->bind_param("ss", $menu_name, $img_data);
                $stmt->send_long_data(1, $img_data);
                $stmt->execute();
                echo "<script>alert('メニューが追加されました。'); window.location.href = window.location.href;</script>";
                exit();
            } else {
                echo "<script>alert('既に同じ名前のメニューが存在します。');</script>";
            }

            $stmt->close();
        }
    }

    // MySQL接続を閉じる
    $conn->close();
    ?>
</body>
</html>
