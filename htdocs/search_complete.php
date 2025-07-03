<?php // GETパラメータからキーワードと場所を取得（なければ空文字）
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>検索完了</title>
  <style>
    body {
      font-family: sans-serif;
      text-align: center;
      padding-top: 100px;
    }
    h2 {
      margin-bottom: 20px;
    }
    p {
      font-size: 18px;
      margin-bottom: 30px;
    }
    .btn {
      background-color: #4CAF50;
      color: white;
      font-size: 16px;
      padding: 12px 24px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <h2>検索完了です</h2>

  <p>
    「<?= htmlspecialchars($keyword) ?>」は「<?= htmlspecialchars($location) ?>」にあります。<br>
    ＊この画面は今後表示されないためご注意ください。
  </p>

  <a href="index.php"><button class="btn">戻る</button></a>

</body>
</html>