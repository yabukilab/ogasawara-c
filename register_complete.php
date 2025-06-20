<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $keyword = $_POST['keyword'];
  $currentLocation = $_POST['currentLocation'];
  $foundPlace = $_POST['foundPlace'];
  $comment = $_POST['comment'];

  // 写真の保存
  $photoPath = '';
  if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    $photoName = time() . "_" . basename($_FILES['photo']['name']);
    $photoPath = $uploadDir . $photoName;
    move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);
  }

  // DB登録
  $stmt = $pdo->prepare("INSERT INTO items (photo, keyword, current_location, found_place, comment) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$photoPath, $keyword, $currentLocation, $foundPlace, $comment]);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>登録完了</title>
  <style>
    body {
      font-family: sans-serif;
      text-align: center;
      padding-top: 100px;
    }
    h2 {
      color: #4CAF50;
      margin-bottom: 30px;
    }
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