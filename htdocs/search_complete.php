<?php // GETパラメータからキーワードと場所を取得（なければ空文字）
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>検索完了</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
   <link rel="stylesheet" href="style.css"> 
   <link rel="stylesheet" href="mobile.css" media="screen and (max-width: 768px)">
</head>
<body>
  <div class="complete-container"> <h2>検索完了です</h2>

    <p>
      「<?= htmlspecialchars($keyword) ?>」は「<?= htmlspecialchars($location) ?>」にあります。<br>
      ＊この画面は今後表示されないためご注意ください。
    </p>

    <a href="index.php"><button class="btn">戻る</button></a>
  </div>
</body>
</html>