<?php
session_start();
require('db.php');

$conn = new mysqli($dbServer, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

// メニューランキングの取得
$sql_ranking = "SELECT menu_name, average_rate FROM menuwithaveragerate ORDER BY average_rate DESC LIMIT 5";
$result_ranking = $conn->query($sql_ranking);

if ($result_ranking === false) {
    die("SQLエラー: " . $conn->error);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>メニュー一覧</title>
    <link href="menu.css" rel="stylesheet" />
</head>
<body>
    <h1>メニューランキング</h1>
    <table border="1">
        <tr>
            <th>順位</th>
            <th>メニュー名</th>
            <th>平均評価</th>
        </tr>
        <?php
        if ($result_ranking->num_rows > 0) {
            $rank = 1;
            while ($row = $result_ranking->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $rank . "</td>";
                echo "<td>" . htmlspecialchars($row['menu_name'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . displayStarRating($row['average_rate']) . " (" . htmlspecialchars($row['average_rate'], ENT_QUOTES, 'UTF-8') . ")</td>";
                echo "</tr>";
                $rank++;
            }
        } else {
            echo "<tr><td colspan='3'>ランキング情報がありません</td></tr>";
        }
        ?>
    </table>

    <h1>選択されたメニュー</h1>
    <div class="menu-container">
    <?php
    if (isset($_SESSION['selected_menu_ids']) && !empty($_SESSION['selected_menu_ids'])) {
        foreach ($_SESSION['selected_menu_ids'] as $selected_menu_id) {
            $sql_all_menus = "SELECT m.menu_id, m.menu_name, m.menu_img, 
                        COALESCE((SELECT COUNT(*) FROM rate WHERE menu_id = m.menu_id), 0) AS rating_count, 
                        COALESCE(ROUND(AVG(r.rate), 1), 0) AS average_rate
                  FROM menu m
                  LEFT JOIN Rate r ON m.menu_id = r.menu_id
                  WHERE m.menu_id = ?";
            $stmt = $conn->prepare($sql_all_menus);
            $stmt->bind_param("i", $selected_menu_id);
            $stmt->execute();
            $menu_result = $stmt->get_result();

            if ($menu_result->num_rows > 0) {
                while ($row = $menu_result->fetch_assoc()) {
                    // 空のメニューを表示しないようにする
                    if (empty($row['menu_name']) && empty($row['menu_img']) && $row['rating_count'] == 0 && $row['average_rate'] == 0) {
                        continue;
                    }
                    echo "<div class='menu-item'>";
                    echo "<a href='menu_rate.php?menu_id=" . htmlspecialchars($row['menu_id'], ENT_QUOTES, 'UTF-8') . "' class='menu-link'>";
                    echo "<h2>" . htmlspecialchars($row['menu_name'], ENT_QUOTES, 'UTF-8') . "</h2>";
                    if ($row['menu_img']) {
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($row['menu_img']) . '" alt="' . htmlspecialchars($row['menu_name'], ENT_QUOTES, 'UTF-8') . 'の画像" style="width:200px;height:200px;"/>';
                    } else {
                        echo "<p>画像がありません</p>";
                    }
                    echo "<p>評価数: " . htmlspecialchars($row['rating_count'], ENT_QUOTES, 'UTF-8') . "</p>";
                    echo "<p>平均評価: " . displayStarRating($row['average_rate']) . " (" . htmlspecialchars($row['average_rate'], ENT_QUOTES, 'UTF-8') . ")</p>";
                    echo "</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>表示するメニューがありません。</p>";
            }
            $stmt->close();
        }
    } else {
        echo "<p>表示するメニューがありません。</p>";
    }
    ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
