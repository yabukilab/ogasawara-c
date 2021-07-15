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
$dbServer = '127.0.0.1';
$dbName = 'mydb';
$dsn = "mysql:host={$dbServer};
dbname={$dbName};
charset=utf8";
$dbUser = 'test';
$dbPass = 'pass';
//データベースへの接続
$db =  PDO($dsn, $dbUser, $dbPass);
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
        <div class="container">
            <a href="http://localhost/new/jobs.php" class="btn-push0">仕&emsp;事</a>
            </div>
            <br><br><br>
    <div class="container">
        
            <a href="http://localhost/new/subject.php" class="btn-push2">課&emsp;題</a>
            </div>
            <br><br><br>
    <div class="container">
                <a href="http://localhost/new/shop.php" class="btn-push3">買い物</a>
                </div>
                <br><br><br>
    <div class="container">
                    <a href="http://localhost/new/play.php" class="btn-push4">遊&emsp;び</a>
                    </div>
                    <br><br>  
    <div class="container">
                    <div class="container">
                    <a href="http://localhost/new/history.php" class="btn-push6">&emsp;&emsp;履歴↻&emsp;&emsp;</a>
                     </div>
                    <br>
    <div class="container">
                     <a href="http://localhost/new/spare.php" class="btn-push5">その他</a>
                      </div>
                      <br><br>

     <div class="container">
                        <a href="http://localhost/new/submit2.php" class="btn-push6">&emsp;ホーム画面&emsp;</a>
                        </div>
                        <br>            

                      
    


    </body>
</html>