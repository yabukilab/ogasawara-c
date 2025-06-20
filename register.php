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
        <option value="財布">財布</option>
        <option value="学生証">学生証</option>
        <option value="傘">傘</option>
        <option value="文房具">文房具</option>
      </select>
    </label>

    <label>現在の場所:
      <select name="currentLocation">
        <option value="">選んでください</option>
        <option value="C棟">C棟</option>
        <option value="D棟">D棟</option>
        <option value="E棟">E棟</option>
        <option value="図書館">図書館</option>
      </select>
    </label>

    <label>見つけた場所:
      <input type="text" name="foundPlace">
    </label>

    <label>コメント:
      <input type="text" name="comment">
    </label>

    <button class="btn" type="submit">登録する</button>
  </form>

  <script>
    function validateForm() {
      const keyword = document.querySelector('select[name="keyword"]').value;
      const currentLocation = document.querySelector('select[name="currentLocation"]').value;
      const foundPlace = document.querySelector('input[name="foundPlace"]').value;
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