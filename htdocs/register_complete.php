<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyword = $_POST['keyword'];
    $currentLocation = $_POST['current_location'];
    $foundPlace = $_POST['found_place'];
    $comment = $_POST['comment'];

    file_put_contents('log.txt', print_r($_FILES, true));

    // 画像をバイナリで読み込む
    $photoData = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photoData = file_get_contents($_FILES['photo']['tmp_name']);
    }

    $stmt = $pdo->prepare("INSERT INTO items (photo, keyword, current_location, found_place, comment, is_received) VALUES (?, ?, ?, ?, ?, 0)");
    $stmt->execute([$photoData, $keyword, $currentLocation, $foundPlace, $comment]);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>登録完了</title>
  <style>
    body { font-family: sans-serif; text-align: center; padding-top: 100px; }
    h2 { color: #4CAF50; margin-bottom: 30px; }
    .btn {
      background-color: #4CAF50;
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <h2>登録完了しました</h2>
  <p>ご協力ありがとうございました。</p>
  <a href="index.php"><button class="btn">戻る</button></a>
</body>
</html>