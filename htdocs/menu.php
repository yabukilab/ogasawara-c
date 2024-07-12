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

// 星形評価を表示する関数
function displayStarRating($averageRate) {
    $fullStars = floor($averageRate);
    $halfStar = ($averageRate - $fullStars) >= 0.5;

    $stars = "";

    // Full stars
    for ($i = 0; $i < $fullStars; $i++) {
        $stars .= "<span class='star full-star'>★</span>";
    }

    // Half star if applicable
    if ($halfStar) {
        $stars .= "<span class='star half-star'>★</span>";
    }

    // Empty stars
    for ($i = $fullStars + $halfStar; $i < 5; $i++) {
        $stars .= "<span class='star empty-star'>★</span>";
    }

    return $stars;
}

// メニューランキングの取得
$sql_ranking = "SELECT sm.menu_id, m.menu_name, m.menu_img,
                    COALESCE((SELECT COUNT(*) FROM rate WHERE menu_id = sm.menu_id), 0) AS rating_count,
                    COALESCE(ROUND(AVG(r.rate), 1), 0) AS average_rate
                FROM selected_menus sm
                LEFT JOIN menu m ON sm.menu_id = m.menu_id
                LEFT JOIN rate r ON sm.menu_id = r.menu_id
                GROUP BY sm.menu_id, m.menu_name, m.menu_img
                ORDER BY average_rate DESC
                LIMIT 5";
$result_ranking = $conn->query($sql_ranking);

// 選択されたメニューの取得
$sql_selected_menus = "SELECT sm.menu_id, m.menu_name, m.menu_img,
                            COALESCE((SELECT COUNT(*) FROM rate WHERE menu_id = sm.menu_id), 0) AS rating_count,
                            COALESCE(ROUND(AVG(r.rate), 1), 0) AS average_rate
                        FROM selected_menus sm
                        LEFT JOIN menu m ON sm.menu_id = m.menu_id
                        LEFT JOIN rate r ON sm.menu_id = r.menu_id
                        GROUP BY sm.menu_id, m.menu_name, m.menu_img";
$result_selected_menus = $conn->query($sql_selected_menus);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>メニュー一覧</title>
    <link href="menu.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
    <img src="menu.png" alt="pic1" class="foodmenus">
    <div>
    <h1>本日のメニューランキング</h1>
    <table>
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
    </div>
    </div>

    <h1>本日のメニュー</h1>
    <div class="menu-container">
    <?php
    if ($result_selected_menus->num_rows > 0) {
        while ($row = $result_selected_menus->fetch_assoc()) {
            echo "<div class='menu-item'>";
            echo "<a href='menu_rate.php?menu_id=" . htmlspecialchars($row['menu_id'], ENT_QUOTES, 'UTF-8') . "' class='menu-link'>";
            echo "<h2>" . htmlspecialchars($row['menu_name'], ENT_QUOTES, 'UTF-8') . "</h2>";
            if ($row['menu_img']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['menu_img']) . '" alt="' . htmlspecialchars($row['menu_name'], ENT_QUOTES, 'UTF-8') . 'の画像" class="menu-image" />';
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
    ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
