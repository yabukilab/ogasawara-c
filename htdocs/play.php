<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>遊び確認</title>
               <link rel="stylesheet" href="jobs.css" >
    </head>
    <body>
        <h1 style="background-color: rgb(130, 131, 130);">
        <center>予定確認</center></h1>

      <div class="play2-box">
        <div class="play1-box"　
           style="background-color: rgb(144, 238, 144);">
        <center>遊び</center>
        </div>
      </div>
      <div class="hyou4">
        <style>
         section {
	        overflow: scroll;
 	        margin: 10px auto;
	        padding: 100px;
	        width: 1000px;
	        height: 200px;
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
          $sql = 'SELECT * FROM itemtable where userid = 1942001
          and status="確認"
          and category="遊び"
          ORDER BY date';
          $prepare = $db->prepare($sql);
          $prepare->execute();
          $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
  
          echo '<table border="0">';
        
          
  foreach ($result as $r) {
  echo '<tr >';
  switch ($r['category']) {
      case "遊び":
          echo '  <th><font color=#66CCFF>';
          break;
  }
 
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
           <div class="container1">
             <a href="check.php" class="btn-border">前の画面へ戻る</a>
           </div>
        </div>


   </body>
</html>
