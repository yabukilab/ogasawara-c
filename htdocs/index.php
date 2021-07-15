<?php
session_start(); 
$message = 'ログインしてください．'; // デフォルトメッセージ

if (isset($_POST['userid'], $_POST['password'])) {
  $userid = $_POST['userid']; 
  $password = $_POST['password']; 
 //DBの接続とDBhへの登録//
 require 'db.php';
  $sql = 'select * from ogasawarac where userid= "'.$userid.'" && passwd="'.$password.'"';
  $prepare = $db->prepare($sql);
  $prepare->execute();
  $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
  if($result != null){
    session_regenerate_id();  // セッションを作り直す
    $_SESSION['userid'] = $userid;
    header('Location: submit2.php');
  } else { 
    $message = "ユーザ名またはパスワードが違います．";
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
  <link rel="stylesheet" href="index.css" >
</head>

<body>
  <h1 style="text-align:center; background-color: rgb(130, 131, 130);">
     ログイン画面</h1>
 
  <h2 style="background-color: #fff; 
             text-align: center;">
             
    <?php echo $message; ?></h2>
  
  <div style="text-align: center;">
    <form action="index.php" method="post">
     <div style="background-color: rgb(130, 131, 130);  color:#fff; margin:auto; width:46%; font-size:2em;" 
          class="index4-box;">ユーザID</div>
     <div>
     <input class="index1-box;" type="text"  style= "width:45.5%; height:3em; font-size:1em;"
            name="userid" placeholder="ユーザID"/></div>
     <div style="background-color: rgb(130, 131, 130);  color:#fff; margin:auto; width:46%; font-size:2em;"
          class="index4-box;">パスワード</div>
     <div>
     <input class="index2-box;" type="password"  style= "width:45.5%; height:3em; font-size:1em;"
            name="password" placeholder="パスワード"/></div>
    
    <div class="index3-box;" style= "height:2em;">
    <input type="submit" style= "height:3em; font-size:1em;" value="ログイン" /></div>
    
    </form>
  </div>
</body>
</html>
