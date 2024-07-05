<?php
session_start();
require('db.php');

// MySQLデータベースに接続
$conn = new mysqli($dbServer, $dbUser, $dbPass, $dbName);

// 接続をチェック
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// メニュー選択の処理
$sql_select_menu = "SELECT menu_id, menu_name FROM menu";
$result_select_menu = $conn->query($sql_select_menu);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['select_menu'])) {
        if (isset($_POST['menu_id'])) {
            $selected_menu_id = $_POST['menu_id'];
            if (!isset($_SESSION['selected_menu_ids'])) {
                $_SESSION['selected_menu_ids'] = [];
            }
            if (!in_array($selected_menu_id, $_SESSION['selected_menu_ids'])) {
                $_SESSION['selected_menu_ids'][] = $selected_menu_id; // セッションに選択されたメニューIDを追加
                echo "<script>alert('メニューが選択されました。'); window.location.href = window.location.href;</script>";
                exit();
            } else {
                echo "<script>alert('既に選択されています。');</script>";
            }
        } else {
            echo "<script>alert('メニューが選択されていません。');</script>";
        }
    } elseif (isset($_POST['deselect_menu'])) {
        unset($_SESSION['selected_menu_ids']); // 選択されたメニューのIDをセッションから削除
        echo "<script>alert('表示メニューの選択をリセットしました。'); window.location.href = window.location.href;</script>";
        exit();
    } elseif (isset($_POST['add_menu'])) {
        $menu_name = trim($_POST['menu_name']);
        $menu_img = $_FILES['menu_img']['tmp_name'];

        if (empty($menu_name) || empty($menu_img)) {
            echo "<script>alert('メニュー名と画像の両方を入力してください。');</script>";
        } else {
            $img_data = file_get_contents($menu_img);
            $stmt = $conn->prepare("SELECT menu_id FROM Menu WHERE menu_name = ?");
            $stmt->bind_param("s", $menu_name);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
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
    } elseif (isset($_POST['delete_menu'])) {
        $menu_id = $_POST['menu_id'];

        // 関連するRateテーブルのレコードを削除
        $stmt_rate_delete = $conn->prepare("DELETE FROM Rate WHERE menu_id = ?");
        $stmt_rate_delete->bind_param("i", $menu_id);
        $stmt_rate_delete->execute();
        $stmt_rate_delete->close();

        // メニューを削除
        $stmt = $conn->prepare("DELETE FROM menu WHERE menu_id = ?");
        $stmt->bind_param("i", $menu_id);
        $stmt->execute();
        echo "<script>alert('メニューが削除されました。'); window.location.href = window.location.href;</script>";
        exit();

        // 選択されたメニューから削除
        if (isset($_SESSION['selected_menu_ids']) && in_array($menu_id, $_SESSION['selected_menu_ids'])) {
            $_SESSION['selected_menu_ids'] = array_diff($_SESSION['selected_menu_ids'], array($menu_id));
        }

        $stmt->close();
    }
}
?>

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

    <h2>メニュー削除</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="delete_menu_id">削除するメニュー:</label>
        <select id="delete_menu_id" name="menu_id">
            <?php
            // メニュー選択クエリの結果を再度利用する
            if ($result_select_menu->num_rows > 0) {
                while ($row = $result_select_menu->fetch_assoc()) {
                    echo "<option value='" . $row['menu_id'] . "'>" . htmlspecialchars($row['menu_name'], ENT_QUOTES, 'UTF-8') . "</option>";
                }
            } else {
                echo "<option value=''>メニューがありません</option>";
            }
            ?>
        </select>
        <input type="submit" name="delete_menu" value="メニューを削除">
    </form>

    <h2>表示メニューの選択</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="select_menu_id">選択するメニュー:</label>
        <select id="select_menu_id" name="menu_id">
            <?php
            // メニュー選択クエリの結果を再度利用する
            if ($result_select_menu->num_rows > 0) {
                // クエリ結果を再度リセットしてループを繰り返す
                $result_select_menu->data_seek(0);
                while ($row = $result_select_menu->fetch_assoc()) {
                    echo "<option value='" . $row['menu_id'] . "'>" . htmlspecialchars($row['menu_name'], ENT_QUOTES, 'UTF-8') . "</option>";
                }
            } else {
                echo "<option value=''>メニューがありません</option>";
            }
            ?>
        </select>
        <input type="submit" name="select_menu" value="メニューを選択">
    </form>

    <h2>選択メニューの解除</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="submit" name="deselect_menu" value="選択メニューを解除">
    </form>
</body>
</html>

<?php
$conn->close();
?>
