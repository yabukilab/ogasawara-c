<?php
require 'db.php';

// 検索キーワード取得
$searchKeyword = isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '';

// クエリ準備（受け取ったものは除外）
if ($searchKeyword !== '') {
    $stmt = $pdo->prepare("SELECT * FROM items WHERE keyword = ? AND is_received = 0 ORDER BY id DESC");
    $stmt->execute([$searchKeyword]);
} else {
    $stmt = $pdo->query("SELECT * FROM items WHERE is_received = 0 ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>落し物検索</title>
  <style>
    body { font-family: sans-serif; padding: 30px; background-color: #f7f7f7; }
    h2 { text-align: center; }
    .item {
      background: #fff;
      padding: 15px;
      margin: 15px auto;
      max-width: 600px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .item img {
      width: 150px;
      height: auto;
      margin-bottom: 10px;
    }
    .btn {
      padding: 5px 15px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      margin-top: 10px;
    }
    form {
      text-align: center;
      margin-bottom: 20px;
    }
    select {
      padding: 8px;
      font-size: 16px;
    }
  </style>
</head>
<body>

<h2>落し物検索</h2>

<!-- 検索フォーム -->
<form method="POST" action="search.php">
  <label>
    キーワードで検索：
    <select name="search_keyword">
  <option value="">すべて表示</option>
  <?php
    require 'keywords.php';
    foreach ($keywords as $keyword) {
      $selected = ($searchKeyword ?? '') === $keyword ? 'selected' : '';
      echo "<option value=\"{$keyword}\" {$selected}>{$keyword}</option>";
    }
  ?>
</select>
    <button class="btn" type="submit">検索</button>
  </label>
</form>

<!-- 検索結果 -->
<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
  <div class="item">
    <?php if (!empty($row['photo'])) : ?>
  <?php $mime = finfo_buffer(finfo_open(), $row['photo'], FILEINFO_MIME_TYPE); ?>
  <?php $base64 = base64_encode($row['photo']); ?>
  <img src="data:<?= $mime ?>;base64,<?= $base64 ?>" alt="画像">
<?php else: ?>
  <p>画像なし</p>
<?php endif; ?>
    <p><strong>キーワード：</strong><?= htmlspecialchars($row['keyword']) ?></p>
    <p><strong>現在の場所：</strong><?= htmlspecialchars($row['current_location']) ?></p>
    <form action="detail.php" method="GET">
      <input type="hidden" name="id" value="<?= $row['id'] ?>">
      <button class="btn" type="submit">詳細</button>
    </form>
  </div>
<?php endwhile; ?>

</body>
</html>