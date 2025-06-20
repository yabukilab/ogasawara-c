<?php
require 'db.php';

// キーワードで絞り込み（GETパラメータ）
$filter = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// キーワード一覧をDBから取得（重複を除く）
$keywordStmt = $pdo->query("SELECT DISTINCT keyword FROM items");
$keywords = $keywordStmt->fetchAll(PDO::FETCH_COLUMN);

// データ取得
if ($filter) {
  $stmt = $pdo->prepare("SELECT * FROM items WHERE keyword = ? ORDER BY created_at DESC");
  $stmt->execute([$filter]);
} else {
  $stmt = $pdo->query("SELECT * FROM items ORDER BY created_at DESC");
}
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>落とし物検索</title>
  <style>
    body {
      font-family: sans-serif;
      padding: 20px;
      text-align: center;
    }
    img {
      max-width: 150px;
      height: auto;
      display: block;
      margin: 10px auto;
    }
    .item-box {
      border: 1px solid #ccc;
      padding: 10px;
      margin: 10px auto;
      width: 300px;
      border-radius: 5px;
    }
    .btn {
      padding: 8px 16px;
      font-size: 14px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    select {
      padding: 5px;
      font-size: 16px;
    }
  </style>
</head>
<body>

  <h2>落とし物を検索</h2>

  <form method="get" action="search.php">
    <label>キーワードで絞り込み:
      <select name="keyword" onchange="this.form.submit()">
        <option value="">全て表示</option>
        <?php foreach ($keywords as $kw): ?>
          <option value="<?= htmlspecialchars($kw) ?>" <?= $kw === $filter ? 'selected' : '' ?>><?= htmlspecialchars($kw) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </form>

  <hr>

  <?php if (count($items) === 0): ?>
    <p>見つかりませんでした。</p>
  <?php else: ?>
    <?php foreach ($items as $item): ?>
      <div class="item-box">
        <img src="<?= htmlspecialchars($item['photo']) ?>" alt="画像">
        <strong>キーワード:</strong> <?= htmlspecialchars($item['keyword']) ?><br>
        <strong>現在の場所:</strong> <?= htmlspecialchars($item['current_location']) ?><br>
        <form action="detail.php" method="get">
          <input type="hidden" name="id" value="<?= $item['id'] ?>">
          <button class="btn" type="submit">詳細</button>
        </form>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

</body>
</html>