<?php
require 'db.php';

if (!isset($_GET['id'])) {
  header("Location: search.php");
  exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
  echo "データが見つかりませんでした。";
  exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>落とし物詳細</title>
  <style>
    body {
      font-family: sans-serif;
      text-align: center;
      padding-top: 50px;
    }
    img {
      max-width: 200px;
      margin-bottom: 20px;
    }
    .btn {
      padding: 10px 20px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      margin: 10px;
      cursor: pointer;
    }
    .green {
      background-color: #4CAF50;
      color: white;
    }
    .red {
      background-color: #f44336;
      color: white;
    }
  </style>
</head>
<body>

  <img src="<?= htmlspecialchars($item['photo']) ?>" alt="写真"><br>
  <strong>キーワード:</strong> <?= htmlspecialchars($item['keyword']) ?><br>
  <strong>見つけた場所:</strong> <?= htmlspecialchars($item['found_place']) ?><br>
  <strong>現在の場所:</strong> <?= htmlspecialchars($item['current_location']) ?><br>
  <strong>コメント:</strong> <?= htmlspecialchars($item['comment']) ?: "(なし)" ?><br><br>

  <form action="search_complete.php" method="get">
    <input type="hidden" name="keyword" value="<?= htmlspecialchars($item['keyword']) ?>">
    <input type="hidden" name="location" value="<?= htmlspecialchars($item['current_location']) ?>">
    <button class="btn green" type="button" onclick="window.history.back()">戻る</button>
    <button class="btn red" type="submit">取りに行く</button>
  </form>

</body>
</html>