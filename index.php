<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>落し物管理システム</title>
  <style>
    body {
      font-family: sans-serif;
      text-align: center;
      padding-top: 100px;
    }
    h1 {
      margin-bottom: 50px;
    }
    .btn {
      padding: 15px 30px;
      font-size: 18px;
      margin: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .search-btn {
      background-color: #4CAF50;
      color: white;
    }
    .register-btn {
      background-color: #f44336;
      color: white;
    }
    .note {
      margin-top: 10px;
      color: #888;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <h1>落し物管理システム</h1>

  <a href="search.php"><button class="btn search-btn">検索する</button></a>
  <a href="register.php"><button class="btn register-btn">登録する</button></a>

  <div class="note">
    ※金銭を扱う貴重品は安全が確保できないため取り扱えません
  </div>
</body>
</html>