<?php
//データベース接続設定
$dbServer = '127.0.0.1';
$dbName = 'ogasawarac';
$dsn = "mysql:host={$dbServer};
dbname={$dbName};
charset=utf8";
$dbUser = 'test';
$dbPass = 'pass';
$db = new PDO($dsn, $dbUser, $dbPass);
//検索実行
$sql = 'select * from itemtable';
$stmt = $dbh->query($sql);
foreach ($stmt as $row) {
 echo $row['name'].'：'.$row['population'].'人';
 echo '<br>';
}
?>