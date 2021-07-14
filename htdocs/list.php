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
    <meta charset='utf-8' />
    <title>登録画面</title>
  </head>

  <body>
  <h1 style=" background-color: rgb(131, 130, 130); color:#fff; text-align: center;">
      登録画面</h1>

  <div style="text-align: center;">
  <form action="finish.php" method="post">
  <div style="background-color: #fff;  color:#000000; margin:auto; width:45.5%; font-size:2em;">
    ■予定名：<?php print($_POST["予定"]); ?></div><br>
  <div style="background-color: #fff;  color:#000000; margin:auto; width:45.5%; font-size:2em;">  
 　 ■カテゴリ： <?php
     if ($_POST["category"] != False) { print($_POST["category"]."<br>"); }
    ?></div><br>
  <div style="background-color: #fff;  color:#000000; margin:auto; width:45.5%; font-size:2em;">  
    ■期日：<?php print($_POST["date"]); ?></div><br>

<?php
  $userid = $_SESSION['userid'];
  $contents = $_POST['予定']; 
  $category = $_POST['category']; 
  $date= $_POST['date']; 
  $status="確認";
  require 'db.php'; 
  $sql = "insert into itemtable (userid, contents, category, date, status) 
                      values (:userid,:contents, :category, :date,:status)";
  $prepare = $db->prepare($sql); 
  $prepare->bindValue(':userid', $userid, PDO::PARAM_STR);
  $prepare->bindValue(':contents', $contents, PDO::PARAM_STR); 
  $prepare->bindValue(':category', $category, PDO::PARAM_STR); 
  $prepare->bindValue(':date', $date, PDO::PARAM_STR); 
  $prepare->bindValue(':status', $status, PDO::PARAM_STR);
  $prepare->execute(); 
 ?>
<input type="reset" style= "height:2em; font-size:1em;" value="戻る" />
<input type="submit"style= "height:2em; font-size:1em;" value="完了" />
 </form>
</div>
  </body>

</html>
