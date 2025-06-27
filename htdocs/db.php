<?php
// サーバー環境に合わせて必要なら127.0.0.1に変更
$host = '127.0.0.1'; // ←または 'localhost'
$dbname = 'mydb';    // ←あなたが実際に作ったデータベース名に合わせてね
$user = 'root';      // ←サーバーのMySQLユーザー名（例：'root' じゃないかも）
$pass = '';          // ←パスワードがあるなら書く、なければ空のまま

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "DB接続成功しました！"; ← もう表示しないようにコメントアウト
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}
?>