<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>履歴確認</title>
               <link rel="stylesheet" href="jobs.css" >
    </head>
    <body>
        <h1 style="background-color: rgb(130, 131, 130);">
        <center>履歴確認</center></h1>

        <div class="history2-box">
        <div class="history1-box";>
        <span style="color:white">
        aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
        </span> 
      </div>
      </div>
      <div class="hyou7">
        <style>
         section {
          margin: 0em auto;
      padding: 0m;
      width: auto;
      height: auto;
	        overflow: scroll;
 	        
	        border: 2px solid #ccc;} 
          p {	width: 5px;
              }
          figure { width: 30px;}
        </style>
         <section>
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
        $db = new PDO($dsn, $dbUser, $dbPass);
        $sql = 'SELECT * FROM itemtable where userid = 1942001 and status="完了" ORDER BY date ';
        $prepare = $db->prepare($sql);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);

        echo '<table border="0">';
      
        
foreach ($result as $r) {
echo '<tr >';
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
echo '<font size ="6" >';
echo $r['category'];
echo '  </th>';
echo '  <th >';
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

         </section>
         
         <div class="jobs3-box">
         <button  onclick="location.href='./check.php'" 
                  class="container1">
           <a href="#" class="btn-border">  
             前の画面へ戻る</a>
         </botton>           
         </div>
   </body>
</html>
