<?php
$host = 'localhost';
$dbname = 'mydb'; // あなたのDB名
$user = 'root';
$pass = ''; // パスワードがない場合は空文字

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "DB接続成功しました！";
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}
?>