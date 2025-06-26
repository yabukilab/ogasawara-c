<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>落し物登録</title>
  <style>
    body {
      font-family: sans-serif;
      text-align: center;
      padding-top: 50px;
    }
    h2 {
      margin-bottom: 30px;
    }
    label, select, input, textarea {
      display: block;
      margin: 10px auto;
      width: 300px;
      font-size: 16px;
    }
    .btn {
      padding: 10px 25px;
      background-color: #f44336;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <h2>落し物を登録</h2>

  <form action="register_complete.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
    <label>写真を追加:
      <input type="file" name="photo" accept="image/*">
    </label>

    <label>キーワード:
      <select name="keyword">
        <option value="">選んでください</option>
        <option value="筆記用具">筆記用具</option>
        <option value="学生証">学生証</option>
        <option value="傘">傘</option>
        <option value="ノート">ノート</option>
        <option value="ファイル">ファイル</option>
        <option value="ハンカチ">ハンカチ</option>
        <option value="衣類">衣類</option>
        <option value="バッグ">バッグ</option>
        <option value="電子機器">電子機器</option>
         <option value="水筒">水筒</option>
        <option value="キーホルダ">キーホルダ</option>
        <option value="コード類">コード類</option>
        <option value="3DS">3DS</option>
        <option value="その他">その他</option>
      </select>
    </label>

    <label>現在の場所:
      <select name="current_location">
        <option value="">選んでください</option>
        <option value="教務課">教務課</option>
        <option value="見つけた場所">見つけた場所</option>
      </select>
    </label>

    <label>見つけた場所:
      <input type="text" name="found_place">
    </label>

    <label>コメント:
      <input type="text" name="comment">
    </label>

    <button class="btn" type="submit">登録する</button>
  </form>

  <script>
    function validateForm() {
      const keyword = document.querySelector('select[name="keyword"]').value;
      const currentLocation = document.querySelector('select[name="current_location"]').value;
      const foundPlace = document.querySelector('input[name="found_place"]').value;
      const photo = document.querySelector('input[name="photo"]').value;

      if (!keyword || !currentLocation || !foundPlace || !photo) {
        alert("すべての必須項目を入力してください（コメントは任意）");
        return false;
      }
      return true;
    }
  </script>

</body>
</html>