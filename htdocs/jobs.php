<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>仕事確認</title>
               <link rel="stylesheet" href="jobs.css" >
    </head>
    <body>
        <h1 style="background-color: rgb(130, 131, 130);">
        <center>予定確認</center></h1>

      <div class="jobs2-box">
        <div class="jobs1-box"　
           style="background-color: #70c6ffc2;">
        <center>仕事</center>
        </div>
      </div>
      <div class="hyou1">
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
          and category="仕事"
          ORDER BY date';
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
            <button  onclick="location.href='./check.php'" 
                   class="container">
            <a href="#" class="btn-push1">&emsp;前の画面へ&emsp;</a>
          </botton>
   </body>
</html>
