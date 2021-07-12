<?php
session_start(); // セッションを開始する．
if (!isset($_SESSION['userid'])) { // ログインしていないなら，
  header('Location: index.php');     // ログインページへ転送する．
}
$userid = $_SESSION['userid']; // ユーザ名を思い出す．
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>入力画面</title>
  <link rel="stylesheet" href="input.css">
</head>
  <body>
  <h1 style=" background-color: rgb(131, 130, 130); text-align: center;">
      予定確認</h1>
  
  <div class="input1-box" style="text-align: center;">
  <form action="list.php" method="post">
  <div style="background-color: rgb(130, 131, 130);  color:#fff; margin:auto; width:45.5%; font-size:2em;" 
          class="input1-box;">予定名</div>
  <div><input type="text"  style= "width:45%; height:3em; font-size:1em;" name="予定"/></div>
  <div style="background-color: rgb(130, 131, 130);  color:#fff; margin:auto; width:45.5%; font-size:2em;" 
          class="input1-box;">カテゴリ選択</div> 
  <div  style="margin:auto; width:45.5%; font-size:2em;"> 
      <input type="checkbox"  name="category" value="仕事" />仕事
     
      <input type="checkbox"  name="category" value="課題" />課題
      
      <input type="checkbox"  name="category" value="買い物" />買い物
      
      <input type="checkbox"  name="category" value="遊び" />遊び
      
      <input type="checkbox"  name="category" value="その他" />その他
  </div>
  <div style="background-color: rgb(130, 131, 130);  color:#fff; margin:auto; width:45.5%; font-size:2em;" 
          class="input1-box;">期日</div>
      <input name="date" style="margin:auto; width:45%; font-size:2em;" type="date"/>
   <div  class="input4-box;" style= "height:2em;">
      <input type="submit" style= "height:2em; font-size:1em;" value="登録"/>
</div>
</form>
<p>
＊期日欄注意
</p>
デスクトップ：siri,IE,一部のFirefoxは手動入力
</p>
<p>
モバイル：iOS Safariは手動入力
</p>
</body>
</html>