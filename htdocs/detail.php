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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="mobile.css" media="screen and (max-width: 768px)">
</head>
<body>
  <div id="detail-container"> <?php if (!empty($item['photo'])): ?>
    <?php $base64 = base64_encode($item['photo']); ?>
    <img src="data:image/png;base64,<?= $base64 ?>" alt="写真"><br>
  <?php else: ?>
    <p>画像なし</p>
  <?php endif; ?>

  <p><strong>キーワード：</strong><?= htmlspecialchars($item['keyword']) ?></p>
  <p><strong>見つけた場所：</strong><?= htmlspecialchars($item['found_place']) ?></p>
  <p><strong>現在の場所：</strong><?= htmlspecialchars($item['current_location']) ?></p>
  <p><strong>コメント：</strong><?= htmlspecialchars($item['comment'] ?: '（なし）') ?></p>

  <form action="mark_received.php" method="get">
    <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">
    <button class="btn btn-green" type="button" onclick="window.history.back()">戻る</button> <button class="btn btn-red" type="submit">取りに行く</button> </form>
  </div> </body>

</html>