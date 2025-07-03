<<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>落し物登録</title>
  <style>
    body { font-family: sans-serif; text-align: center; padding-top: 50px; }
    label, select, input, textarea { display: block; margin: 10px auto; width: 300px; font-size: 16px; }
    .btn { padding: 10px 25px; background-color: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer; }
  </style>
</head>
<body>

<h2>落し物を登録</h2>

<form action="register_complete.php" method="POST" enctype="multipart/form-data" >
  <label>写真を追加:
    <input type="file" name="photo" accept="image/*" required>
  </label>

  <label>キーワード:
      <select name="keyword">
        <option value="">選んでください</option>

        <?php
          require 'keywords.php';
          foreach ($keywords as $keyword) {
            echo "<option value=\"{$keyword}\">{$keyword}</option>";
          }
      ?>
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
    <input type="text" name="found_place" required>
  </label>

  <label>コメント:
    <input type="text" name="comment">
  </label>

  <button class="btn" type="submit">登録する</button>
</form>

<script>
function validateForm() {
  const form = document.forms[0];
  if (!form.photo.value || !form.keyword.value || !form.current_location.value || !form.found_place.value) {
    alert("必須項目をすべて入力してください（コメントは任意です）");
    return false;
  }
  return true;
}
</script>

</body>
</html>