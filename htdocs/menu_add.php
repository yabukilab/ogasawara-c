<?php
session_start();
error_reporting(E_ALL); // すべてのエラーを報告する
ini_set('display_errors', 1); // エラーを画面に表示する

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
                
                // selected_menusテーブルに挿入
                $stmt = $conn->prepare("INSERT INTO `selected_menus` (menu_id) VALUES (?)");
                $stmt->bind_param("i", $selected_menu_id);
                $stmt->execute();
                $stmt->close();

                echo "<script>alert('メニューが選択されました。'); window.location.href = window.location.href;</script>";
                exit();
            } else {
                echo "<script>alert('既に選択されています。');</script>";
            }
        } else {
            echo "<script>alert('メニューが選択されていません。');</script>";
        }
    } elseif (isset($_POST['deselect_menu'])) {
        // selected_menusテーブルからすべてのレコードを削除
        $stmt_delete_selected_menus = $conn->prepare("DELETE FROM `selected_menus`");
        $stmt_delete_selected_menus->execute();
        $stmt_delete_selected_menus->close();

        unset($_SESSION['selected_menu_ids']); // 選択されたメニューのIDをセッションから削除
        echo "<script>alert('表示メニューの選択をリセットしました。'); window.location.href = window.location.href;</script>";
        exit();
    } elseif (isset($_POST['add_menu'])) {
        $menu_name = trim($_POST['menu_name']);
        $menu_img = $_FILES['menu_img'];

        if (empty($menu_name) || empty($menu_img['tmp_name'])) {
            echo "<script>alert('メニュー名と画像の両方を入力してください。');</script>";
        } else {
            if ($menu_img['error'] === UPLOAD_ERR_OK) {
                $img_data = file_get_contents($menu_img['tmp_name']);
                $stmt = $conn->prepare("SELECT menu_id FROM menu WHERE menu_name = ?");
                $stmt->bind_param("s", $menu_name);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows == 0) {
                    $stmt = $conn->prepare("INSERT INTO menu (menu_name, menu_img) VALUES (?, ?)");
                    $stmt->bind_param("ss", $menu_name, $img_data);
                    $stmt->send_long_data(1, $img_data);
                    $stmt->execute();
                    echo "<script>alert('メニューが追加されました。'); window.location.href = window.location.href;</script>";
                    exit();
                } else {
                    echo "<script>alert('既に同じ名前のメニューが存在します。');</script>";
                }

                $stmt->close();
            } else {
                echo "<script>alert('画像のアップロードに失敗しました。');</script>";
            }
        }
    } elseif (isset($_POST['delete_menu'])) {
        $menu_id = $_POST['menu_id'];

        // 関連するRateテーブルのレコードを削除
        $stmt_rate_delete = $conn->prepare("DELETE FROM rate WHERE menu_id = ?");
        $stmt_rate_delete->bind_param("i", $menu_id);
        $stmt_rate_delete->execute();
        $stmt_rate_delete->close();

        // メニューを削除
        $stmt = $conn->prepare("DELETE FROM menu WHERE menu_id = ?");
        $stmt->bind_param("i", $menu_id);
        $stmt->execute();

        // selected_menusテーブルから削除
        $stmt_selected_delete = $conn->prepare("DELETE FROM `selected_menus` WHERE menu_id = ?");
        $stmt_selected_delete->bind_param("i", $menu_id);
        $stmt_selected_delete->execute();
        $stmt_selected_delete->close();

        // 選択されたメニューから削除
        if (isset($_SESSION['selected_menu_ids']) && in_array($menu_id, $_SESSION['selected_menu_ids'])) {
            $_SESSION['selected_menu_ids'] = array_diff($_SESSION['selected_menu_ids'], array($menu_id));
        }

        echo "<script>alert('メニューが削除されました。'); window.location.href = window.location.href;</script>";
        exit();

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
        <div class="inp-button">
            <input type="submit" name="add_menu" value="メニューを追加">
        </div>
    </form>

    <h2>メニュー削除</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="delete_menu_id">削除するメニュー:</label>
        <select id="delete_menu_id" name="menu_id">
            <?php
            // メニュー選択クエリの結果を再度利用する
            $result_select_menu->data_seek(0); // 結果セットのポインタを最初に戻す
            if ($result_select_menu->num_rows > 0) {
                while ($row = $result_select_menu->fetch_assoc()) {
                    echo "<option value='" . $row['menu_id'] . "'>" . $row['menu_name'] . "</option>";
                }
            }
            ?>
        </select>
        <div class="inp-button">
            <input type="submit" name="delete_menu" value="メニューを削除">
        </div>
    </form>

    <h2>メニュー選択</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="select_menu_id">選択するメニュー:</label>
        <select id="select_menu_id" name="menu_id">
            <?php
            // メニュー選択クエリの結果を再度利用する
            $result_select_menu->data_seek(0); // 結果セットのポインタを最初に戻す
            if ($result_select_menu->num_rows > 0) {
                while ($row = $result_select_menu->fetch_assoc()) {
                    echo "<option value='" . $row['menu_id'] . "'>" . $row['menu_name'] . "</option>";
                }
            }
            ?>
        </select>
        <div class="inp-button">
            <input type="submit" name="select_menu" value="メニューを選択">
        </div>
    </form>

    <h2>メニュー選択リセット</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="inp-button">
            <input type="submit" name="deselect_menu" value="メニュー選択をリセット">
        </div>
    </form>
</body>
</html>
