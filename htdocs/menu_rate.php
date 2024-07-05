<?php
session_start();
require('db.php');

// MySQLデータベースに接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続をチェック
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$menu_id = $_GET['menu_id'];
$display_type = isset($_GET['display_type']) ? $_GET['display_type'] : 'overall';

// メニュー名と画像を取得
$stmt = $conn->prepare("SELECT menu_name, menu_img FROM Menu WHERE menu_id = ?");
$stmt->bind_param("i", $menu_id);
$stmt->execute();
$stmt->bind_result($menu_name, $menu_img);
$stmt->fetch();
$stmt->close();

// 星形評価を表示する関数
function displayStarRating($averageRate) {
    $stars = "";
    $fullStars = floor($averageRate);
    $halfStar = ($averageRate - $fullStars) >= 0.5;

    // Full stars
    for ($i = 0; $i < $fullStars; $i++) {
        $stars .= "★";
    }

    // Half star if applicable
    if ($halfStar) {
        $stars .= "☆";
    }

    return $stars;
}

// 平均評価を取得する関数
function getAverageRate($conn, $menu_id, $gender = null) {
    if ($gender) {
        $stmt = $conn->prepare("
            SELECT ROUND(AVG(r.rate), 1) as average_rate
            FROM Rate r
            JOIN Users u ON r.user_id = u.user_id
            WHERE r.menu_id = ? AND u.user_gender = ?
        ");
        $stmt->bind_param("is", $menu_id, $gender);
    } else {
        $stmt = $conn->prepare("SELECT ROUND(AVG(rate), 1) as average_rate FROM Rate WHERE menu_id = ?");
        $stmt->bind_param("i", $menu_id);
    }

    $stmt->execute();
    $stmt->bind_result($average_rate);
    $stmt->fetch();
    $stmt->close();
    return $average_rate;
}

// 選択された評価タイプに基づいて平均評価を取得
if ($display_type == 'male') {
    $average_rate = getAverageRate($conn, $menu_id, 'male');
} elseif ($display_type == 'female') {
    $average_rate = getAverageRate($conn, $menu_id, 'female');
} else {
    $average_rate = getAverageRate($conn, $menu_id);
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($menu_name, ENT_QUOTES, 'UTF-8'); ?></title>
    <link href="menu.css" rel="stylesheet" />
</head>
<body>
    <h1><?php echo htmlspecialchars($menu_name, ENT_QUOTES, 'UTF-8'); ?></h1>
    <?php
    if (!empty($menu_img)) {
        echo "<img src='data:image/jpeg;base64," . base64_encode($menu_img) . "' alt='" . htmlspecialchars($menu_name, ENT_QUOTES, 'UTF-8') . "' class='menu_rate_img'><br>";
    } else {
        echo "画像がありません<br>";
    }
    ?>
    <h2>平均評価</h2>
    <form method="get">
        <input type="hidden" name="menu_id" value="<?php echo htmlspecialchars($menu_id, ENT_QUOTES, 'UTF-8'); ?>">
        <label for="display_type">評価タイプを選択:</label>
        <select id="display_type" name="display_type" onchange="this.form.submit()">
            <option value="overall" <?php if ($display_type == 'overall') echo 'selected'; ?>>総合</option>
            <option value="male" <?php if ($display_type == 'male') echo 'selected'; ?>>男性</option>
            <option value="female" <?php if ($display_type == 'female') echo 'selected'; ?>>女性</option>
        </select>
    </form>
    <p>
        <?php
        if ($display_type == 'male') {
            echo "男性の平均評価: ";
        } elseif ($display_type == 'female') {
            echo "女性の平均評価: ";
        } else {
            echo "総合平均評価: ";
        }
        if ($average_rate) {
            echo displayStarRating($average_rate) . " (" . $average_rate . ")";
        } else {
            echo '評価がありません';
        }
        ?>
    </p>
    <form action="save_rate.php" method="post">
        <input type="hidden" name="menu_id" value="<?php echo htmlspecialchars($menu_id, ENT_QUOTES, 'UTF-8'); ?>">
        <label for="rate">評価 (1-5):</label>
        <input type="number" id="rate" name="rate" min="1" max="5" required><br>
        <input type="submit" value="評価を送信">
    </form>
    <div class="back-button">
    <form action="menu.php" method="get">
        <input type="submit" value="メニュー一覧に戻る">
    </form>
    </div>
</body>
</html>
