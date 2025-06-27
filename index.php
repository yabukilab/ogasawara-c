<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>落し物管理システム</title>
  <style>
    body { font-family: sans-serif; text-align: center; padding-top: 100px; }
    h1 { margin-bottom: 100px; }
    .btn {
      font-size: 20px;
      padding: 20px 40px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin: 0 20px;
      color: white;
    }
    .btn-search { background-color: #4CAF50; }
    .btn-register { background-color: #f44336; }
    .note { color: red; margin-top: 10px; }
  </style>
</head>
<body>
  <h1>落し物管理システム</h1>
  <div>
    <button class="btn btn-search" onclick="location.href='search.php'">検索する</button>
    <button class="btn btn-register" onclick="location.href='register.php'">登録する</button>
  </div>
  <p class="note">金銭を扱う貴重品は安全が確保できないため取り扱えません</p>
</body>
</html>