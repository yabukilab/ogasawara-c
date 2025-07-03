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
      padding: 50px;
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

  <!-- 画像表示 -->
  <?php if (!empty($item['photo'])): ?>
    <?php $base64 = base64_encode($item['photo']); ?>
    <img src="data:image/png;base64,<?= $base64 ?>" alt="写真"><br>
  <?php else: ?>
    <p>画像なし</p>
  <?php endif; ?>

  <!-- 詳細情報 -->
  <p><strong>キーワード：</strong><?= htmlspecialchars($item['keyword']) ?></p>
  <p><strong>見つけた場所：</strong><?= htmlspecialchars($item['found_place']) ?></p>
  <p><strong>現在の場所：</strong><?= htmlspecialchars($item['current_location']) ?></p>
  <p><strong>コメント：</strong><?= htmlspecialchars($item['comment'] ?: '（なし）') ?></p>

  <!-- ボタン -->
  <form action="mark_received.php" method="get">
    <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">
    <button class="btn green" type="button" onclick="window.history.back()">戻る</button>
    <button class="btn red" type="submit">取りに行く</button>
  </form>

</body>
</html>