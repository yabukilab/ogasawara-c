<?php

$dbServer = isset($_ENV['MYSQL_SERVER'])    ? $_ENV['MYSQL_SERVER']      : '127.0.0.1';
$dbUser   = isset($_SERVER['MYSQL_USER'])   ? $_SERVER['MYSQL_USER']     : 'root';
$dbPass   = isset($_SERVER['MYSQL_PASSWORD']) ? $_SERVER['MYSQL_PASSWORD'] : '';
$dbName   = isset($_SERVER['MYSQL_DB'])     ? $_SERVER['MYSQL_DB']       : 'mydb';

try {
    $pdo = new PDO("mysql:host=$dbServer;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "DB接続成功しました！";
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}
?>
