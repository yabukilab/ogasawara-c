<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>CSS</title>
               <link rel="stylesheet" href="check.css">
    </head>
    <body>
        
        <h1 style=" background-color: rgb(131, 130, 130);"><center>予定確認</center></h1>
        <div class="kakomi-box1">
            <font size="6">直近予定</font>
          
            <button  onclick="location.href='./test.php'" 
                   class="container">
        <a href="#" class="btn-push7">&emsp;グラフを見る&emsp;</a>
        </botton>

        <br>
        <?php
        
//データベース接続設定
require 'db.php';
//データベースへの接続
$db = new PDO($dsn, $dbUser, $dbPass);
$sql = 'SELECT * FROM itemtable 
where userid = 1942001
order by date
LIMIT 1,3';
$prepare = $db->prepare($sql);
$prepare->execute();
$result = $prepare->fetchAll(PDO::FETCH_ASSOC);
echo '<table border="1">';
foreach ($result as $r) {
echo '<tr>';
switch ($r['category']) {
    case "仕事":
        echo '  <th><font color=#66CCFF>';
        break;
    case "課題":
        echo '  <th><font color=#00CC66>';
        break;
    case "買い物":
        echo '  <th><font color=#FFCC33>';
        break;
    case "遊び":
        echo '  <th><font color=#CCCC33>';
        break;
    case "その他":
        echo '  <th><font color=#CCCCCC>';
        break;
}
echo '<font size ="6">';
echo $r['category'];
echo '  </th>';
echo '  <th>';
echo '<font size ="6">';
echo $r['contents'];
echo '  </th>';
echo '  <th>';
echo '<font size ="6">';
echo $r['date'];
echo '  </th>';
echo '<tr>';
}
echo '</table>';
?>   
 
        </div> 
        <button  onclick="location.href='./jobs.php'" 
                   class="btn-push0">仕事</button>
            <br><br><br>
        <button  onclick="location.href='./subject.php'" 
                   class="btn-push2">課題</button>
            <br><br><br>
            <button  onclick="location.href='./shop.php'"
            class="btn-push3">買い物</button>
                <br><br><br>
            <button  onclick="location.href='./play.php'"
            class="btn-push4">遊び</button>
                    <br><br>  
            <button  onclick="location.href='./history.php'"
            class="btn-push6">履歴↻</button>
                    <br>
            <button  onclick="location.href='./spare.php'"
            class="btn-push4">その他</button>
                      <br><br>

            <button  onclick="location.href='./submit2.php'"
            class="btn-push6">ホーム画面</button>
                        <br>            

                      
    


    </body>
</html>