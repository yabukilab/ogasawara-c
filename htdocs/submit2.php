<?php
session_start(); // セッションを開始する．
if (!isset($_SESSION['userid'])) { // ログインしていないなら，
  header('Location: index.php');     // ログインページへ転送する．
}
$userid = $_SESSION['userid']; // ユーザ名を思い出す．
?>

<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ホーム画面</title>
  <link rel="stylesheet" href="submit.css">
</head>
<body>
    <h1 style="background-color: rgb(131, 130, 130)"> 
    TODO管理システム</h1>

    <button  onclick="location.href='./input.php'" 
             class="container">
    <a href="#" class="btn-push0"
       style="background-color: #928f92c2 " >予定入力</a>
    </botton>
    
    
    <button  onclick="location.href='./check.php'" 
             class="container">
    <a href="#" class="btn-push1"
       style="background-color: #928f92c2">予定確認</a>
    </botton>
      
</body>
</html>