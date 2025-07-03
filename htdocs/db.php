<?php

$dbServer = isset($_ENV['MYSQL_SERVER'])    ? $_ENV['MYSQL_SERVER']      : '127.0.0.1';
$dbUser   = isset($_SERVER['MYSQL_USER'])   ? $_SERVER['MYSQL_USER']     : 'root';
$dbPass   = isset($_SERVER['MYSQL_PASSWORD']) ? $_SERVER['MYSQL_PASSWORD'] : '';
$dbName   = isset($_SERVER['MYSQL_DB'])     ? $_SERVER['MYSQL_DB']       : 'mydb';

try {
    $pdo = new PDO("mysql:host=$dbServer;dbname=$dbName;charset=utf8", $dbUser, $dbPass); // PDOを使ってMySQLデータベースに接続（ホスト、データベース名、文字コード、ユーザー名、パスワードを指定）
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // エラーモードを「例外を投げる」に設定（エラーが起きた際に例外で処理できるようにする）
} catch (PDOException $e) { // DB接続に失敗した場合は、エラーメッセージを表示してスクリプトを終了
    exit('DB接続エラー: ' . $e->getMessage());
}
?>
