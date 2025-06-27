<?php
$host = 'localhost';
$dbname = 'mydb';  // あなたのデータベース名
$user = 'root';
$pass = ''; // XAMPPの初期設定では空

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "DB接続成功しました！"; // ← 本番ではコメントアウト推奨
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}
?>